<?php

namespace App\Http\Controllers;

use App\Http\Requests\Director\AssignCoordinatorRequest;
use App\Http\Requests\Director\DirectorDashboardRequest;
use App\Services\Director\DirectorDashboardService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class DirectorController extends Controller
{
    public function __construct(
        private readonly DirectorDashboardService $dashboardService,
    ) {}

    public function index(DirectorDashboardRequest $request): View
    {
        $userId = $this->dashboardService->resolveAuthenticatedUserId($request);
        if ($userId === null || !$this->dashboardService->hasAuthorizedDirectorRole($userId)) {
            abort(403);
        }

        $data = $this->dashboardService->getDashboardData($userId, $request->validated());

        return view('dashboard.director', $data);
    }

    public function assignCoordinator(AssignCoordinatorRequest $request): RedirectResponse
    {
        $userId = $this->dashboardService->resolveAuthenticatedUserId($request);
        if ($userId === null || !$this->dashboardService->hasAuthorizedDirectorRole($userId)) {
            abort(403);
        }

        $validated = $request->validated();
        $result = $this->dashboardService->assignCoordinator(
            $userId,
            (int) $validated['career_id'],
            (int) $validated['coordinator_id'],
            (string) $request->ip()
        );

        if (!$result['ok']) {
            return redirect()
                ->route('dashboard.director')
                ->withErrors(['coordinator_id' => $result['message']])
                ->withInput();
        }

        return redirect()
            ->route('dashboard.director')
            ->with('director_status', $result['message']);
    }
}