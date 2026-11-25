<?php

namespace App\Http\Controllers;

use App\Http\Requests\Student\StoreJustificationRequest;
use App\Http\Requests\Student\StudentDashboardRequest;
use App\Services\Student\StudentDashboardService;
use App\Support\AuthMessages;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function __construct(
        private readonly StudentDashboardService $studentService
    ) {}

    public function index(StudentDashboardRequest $request): View
    {
        $studentId = $this->studentService->resolveAuthenticatedStudentId($request);
        abort_if($studentId === null, 403, AuthMessages::unauthorizedModule());

        $dashboardData = $this->studentService->getDashboardData(
            $studentId,
            $request->validated()
        );

        return view('dashboard.student', $dashboardData);
    }

    public function storeJustification(StoreJustificationRequest $request): RedirectResponse
    {
        $studentId = $this->studentService->resolveAuthenticatedStudentId($request);
        abort_if($studentId === null, 403, AuthMessages::unauthorizedModule());

        $this->studentService->storeJustification(
            $studentId,
            $request->validated(),
            $request->file('document')
        );

        return redirect()
            ->route('dashboard.estudiante')
            ->with('student_status', $this->studentService->justificationStoredStatus());
    }
}