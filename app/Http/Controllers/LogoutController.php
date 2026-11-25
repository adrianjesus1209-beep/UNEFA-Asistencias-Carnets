<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use App\Support\AuthMessages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

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

        if ($user !== null) {
            $this->authService->recordWebLogout($user, $ip);
        }

        Auth::guard('web')->logout();

        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        $sessionCookie = (string) config('session.cookie');
        $path = (string) config('session.path', '/');
        $domain = config('session.domain');

        Cookie::queue(Cookie::forget($sessionCookie, $path, $domain));
        Cookie::queue(Cookie::forget('XSRF-TOKEN', $path, $domain));

        return redirect()->route('login');
    }
}