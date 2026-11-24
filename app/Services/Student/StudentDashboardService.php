<?php

namespace App\Services\Student;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Servicio del modulo Estudiante.
 *
 * Centraliza las consultas parametrizadas del estudiante (aislado por student_id)
 * y la sanitizacion de salida a texto plano. Disenado como capa puente limpia
 * para delegar a los DAOs centralizados de Gabriel sin tocar app/DAOs ni app/Models.
 */
class StudentDashboardService
{
    public const ROLE_STUDENT = 'Student';

    /**
     * Resuelve el ID del usuario autenticado (compatible con Auth::id() o sesion).
     */
    public function resolveAuthenticatedStudentId(Request $request): ?int
    {
        $authId = Auth::id();
        if (is_numeric($authId) && (int) $authId > 0) {
            return (int) $authId;
        }

        foreach (['user_id', 'auth_user_id'] as $sessionKey) {
            $sessionId = $request->session()->get($sessionKey);
            if (is_numeric($sessionId) && (int) $sessionId > 0) {
                return (int) $sessionId;
            }
        }

        return null;
    }

    /**
     * Verifica que el usuario exista, este Approved y posea el rol Student activo.
     */
    public function hasActiveStudentRole(int $userId): bool
    {
        return DB::table('user_account as ua')
            ->join('user_role as ur', 'ur.user_id', '=', 'ua.id')
            ->join('system_role as sr', 'sr.id', '=', 'ur.role_id')
            ->where('ua.id', $userId)
            ->where('ua.status', 'Approved')
            ->where('ur.is_active', true)
            ->where('sr.role_name', self::ROLE_STUDENT)
            ->exists();
    }

    /**
     * Verifica que una sesion de clase pertenezca a una seccion donde este estudiante esta inscrito.
     */
    public function studentOwnsSession(int $studentId, int $sessionId): bool
    {
        return DB::table('class_session as cs')
            ->join('section_enrollment as se', 'se.section_id', '=', 'cs.section_id')
            ->where('cs.id', $sessionId)
            ->where('se.student_id', $studentId)
            ->whereIn('se.status', ['Enrolled', 'Approved', 'Failed', 'Pending'])
            ->exists();
    }

