<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Support\AuthMessages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function __invoke(Request $request): JsonResponse|RedirectResponse
    {
        $user = $request->user();
        $ip = (string) $request->ip();

        if ($request->is('api/*') || $request->expectsJson()) {
            $this->authService->revokeMobileToken($user, $ip);

            return response()->json([
                'message' => AuthMessages::logoutSuccess(),
            ], 200);
        }

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        $this->authService->recordWebLogout($user, $ip);

        return redirect()->route('login');
    }
}