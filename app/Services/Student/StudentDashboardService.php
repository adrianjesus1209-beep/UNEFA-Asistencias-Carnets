<?php

namespace App\Services\Student;

use App\DAO\Contracts\AcademicPeriodDAOInterface;
use App\DAO\Contracts\AttendanceDAOInterface;
use App\DAO\Contracts\SectionEnrollmentDAOInterface;
use App\DAO\Contracts\UserAccountDAOInterface;
use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

/**
 * Servicio del modulo Estudiante.
 *
 * Delega el acceso a datos a los DAOs y se enfoca en orquestar datos,
 * metricas, sanitizacion y almacenamiento de archivos.
 */
class StudentDashboardService
{
    public const ROLE_STUDENT = 'Student';

    public function __construct(
        private readonly UserAccountDAOInterface $userAccountDAO,
        private readonly AcademicPeriodDAOInterface $academicPeriodDAO,
        private readonly SectionEnrollmentDAOInterface $sectionEnrollmentDAO,
        private readonly AttendanceDAOInterface $attendanceDAO
    ) {}

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

    public function hasActiveStudentRole(int $userId): bool
    {
        return $this->userAccountDAO->hasActiveStudentRole($userId);
    }

    public function studentOwnsSession(int $studentId, int $sessionId): bool
    {
        return $this->userAccountDAO->studentOwnsSession($studentId, $sessionId);
    }

    public function justificationStoredStatus(): string
    {
        return 'Justificativo consignado correctamente. Queda en estado Pendiente de revisión por Coordinación.';
    }

