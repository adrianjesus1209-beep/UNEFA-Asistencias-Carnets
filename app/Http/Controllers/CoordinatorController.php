<?php

namespace App\Http\Controllers;

use App\DAO\AcademicPeriodDAO;
use App\DAO\AttendanceDAO;
use App\DAO\AuditLogDAO;
use App\DAO\CareerDAO;
use App\DAO\RoleDAO;
use App\DAO\SectionDAO;
use App\DAO\SectionEnrollmentDAO;
use App\Http\Requests\Coordinator\CoordinatorDashboardRequest;
use App\Support\Sanitizer;
use Illuminate\View\View;

class CoordinatorController extends Controller
{
    public function __construct(
        private readonly AcademicPeriodDAO $academicPeriodDAO,
        private readonly CareerDAO $careerDAO,
        private readonly SectionDAO $sectionDAO,
        private readonly SectionEnrollmentDAO $sectionEnrollmentDAO,
        private readonly AttendanceDAO $attendanceDAO,
        private readonly RoleDAO $roleDAO,
        private readonly AuditLogDAO $auditLogDAO
    ) {}

    public function index(CoordinatorDashboardRequest $request): View
    {
        $user = $request->user();
        abort_if($user === null, 403, 'Acceso no autorizado.');

        $validated = $request->validated();

        // Verificar rol activo mediante 
        $activeRoles = $this->roleDAO->activeRolesForUser((int) $user->id);
        $roleNames = $activeRoles->pluck('role_name')->all();

        $isSuperAdmin = in_array('Super Administrator', $roleNames, true);
        $isCoordinator = in_array('Academic Coordinator', $roleNames, true);

        abort_if(!$isCoordinator && !$isSuperAdmin, 403, 'No posee permisos de Coordinación Académica.');

        // Resolver carrera asignada estrictamente al coordinador autenticado 
        $allCareers = $this->careerDAO->all();
        $assignedCareer = $allCareers->first(function ($career) use ($user) {
            return $this->careerDAO->coordinatorOf((int) $career->id) === (int) $user->id;
        });

        // Si pasa career_id por parámetro, solo permitir si es su propia carrera 
        if (isset($validated['career_id'])) {
            $requestedCareerId = (int) $validated['career_id'];
            if (!$isSuperAdmin) {
                abort_if(
                    $assignedCareer === null || (int) $assignedCareer->id !== $requestedCareerId,
                    403,
                    'No tiene autorización para consultar datos de otra carrera.'
                );
            }
            $assignedCareer = $this->careerDAO->findById($requestedCareerId);
        } elseif ($assignedCareer === null && $isSuperAdmin) {
            $assignedCareer = $allCareers->first();
        }

        abort_if($assignedCareer === null, 403, 'No tiene una carrera asignada en el sistema.');

        $careerId = (int) $assignedCareer->id;

        //  Período académico activo o solicitado 
        $activePeriod = isset($validated['period_id'])
            ? $this->academicPeriodDAO->findById((int) $validated['period_id'])
            : $this->academicPeriodDAO->active();

        // Métricas y listados exclusivos de su carrera 
        $careerStats = $this->careerDAO->statisticsByCareer($careerId);

        $activeSectionsCount = $activePeriod
            ? $this->sectionDAO->activeSectionsCountByCareer($careerId, (int) $activePeriod->id)
            : (int) ($careerStats['sections'] ?? 0);

        $sections = $activePeriod
            ? $this->sectionDAO->sectionsByCareer($careerId, (int) $activePeriod->id)
            : collect();

        $pendingEnrollments = $this->sectionEnrollmentDAO->pendingEnrollmentsByCareer($careerId);

        // Porcentaje de asistencia de la carrera del coordinador en el período
        $careerAttendanceRate = 0.0;
        if ($activePeriod) {
            $facultyStats = $this->attendanceDAO->statisticsByFaculty((int) $activePeriod->id);
            foreach ($facultyStats as $row) {
                if ((int) ($row->id ?? 0) === $careerId) {
                    $careerAttendanceRate = (float) ($row->rate ?? 0.0);
                    break;
                }
            }
        }

        //  Preparar datos sanitizados del banner de sesión
       $profile = $user->profile ?? \App\Models\Profile::find($user->profile_id ?? null);
        $rawFullName = trim(implode(' ', array_filter([
            $profile->first_name ?? null,
            $profile->middle_name ?? null,
            $profile->last_name ?? null,
            $profile->second_last_name ?? null,
        ])));

        $safeName = Sanitizer::clean($rawFullName !== '' ? $rawFullName : ($user->username ?? 'Coordinador Académico')) ?? 'Coordinador Académico';

        $idType = ($profile && strtoupper((string) ($profile->id_type ?? 'V')) === 'E') ? 'E' : 'V';
        $idNumber = $profile ? (Sanitizer::cedula((string) ($profile->id_number ?? '')) ?? '00000000') : '00000000';

        $coordinatorRole = $activeRoles->firstWhere('role_name', 'Academic Coordinator') ?? $activeRoles->first();
        $credentialCode = Sanitizer::clean((string) ($coordinatorRole->credential_number ?? $assignedCareer->career_code ?? ('COORD-' . $user->id)));

        $bannerData = [
            'nombre'       => $safeName,
            'cedula'       => $idType . '-' . $idNumber,
            'departamento' => 'Coordinación de ' . (Sanitizer::clean((string) $assignedCareer->career_name) ?? 'Carrera'),
            'subtitulo'    => $activePeriod
                ? 'Período Académico · ' . (Sanitizer::clean((string) ($activePeriod->period_name ?? $activePeriod->period_code ?? $activePeriod->id)))
                : 'Decanato Académico',
            'matricula'    => $credentialCode ?? ('COORD-' . $user->id),
        ];

        $metrics = [
            'students'        => (int) ($careerStats['students'] ?? 0),
            'teachers'        => (int) ($careerStats['teachers'] ?? 0),
            'sections'        => (int) $activeSectionsCount,
            'attendance_rate' => number_format($careerAttendanceRate, 1) . '%',
            'pending_count'   => $pendingEnrollments->count(),
        ];

        // Registrar acceso en auditoría vía AuditLogDAO
        $this->auditLogDAO->log(
            (int) $user->id,
            'coordinator.dashboard.view',
            'Consulta panel coordinación carrera ID ' . $careerId,
            $request->ip()
        );

        return view('dashboard.coordinator', [
            'bannerData'         => $bannerData,
            'metrics'            => $metrics,
            'career'             => $assignedCareer,
            'activePeriod'       => $activePeriod,
            'sections'           => $sections,
            'pendingEnrollments' => $pendingEnrollments,
        ]);
    }
}