    /**
     * Construye todos los datos sanitizados del panel del estudiante.
     *
     * @param  array<string, mixed>  $filters
     * @return array<string, mixed>
     */
    public function getDashboardData(int $studentId, array $filters = []): array
    {
        $account = DB::table('user_account as ua')
            ->join('profile as p', 'p.id', '=', 'ua.profile_id')
            ->leftJoin('career as c', 'c.id', '=', 'p.career_id')
            ->join('user_role as ur', 'ur.user_id', '=', 'ua.id')
            ->join('system_role as sr', 'sr.id', '=', 'ur.role_id')
            ->where('ua.id', $studentId)
            ->where('ua.status', 'Approved')
            ->where('ur.is_active', true)
            ->where('sr.role_name', self::ROLE_STUDENT)
            ->select([
                'ua.id as user_id',
                'ua.username',
                'ua.email',
                'ua.qr_token',
                'ua.status as account_status',
                'p.id_number',
                'p.id_type',
                'p.first_name',
                'p.middle_name',
                'p.last_name',
                'p.second_last_name',
                'p.current_semester',
                'p.has_dragged_subjects',
                'p.profile_picture',
                'c.career_name',
                'c.career_code',
                'ur.credential_number',
                'ur.credential_issued_at',
                'ur.credential_expires_at',
            ])
            ->first();

        abort_if($account === null, 403, 'Acceso denegado: el usuario no posee un perfil de estudiante activo.');

        $periods = DB::table('academic_period')
            ->orderByDesc('start_date')
            ->select(['id', 'period_name', 'status'])
            ->get()
            ->map(fn (object $row): array => [
                'id' => (int) $row->id,
                'nombre' => StudentInputSanitizer::plainText($row->period_name, 50),
                'estado' => StudentInputSanitizer::plainText($row->status, 20),
            ])
            ->all();

        $activePeriod = $this->resolveSelectedPeriod($periods, isset($filters['period_id']) ? (int) $filters['period_id'] : null);

        $enrollmentsQuery = DB::table('section_enrollment as se')
            ->join('section as sec', 'sec.id', '=', 'se.section_id')
            ->join('subject as sub', 'sub.id', '=', 'sec.subject_id')
            ->join('user_account as ta', 'ta.id', '=', 'sec.teacher_id')
            ->join('profile as tp', 'tp.id', '=', 'ta.profile_id')
            ->where('se.student_id', $studentId)
            ->whereNotIn('se.status', ['Withdrawn', 'Rejected'])
            ->orderBy('sub.display_order')
            ->orderBy('sub.subject_code')
            ->select([
                'se.id as enrollment_id',
                'se.section_id',
                'se.period_id',
                'se.status as enrollment_status',
                'se.is_dragged',
                'se.final_grade',
                'sec.section_name',
                'sec.classroom',
                'sec.day_of_week',
                'sec.start_time',
                'sec.end_time',
                'sub.subject_code',
                'sub.subject_name',
                'tp.first_name as teacher_first_name',
                'tp.last_name as teacher_last_name',
            ]);

        if ($activePeriod !== null) {
            $enrollmentsQuery->where('se.period_id', $activePeriod['id']);
        }

        if (! empty($filters['subject_code'])) {
            $enrollmentsQuery->where('sub.subject_code', $filters['subject_code']);
        }

        if (! empty($filters['status'])) {
            $enrollmentsQuery->where('se.status', $filters['status']);
        }

        $enrollmentRows = $enrollmentsQuery->get();
        $sectionIds = $enrollmentRows->pluck('section_id')->unique()->values()->all();

        // Conteo de sesiones y asistencias del estudiante por seccion (evitando N+1).
        $sessionCounts = [];
        $attendedCounts = [];

        if ($sectionIds !== []) {
            $sessionCounts = DB::table('class_session')
                ->whereIn('section_id', $sectionIds)
                ->selectRaw('section_id, COUNT(*) as total_sessions')
                ->groupBy('section_id')
                ->pluck('total_sessions', 'section_id')
                ->all();

            $attendedCounts = DB::table('attendance as a')
                ->join('class_session as cs', 'cs.id', '=', 'a.session_id')
                ->where('a.student_id', $studentId)
                ->whereIn('cs.section_id', $sectionIds)
                ->whereIn('a.attendance_status', ['Present', 'Late', 'Excused'])
                ->selectRaw('cs.section_id, COUNT(*) as attended_sessions')
                ->groupBy('cs.section_id')
                ->pluck('attended_sessions', 'section_id')
                ->all();
        }

        $totalSessionsAll = 0;
        $totalAttendedAll = 0;
        $grades = [];
        $asignaturas = [];

        foreach ($enrollmentRows as $row) {
            $sectionId = (int) $row->section_id;
            $totalSessions = (int) ($sessionCounts[$sectionId] ?? 0);
            $attendedSessions = min($totalSessions, (int) ($attendedCounts[$sectionId] ?? 0));

            $totalSessionsAll += $totalSessions;
            $totalAttendedAll += $attendedSessions;

            $percentage = $totalSessions > 0
                ? (int) round(($attendedSessions / $totalSessions) * 100)
                : 100;

            if ((int) $row->final_grade > 0) {
                $grades[] = (int) $row->final_grade;
            }

            [$barra, $texto, $estado] = $this->resolveAttendanceStyling($percentage);

            $teacherName = StudentInputSanitizer::plainText(
                trim('Prof. '.$row->teacher_first_name.' '.$row->teacher_last_name),
                120
            );

            $asignaturas[] = [
                'section_id' => $sectionId,
                'codigo' => StudentInputSanitizer::plainText($row->subject_code, 20),
                'nombre' => StudentInputSanitizer::plainText($row->subject_name, 100),
                'seccion' => StudentInputSanitizer::plainText($row->section_name, 30),
                'profesor' => $teacherName,
                'aula' => StudentInputSanitizer::plainText($row->classroom, 50),
                'porcentaje' => $percentage,
                'asistidas' => $attendedSessions.'/'.$totalSessions.' asistidas',
                'barra' => $barra,
                'texto' => $texto,
                'estado' => $estado,
            ];
        }

        $globalAttendance = $totalSessionsAll > 0
            ? round(($totalAttendedAll / $totalSessionsAll) * 100, 1)
            : 100.0;

        $averageGrade = $grades !== []
            ? number_format(array_sum($grades) / count($grades), 2, '.', '')
            : '0.00';

        // Sesiones con inasistencia del estudiante para facilitar el envio de justificativos.
        $absentSessions = DB::table('attendance as a')
            ->join('class_session as cs', 'cs.id', '=', 'a.session_id')
            ->join('section as sec', 'sec.id', '=', 'cs.section_id')
            ->join('subject as sub', 'sub.id', '=', 'sec.subject_id')
            ->where('a.student_id', $studentId)
            ->where('a.attendance_status', 'Absent')
            ->orderByDesc('cs.session_date')
            ->limit(15)
            ->select([
                'cs.id as session_id',
                'cs.session_date',
                'sub.subject_code',
                'sub.subject_name',
            ])
            ->get()
            ->map(fn (object $row): array => [
                'id' => (int) $row->session_id,
                'fecha' => StudentInputSanitizer::plainText($row->session_date, 20),
                'etiqueta' => StudentInputSanitizer::plainText(
                    $row->subject_code.' · '.$row->subject_name.' ('.$row->session_date.')',
                    160
                ),
            ])
            ->all();

        // Justificativos/documentos propios del estudiante.
        $justificativos = DB::table('document_registration')
            ->where('user_id', $studentId)
            ->orderByDesc('uploaded_at')
            ->limit(10)
            ->select(['id', 'file_name', 'file_type', 'status', 'observations', 'uploaded_at'])
            ->get()
            ->map(fn (object $doc): array => [
                'id' => (int) $doc->id,
                'archivo' => StudentInputSanitizer::plainText($doc->file_name, 120),
                'tipo' => StudentInputSanitizer::plainText($doc->file_type, 20),
                'estado' => StudentInputSanitizer::plainText($doc->status, 20),
                'observaciones' => StudentInputSanitizer::plainText($doc->observations, 500),
                'fecha' => StudentInputSanitizer::plainText((string) $doc->uploaded_at, 30),
            ])
            ->all();

        $fullName = StudentInputSanitizer::plainText(
            implode(' ', array_filter([
                $account->first_name,
                $account->middle_name,
                $account->last_name,
                $account->second_last_name,
            ])),
            200
        );

        $formattedCedula = StudentInputSanitizer::formatCedula(
            (string) $account->id_type,
            (string) $account->id_number
        );

        $careerName = StudentInputSanitizer::plainText($account->career_name ?? 'Sin carrera asignada', 100);
        $semesterOrdinal = $this->formatSemesterOrdinal((int) $account->current_semester);
        $periodName = $activePeriod['nombre'] ?? 'Sin período activo';
        $hasDragged = (bool) $account->has_dragged_subjects;
        $credentialNumber = StudentInputSanitizer::plainText(
            $account->credential_number ?: 'UNEFA-EST-'.str_pad((string) $studentId, 5, '0', STR_PAD_LEFT),
            50
        );
        $qrToken = StudentInputSanitizer::plainText((string) $account->qr_token, 128);

        return [
            'estudiante' => [
                'nombre' => $fullName,
                'cedula' => $formattedCedula,
                'carrera' => $careerName,
                'carrera_mayusculas' => mb_strtoupper($careerName, 'UTF-8'),
                'semestre_ordinal' => $semesterOrdinal,
                'departamento' => $careerName.' · '.$semesterOrdinal.' Semestre',
                'subtitulo' => 'Matrícula Oficial '.$periodName,
                'insignia' => $hasDragged ? 'ESTUDIANTE CON ARRASTRE' : 'ESTUDIANTE REGULAR',
                'condicion' => $hasDragged ? 'CONDICIÓN: REGULAR CON ARRASTRE' : 'CONDICIÓN: REGULAR ACTIVO',
                'matricula' => $credentialNumber,
                'qr_token' => $qrToken,
                'qr_resumen' => mb_substr($qrToken, 0, 18, 'UTF-8'),
                'foto' => StudentInputSanitizer::plainText($account->profile_picture ?? '', 255),
            ],
            'periodo' => [
                'id' => $activePeriod['id'] ?? null,
                'nombre' => $periodName,
            ],
            'periodos' => $periods,
            'filtros' => [
                'period_id' => $activePeriod['id'] ?? null,
                'subject_code' => StudentInputSanitizer::plainText($filters['subject_code'] ?? '', 20),
                'status' => StudentInputSanitizer::plainText($filters['status'] ?? '', 20),
            ],
            'metricas' => [
                'semestre' => $semesterOrdinal,
                'materias_inscritas' => (string) count($asignaturas),
                'promedio_general' => $averageGrade,
                'asistencia_global' => $globalAttendance,
                'asistencia_global_texto' => number_format($globalAttendance, 1, '.', '').'%',
                'es_solvente' => $globalAttendance >= 75.0 && ! $hasDragged,
            ],
            'asignaturas' => $asignaturas,
            'sesionesAusentes' => $absentSessions,
            'justificativos' => $justificativos,
        ];
    }

