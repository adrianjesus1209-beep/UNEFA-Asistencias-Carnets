<?php

namespace App\Services\Director;

use App\DAO\Contracts\AcademicPeriodDAOInterface;
use App\DAO\Contracts\AttendanceDAOInterface;
use App\DAO\Contracts\AuditLogDAOInterface;
use App\DAO\Contracts\CareerDAOInterface;
use App\DAO\Contracts\RoleDAOInterface;
use App\DAO\Contracts\SectionEnrollmentDAOInterface;
use App\Models\Profile;
use App\Models\UserAccount;
use App\Support\Sanitizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DirectorDashboardService
{
    public function __construct(
        private readonly AcademicPeriodDAOInterface $periodDAO,
        private readonly CareerDAOInterface $careerDAO,
        private readonly RoleDAOInterface $roleDAO,
        private readonly SectionEnrollmentDAOInterface $enrollmentDAO,
        private readonly AttendanceDAOInterface $attendanceDAO,
        private readonly AuditLogDAOInterface $auditLogDAO,
    ) {}

    public function resolveAuthenticatedUserId(Request $request): ?int
    {
        $authId = Auth::id();
        if (is_numeric($authId) && (int) $authId > 0) {
            return (int) $authId;
        }

        foreach (['user_id', 'auth_user_id'] as $key) {
            $sessionId = $request->session()->get($key);
            if (is_numeric($sessionId) && (int) $sessionId > 0) {
                return (int) $sessionId;
            }
        }

        return null;
    }

    public function hasAuthorizedDirectorRole(int $userId): bool
    {
        $user = UserAccount::find($userId);
        if (!$user || !$user->isActive()) {
            return false;
        }

        $roles = $this->roleDAO->activeRolesForUser($userId);
        foreach ($roles as $role) {
            $roleName = (string) ($role->role_name ?? '');
            if (in_array($roleName, ['Director', 'Super Administrator'], true)) {
                return true;
            }
        }

        return false;
    }

    public function getDashboardData(int $userId, array $filters = []): array
    {
        $account = UserAccount::with('profile')->find($userId);
        $profile = $account?->profile;

        $activePeriod = isset($filters['period_id']) && (int) $filters['period_id'] > 0
            ? $this->periodDAO->findById((int) $filters['period_id'])
            : $this->periodDAO->active();

        $activePeriod ??= $this->periodDAO->active();
        $periodId = $activePeriod?->id ?? 1;
        $periodName = Sanitizer::clean((string) ($activePeriod?->period_name ?? '2026-1')) ?? '2026-1';

        $periodStats = $this->periodDAO->statistics($periodId);
        $totalEnrollments = (int) ($periodStats['enrollments'] ?? $this->enrollmentDAO->globalEnrollmentCount($periodId));
        $attendanceRate = (float) ($periodStats['attendance_rate'] ?? $this->attendanceDAO->globalStatisticsByPeriod($periodId)['rate'] ?? 95.1);

        $coordinatorsMap = $this->getAvailableCoordinatorsMap();
        $careers = $this->careerDAO->all();
        $careerItems = [];
        $totalStudents = 0;
        $totalTeachers = 0;

        foreach ($careers as $career) {
            $stats = $this->careerDAO->statisticsByCareer((int) $career->id);
            $students = (int) ($stats['students'] ?? 0);
            $teachers = (int) ($stats['teachers'] ?? 0);
            $sections = (int) ($stats['sections'] ?? 0);

            $totalStudents += $students;
            $totalTeachers += $teachers;

            $coordId = $career->coordinator_id ? (int) $career->coordinator_id : null;
            $coordName = ($coordId !== null && isset($coordinatorsMap[$coordId]))
                ? $coordinatorsMap[$coordId]
                : 'Sin coordinador asignado';

            $careerItems[] = [
                'id'              => (int) $career->id,
                'codigo'          => Sanitizer::clean((string) $career->career_code) ?? '',
                'nombre'          => Sanitizer::clean((string) $career->career_name) ?? '',
                'coordinador_id'  => $coordId,
                'coordinador'     => Sanitizer::clean($coordName) ?? 'Sin coordinador asignado',
                'alumnos'         => $students,
                'docentes'        => $teachers,
                'secciones'       => $sections,
                'porcentaje_base' => min(100, max(0, (int) round($attendanceRate))),
            ];
        }

        $qrTodayCount = DB::table('attendance')
            ->join('class_session', 'class_session.id', '=', 'attendance.session_id')
            ->where('class_session.period_id', $periodId)
            ->where('attendance.registration_method', 'QR')
            ->count();

        $coordinatorOptions = [];
        foreach ($coordinatorsMap as $id => $label) {
            $coordinatorOptions[] = [
                'id'     => (int) $id,
                'nombre' => Sanitizer::clean($label) ?? '',
            ];
        }

        return [
            'director' => $this->buildDirectorProfileData($account, $profile, $userId),
            'periodo'  => [
                'id'     => $periodId,
                'nombre' => $periodName,
            ],
            'metricas' => [
                'matricula_total'    => number_format($totalStudents > 0 ? $totalStudents : $totalEnrollments, 0, ',', '.'),
                'personal_activo'    => number_format($totalTeachers, 0, ',', '.'),
                'asistencia_general' => number_format($attendanceRate, 1, '.', '') . '%',
                'gratuidad'          => '100%',
                'lecturas_qr'        => number_format($qrTodayCount, 0, ',', '.') . ' lecturas',
            ],
            'carreras'      => $careerItems,
            'coordinadores' => $coordinatorOptions,
        ];
    }

    public function assignCoordinator(int $directorUserId, int $careerId, int $coordinatorId, string $ipAddress): array
    {
        $career = $this->careerDAO->findById($careerId);
        if (!$career) {
            return ['ok' => false, 'message' => 'La carrera indicada no existe.'];
        }

        $coordinatorAccount = UserAccount::with('profile')->find($coordinatorId);
        if (!$coordinatorAccount || !$coordinatorAccount->isActive()) {
            return ['ok' => false, 'message' => 'La cuenta del coordinador no está activa o aprobada.'];
        }

        $hasCoordinatorRole = false;
        foreach ($this->roleDAO->activeRolesForUser($coordinatorId) as $role) {
            if (($role->role_name ?? '') === 'Academic Coordinator') {
                $hasCoordinatorRole = true;
                break;
            }
        }

        if (!$hasCoordinatorRole) {
            return ['ok' => false, 'message' => 'El usuario seleccionado no tiene el rol de Coordinador Académico activo.'];
        }

        $updated = $this->careerDAO->assignCoordinator($careerId, $coordinatorId);
        if (!$updated) {
            return ['ok' => false, 'message' => 'No fue posible actualizar el coordinador de la carrera.'];
        }

        $this->auditLogDAO->log(
            $directorUserId,
            'DIRECTOR_ASSIGN_COORDINATOR',
            "Carrera ID {$careerId} asignada al coordinador ID {$coordinatorId}",
            $ipAddress
        );

        return ['ok' => true, 'message' => 'Coordinador asignado correctamente a la carrera.'];
    }

    private function getAvailableCoordinatorsMap(): array
    {
        $rows = DB::table('user_account')
            ->join('user_role', 'user_role.user_id', '=', 'user_account.id')
            ->join('system_role', 'system_role.id', '=', 'user_role.role_id')
            ->leftJoin('profile', 'profile.id', '=', 'user_account.profile_id')
            ->where('user_account.status', 'Approved')
            ->where('user_role.is_active', 1)
            ->where('system_role.role_name', 'Academic Coordinator')
            ->select(
                'user_account.id',
                'user_account.username',
                'profile.first_name',
                'profile.last_name',
                'profile.id_number'
            )
            ->orderBy('profile.last_name')
            ->get();

        $map = [];
        foreach ($rows as $row) {
            $fullName = trim((string) (($row->first_name ?? '') . ' ' . ($row->last_name ?? '')));
            $baseLabel = $fullName !== '' ? $fullName : (string) $row->username;
            $cedula = preg_replace('/\D+/', '', (string) ($row->id_number ?? ''));
            $map[(int) $row->id] = $cedula !== '' ? "{$baseLabel} (V-{$cedula})" : $baseLabel;
        }

        return $map;
    }

    private function buildDirectorProfileData(?UserAccount $account, ?Profile $profile, int $userId): array
    {
        $roles = $this->roleDAO->activeRolesForUser($userId);
        $directorRole = null;
        foreach ($roles as $role) {
            if (($role->role_name ?? '') === 'Director') {
                $directorRole = $role;
                break;
            }
        }
        $directorRole ??= $roles->first();

        $fullName = $profile
            ? trim(implode(' ', array_filter([
                $profile->first_name,
                $profile->middle_name,
                $profile->last_name,
                $profile->second_last_name,
            ])))
            : ($account?->username ?? 'Director UNEFA');

        $idType = Sanitizer::clean((string) ($profile?->id_type ?? 'V')) ?: 'V';
        $idNumber = preg_replace('/\D+/', '', (string) ($profile?->id_number ?? '0'));

        return [
            'nombre'       => Sanitizer::clean($fullName) ?? 'Director UNEFA',
            'cedula'       => $idType . '-' . $idNumber,
            'departamento' => Sanitizer::clean((string) ($profile?->job_title ?? 'Dirección General de Núcleo')) ?? 'Dirección General de Núcleo',
            'subtitulo'    => 'Comando y Gestión Académica Institucional',
            'matricula'    => Sanitizer::clean((string) ($directorRole?->credential_number ?? ('DIR-' . $userId))) ?? ('DIR-' . $userId),
        ];
    }
}