    /**
     * @param  array<string, mixed>  $filters
     * @return array<string, mixed>
     */
    public function getDashboardData(int $studentId, array $filters = []): array
    {
        $account = $this->userAccountDAO->findStudentWithProfileAndCareer($studentId);
        abort_if($account === null, 403, 'Acceso denegado: el usuario no posee un perfil de estudiante activo.');

        $profile = $account->profile;
        $career = $profile?->career;
        $studentRole = $account->roles->first();

        $periods = $this->academicPeriodDAO->all()
            ->map(fn ($row): array => [
                'id' => (int) $row->id,
                'nombre' => StudentInputSanitizer::plainText((string) $row->period_name, 50),
                'estado' => StudentInputSanitizer::plainText((string) $row->status, 20),
            ])
            ->all();

        $activePeriod = $this->resolveSelectedPeriod(
            $periods,
            isset($filters['period_id']) ? (int) $filters['period_id'] : null
        );

        $resolvedPeriodId = $activePeriod['id'] ?? $this->academicPeriodDAO->active()?->id;

        $enrollments = $resolvedPeriodId !== null
            ? $this->sectionEnrollmentDAO->enrolledSectionsWithSubjects($studentId, (int) $resolvedPeriodId)
            : $this->sectionEnrollmentDAO->activeEnrollmentsForStudent($studentId);

        $filteredEnrollments = $enrollments
            ->filter(function ($enrollment) use ($filters): bool {
                $subject = $enrollment->section?->subject;

                if (! empty($filters['subject_code']) && strtoupper((string) $subject?->subject_code) !== strtoupper((string) $filters['subject_code'])) {
                    return false;
                }

                if (! empty($filters['status']) && (string) $enrollment->status !== (string) $filters['status']) {
                    return false;
                }

                return true;
            })
            ->sortBy([
                fn ($a, $b) => ($a->section?->subject?->display_order ?? 1) <=> ($b->section?->subject?->display_order ?? 1),
                fn ($a, $b) => strcmp((string) ($a->section?->subject?->subject_code ?? ''), (string) ($b->section?->subject?->subject_code ?? '')),
            ])
            ->values();

        $sectionIds = $filteredEnrollments->pluck('section_id')->filter()->unique()->values()->all();

        $sessionCounts = $this->userAccountDAO->sessionCountsBySections($sectionIds);
        $attendedCounts = $this->userAccountDAO->attendedCountsByStudentAndSections($studentId, $sectionIds);

        $totalSessionsAll = 0;
        $totalAttendedAll = 0;
        $grades = [];
        $asignaturas = [];

        foreach ($filteredEnrollments as $enrollment) {
            $section = $enrollment->section;
            $subject = $section?->subject;
            $teacherProfile = $section?->teacher?->profile;

            $sectionId = (int) $enrollment->section_id;
            $totalSessions = (int) ($sessionCounts[$sectionId] ?? 0);
            $attendedSessions = min($totalSessions, (int) ($attendedCounts[$sectionId] ?? 0));

            $totalSessionsAll += $totalSessions;
            $totalAttendedAll += $attendedSessions;

            $percentage = $totalSessions > 0
                ? (int) round(($attendedSessions / $totalSessions) * 100)
                : 100;

            if ((int) $enrollment->final_grade > 0) {
                $grades[] = (int) $enrollment->final_grade;
            }

            [$barra, $texto, $estado] = $this->resolveAttendanceStyling($percentage);

            $teacherName = StudentInputSanitizer::plainText(
                trim('Prof. ' . ($teacherProfile?->first_name ?? '') . ' ' . ($teacherProfile?->last_name ?? '')),
                120
            );

            $asignaturas[] = [
                'section_id' => $sectionId,
                'codigo' => StudentInputSanitizer::plainText((string) ($subject?->subject_code ?? ''), 20),
                'nombre' => StudentInputSanitizer::plainText((string) ($subject?->subject_name ?? ''), 100),
                'seccion' => StudentInputSanitizer::plainText((string) ($section?->section_name ?? ''), 30),
                'profesor' => $teacherName,
                'aula' => StudentInputSanitizer::plainText((string) ($section?->classroom ?? ''), 50),
                'porcentaje' => $percentage,
                'asistidas' => $attendedSessions . '/' . $totalSessions . ' asistidas',
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

        $absentSessions = $this->attendanceDAO
            ->historyByStudent($studentId, 50)
            ->filter(function (Attendance $attendance) use ($activePeriod): bool {
                if ($attendance->attendance_status !== 'Absent') {
                    return false;
                }

                if (($activePeriod['id'] ?? null) !== null && (int) ($attendance->session?->period_id ?? 0) !== (int) $activePeriod['id']) {
                    return false;
                }

                return true;
            })
            ->take(15)
            ->values()
            ->map(function (Attendance $attendance): array {
                $session = $attendance->session;
                $subject = $session?->section?->subject;
                $dateStr = $session?->session_date?->format('Y-m-d') ?? (string) ($session?->session_date ?? '');
                $code = (string) ($subject?->subject_code ?? '');
                $name = (string) ($subject?->subject_name ?? '');

                return [
                    'id' => (int) $attendance->session_id,
                    'fecha' => StudentInputSanitizer::plainText($dateStr, 20),
                    'etiqueta' => StudentInputSanitizer::plainText(
                        $code . ' · ' . $name . ' (' . $dateStr . ')',
                        160
                    ),
                ];
            })
            ->all();

        $justificativos = $this->userAccountDAO->documentsByUser($studentId, 10)
            ->map(fn (object $doc): array => [
                'id' => (int) $doc->id,
                'archivo' => StudentInputSanitizer::plainText((string) $doc->file_name, 120),
                'tipo' => StudentInputSanitizer::plainText((string) $doc->file_type, 20),
                'estado' => StudentInputSanitizer::plainText((string) $doc->status, 20),
                'observaciones' => StudentInputSanitizer::plainText((string) $doc->observations, 500),
                'fecha' => StudentInputSanitizer::plainText((string) $doc->uploaded_at, 30),
            ])
            ->all();

        $fullName = StudentInputSanitizer::plainText(
            implode(' ', array_filter([
                $profile?->first_name,
                $profile?->middle_name,
                $profile?->last_name,
                $profile?->second_last_name,
            ])),
            200
        );

        $formattedCedula = StudentInputSanitizer::formatCedula(
            (string) ($profile?->id_type ?? 'V'),
            (string) ($profile?->id_number ?? '')
        );

        $careerName = StudentInputSanitizer::plainText((string) ($career?->career_name ?? 'Sin carrera asignada'), 100);
        $semesterOrdinal = $this->formatSemesterOrdinal((int) ($profile?->current_semester ?? 1));
        $periodName = $activePeriod['nombre'] ?? 'Sin período activo';
        $hasDragged = (bool) ($profile?->has_dragged_subjects ?? false);
        $credentialNumber = StudentInputSanitizer::plainText(
            $studentRole?->pivot?->credential_number ?: 'UNEFA-EST-' . str_pad((string) $studentId, 5, '0', STR_PAD_LEFT),
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
                'departamento' => $careerName . ' · ' . $semesterOrdinal . ' Semestre',
                'subtitulo' => 'Matrícula Oficial ' . $periodName,
                'insignia' => $hasDragged ? 'ESTUDIANTE CON ARRASTRE' : 'ESTUDIANTE REGULAR',
                'condicion' => $hasDragged ? 'CONDICIÓN: REGULAR CON ARRASTRE' : 'CONDICIÓN: REGULAR ACTIVO',
                'matricula' => $credentialNumber,
                'qr_token' => $qrToken,
                'qr_resumen' => mb_substr($qrToken, 0, 18, 'UTF-8'),
                'foto' => StudentInputSanitizer::plainText((string) ($profile?->profile_picture ?? ''), 255),
            ],
            'periodo' => [
                'id' => $activePeriod['id'] ?? null,
                'nombre' => $periodName,
            ],
            'periodos' => $periods,
            'filtros' => [
                'period_id' => $activePeriod['id'] ?? null,
                'subject_code' => StudentInputSanitizer::plainText((string) ($filters['subject_code'] ?? ''), 20),
                'status' => StudentInputSanitizer::plainText((string) ($filters['status'] ?? ''), 20),
            ],
            'metricas' => [
                'semestre' => $semesterOrdinal,
                'materias_inscritas' => (string) count($asignaturas),
                'promedio_general' => $averageGrade,
                'asistencia_global' => $globalAttendance,
                'asistencia_global_texto' => number_format($globalAttendance, 1, '.', '') . '%',
                'es_solvente' => $globalAttendance >= 75.0 && ! $hasDragged,
            ],
            'asignaturas' => $asignaturas,
            'sesionesAusentes' => $absentSessions,
            'justificativos' => $justificativos,
        ];
    }

    /**
     * @param  array<string, mixed>  $validated
     */
    public function storeJustification(int $studentId, array $validated, UploadedFile $file): int
    {
        $extension = strtolower($file->getClientOriginalExtension() ?: $file->extension() ?: 'bin');
        $safeOriginalName = StudentInputSanitizer::plainText((string) $file->getClientOriginalName(), 200);
        if ($safeOriginalName === '') {
            $safeOriginalName = 'justificativo.' . $extension;
        }

        $storedFileName = Str::uuid()->toString() . '.' . $extension;
        $storedPath = $file->storeAs('justificativos/student_' . $studentId, $storedFileName, 'local');

        $observations = StudentInputSanitizer::plainText((string) ($validated['observations'] ?? ''), 500);
        if (! empty($validated['session_id'])) {
            $prefix = '[Sesión #' . (int) $validated['session_id'] . '] ';
            $observations = mb_substr($prefix . $observations, 0, 500, 'UTF-8');
        }

        return $this->userAccountDAO->createDocument([
            'user_id' => $studentId,
            'file_name' => $safeOriginalName,
            'file_path' => StudentInputSanitizer::plainText((string) $storedPath, 255),
            'file_type' => StudentInputSanitizer::plainText((string) $validated['file_type'], 20),
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
            default => $semester > 0 ? $semester . 'mo' : '1ro',
        };
    }
}