    /**
     * Registra un justificativo de inasistencia en document_registration
     * exclusivamente para el estudiante autenticado.
     *
     * @param  array<string, mixed>  $validated
     */
    public function storeJustification(int $studentId, array $validated, UploadedFile $file): int
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin');
        $safeOriginalName = StudentInputSanitizer::plainText($file->getClientOriginalName(), 200);
        if ($safeOriginalName === '') {
            $safeOriginalName = 'justificativo.'.$extension;
        }

        $storedFileName = Str::uuid()->toString().'.'.$extension;
        $storedPath = $file->storeAs('justificativos/student_'.$studentId, $storedFileName, 'local');

        $observations = StudentInputSanitizer::plainText($validated['observations'] ?? '', 500);
        if (! empty($validated['session_id'])) {
            $prefix = '[Sesión #'.(int) $validated['session_id'].'] ';
            $observations = mb_substr($prefix.$observations, 0, 500, 'UTF-8');
        }

        return (int) DB::table('document_registration')->insertGetId([
            'user_id' => $studentId,
            'file_name' => $safeOriginalName,
            'file_path' => StudentInputSanitizer::plainText((string) $storedPath, 255),
            'file_type' => StudentInputSanitizer::plainText($validated['file_type'], 20),
            'status' => 'Pending',
            'observations' => $observations,
            'uploaded_at' => now(),
        ]);
    }

    /**
     * @param  array<int, array{id: int, nombre: string, estado: string}>  $periods
     * @return array{id: int, nombre: string, estado: string}|null
     */
    private function resolveSelectedPeriod(array $periods, ?int $requestedPeriodId): ?array
    {
        if ($periods === []) {
            return null;
        }

        if ($requestedPeriodId !== null && $requestedPeriodId > 0) {
            foreach ($periods as $period) {
                if ($period['id'] === $requestedPeriodId) {
                    return $period;
                }
            }
        }

        foreach ($periods as $period) {
            if ($period['estado'] === 'Active') {
                return $period;
            }
        }

        return $periods[0];
    }

    /**
     * @return array{0: string, 1: string, 2: string}
     */
    private function resolveAttendanceStyling(int $percentage): array
    {
        if ($percentage >= 90) {
            return ['bg-unefa-green', 'text-emerald-700', 'success'];
        }

        if ($percentage >= 75) {
            return ['bg-unefa-goldDark', 'text-amber-700', 'warning'];
        }

        return ['bg-slate-500', 'text-slate-700', 'info'];
    }

    private function formatSemesterOrdinal(int $semester): string
    {
        return match ($semester) {
            1 => '1ro',
            2 => '2do',
            3 => '3ro',
            4 => '4to',
            5 => '5to',
            6 => '6to',
            7 => '7mo',
            8 => '8vo',
            9 => '9no',
            10 => '10mo',
            default => $semester > 0 ? $semester.'mo' : '1ro',
        };
    }
}
