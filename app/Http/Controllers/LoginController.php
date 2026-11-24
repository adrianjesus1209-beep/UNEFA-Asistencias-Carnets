<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Services\AuthService;
use App\Support\AuthMessages;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __construct(
        private readonly AuthService $authService
    ) {}

    public function __invoke(LoginRequest $request): JsonResponse|RedirectResponse
    {
        $data = $request->validated();
        $ip = (string) $request->ip();
        $isApi = $request->is('api/*') || $request->expectsJson();
        $channel = $isApi ? 'api_login' : 'login';

        $result = $this->authService->attemptLogin(
            loginInput: $data['login'],
            password: $data['password'],
            ip: $ip,
            channel: $channel
        );

        if (!$result['ok']) {
            if ($isApi) {
                return response()->json([
                    'message' => $result['message'],
                ], $result['status']);
            }

            return back()
                ->withInput($request->only('cedula', 'nacionalidad', 'login', 'remember'))
                ->withErrors(['login' => $result['message']]);
        }

        $user = $result['user'];
        $role = $result['role'];

        if ($isApi) {
            $token = $this->authService->issueMobileToken(
                user: $user,
                deviceName: $data['device_name'] ?? null,
                ip: $ip
            );

            return response()->json([
                'message'    => AuthMessages::loginSuccess(),
                'token_type' => 'Bearer',
                'token'      => $token,
                'role'       => $role,
                'user'       => [
                    'id'       => $user->id,
                    'username' => $user->username,
                    'email'    => $user->email,
                    'status'   => $user->status,
                    'profile'  => $user->profile,
                ],
            ], 200);
        }

        Auth::login($user, (bool) ($data['remember'] ?? false));
        $request->session()->regenerate();
        $this->authService->recordWebLogin($user, $ip);

        return redirect()->intended($this->authService->resolveDashboardRoute($role));
    }
}