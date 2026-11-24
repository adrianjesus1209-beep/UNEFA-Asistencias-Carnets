<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StoreJustificationRequest;
use App\Http\Requests\Student\StudentDashboardRequest;
use App\Services\Student\StudentDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Controlador del modulo Estudiante (dashboard/student.blade.php).
 *
 * Delega todas las validaciones a clases FormRequest dedicadas
 * y el acceso a datos a la capa de servicio/DAO.
 */
class StudentController extends Controller
{
    public function __construct(
        private readonly StudentDashboardService $studentService
    ) {}

    /**
     * Muestra el panel del estudiante autenticado con sus datos reales desde BD.
     */
    public function index(StudentDashboardRequest $request): View
    {
        $studentId = $this->studentService->resolveAuthenticatedStudentId($request);
        abort_if($studentId === null, 403, 'Acceso denegado: sesion de estudiante requerida.');

        $dashboardData = $this->studentService->getDashboardData(
            $studentId,
            $request->validated()
        );

        return view('dashboard.student', $dashboardData);
    }

    /**
     * Registra un justificativo de inasistencia del estudiante autenticado.
     */
    public function storeJustification(StoreJustificationRequest $request): RedirectResponse
    {
        $studentId = $this->studentService->resolveAuthenticatedStudentId($request);
        abort_if($studentId === null, 403, 'Acceso denegado: sesion de estudiante requerida.');

        $this->studentService->storeJustification(
            $studentId,
            $request->validated(),
            $request->file('document')
        );

        return redirect()
            ->route('dashboard.estudiante')
            ->with('student_status', 'Justificativo consignado correctamente. Queda en estado Pendiente de revisión por Coordinación.');
    }
}
