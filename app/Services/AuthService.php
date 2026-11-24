<?php

namespace App\Services;

use App\DAO\Contracts\AuditLogDAOInterface;
use App\DAO\Contracts\FailedAttemptDAOInterface;
use App\Models\UserAccount;
use App\Support\AuthMessages;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class AuthService
{
    private const MAX_ATTEMPTS = 5;
    private const WINDOW_MINUTES = 15;
    private const DEFAULT_DEVICE = 'mobile-app';
    private const TOKEN_TTL_HOURS = 12;

    public function __construct(
        private readonly FailedAttemptDAOInterface $failedAttempts,
        private readonly AuditLogDAOInterface $auditLogs
    ) {}

    /**
     * @return array{ok: bool, user?: UserAccount, role?: string, message?: string, status?: int}
     */
    public function attemptLogin(string $loginInput, string $password, string $ip, string $channel): array
    {
        $throttleKey = $channel . ':' . sha1(Str::lower($loginInput) . '|' . $ip);

        if ($this->isRateLimited($throttleKey, $ip, $channel)) {
            $status = str_starts_with($channel, 'api') ? 429 : 423;

            return [
                'ok'      => false,
                'status'  => $status,
                'message' => AuthMessages::tooManyAttempts($this->remainingMinutes($throttleKey)),
            ];
        }

        $user = $this->findUserByIdentifier($loginInput);

        if (!$this->hasValidCredentials($user, $password)) {
            $this->registerFailure($throttleKey, $ip, $channel, $loginInput, $user);

            return [
                'ok'      => false,
                'status'  => 401,
                'message' => AuthMessages::invalidCredentials(),
            ];
        }

        $activeRole = $user->primaryActiveRoleName();

        if ($activeRole === null) {
            return [
                'ok'      => false,
                'status'  => 403,
                'message' => AuthMessages::noActiveRole(),
            ];
        }

        RateLimiter::clear($throttleKey);
        $this->failedAttempts->clear($ip, $channel);

        return [
            'ok'   => true,
            'user' => $user,
            'role' => $activeRole,
        ];
    }

    public function resolveDashboardRoute(string $roleName): string
    {
        return match ($roleName) {
            'Super Administrator', 'Director' => route('dashboard.director'),
            'Academic Coordinator'            => route('dashboard.coordinador'),
            'Teacher'                         => route('dashboard.profesor'),
            'Student'                         => route('dashboard.estudiante'),
            default                           => route('login'),
        };
    }

    public function issueMobileToken(UserAccount $user, ?string $deviceName, string $ip): string
    {
        $resolvedDevice = $deviceName !== null && trim($deviceName) !== ''
            ? trim($deviceName)
            : self::DEFAULT_DEVICE;

        $user->tokens()->where('name', $resolvedDevice)->delete();

        $token = $user->createToken(
            $resolvedDevice,
            ['*'],
            now()->addHours(self::TOKEN_TTL_HOURS)
        )->plainTextToken;

        $this->auditLogs->log($user->id, 'API_LOGIN_SUCCESS', $resolvedDevice, $ip);

        return $token;
    }

    public function revokeMobileToken(?UserAccount $user, string $ip): void
    {
        if (!$user || !$user->currentAccessToken()) {
            return;
        }

        $user->currentAccessToken()->delete();

        $this->auditLogs->log($user->id, 'API_LOGOUT', 'SANCTUM', $ip);
    }

    public function recordWebLogin(UserAccount $user, string $ip): void
    {
        $this->auditLogs->log($user->id, 'LOGIN_SUCCESS', 'WEB', $ip);
    }

    public function recordWebLogout(?UserAccount $user, string $ip): void
    {
        if (!$user) {
            return;
        }

        $this->auditLogs->log($user->id, 'LOGOUT', 'WEB', $ip);
    }

    private function isRateLimited(string $throttleKey, string $ip, string $channel): bool
    {
        return RateLimiter::tooManyAttempts($throttleKey, self::MAX_ATTEMPTS)
            || $this->failedAttempts->countRecent($ip, $channel, self::WINDOW_MINUTES) >= self::MAX_ATTEMPTS;
    }

    private function remainingMinutes(string $throttleKey): int
    {
        $seconds = RateLimiter::availableIn($throttleKey);

        return $seconds > 0 ? (int) ceil($seconds / 60) : self::WINDOW_MINUTES;
    }

    private function hasValidCredentials(?UserAccount $user, string $password): bool
    {
        return $user !== null
            && $user->isActive()
            && is_string($user->password_hash)
            && Hash::check($password, $user->password_hash);
    }

    private function registerFailure(
        string $throttleKey,
        string $ip,
        string $channel,
        string $loginInput,
        ?UserAccount $user
    ): void {
        RateLimiter::hit($throttleKey, self::WINDOW_MINUTES * 60);
        $this->failedAttempts->register($ip, $channel, Str::limit($loginInput, 100, ''));

        if ($user) {
            $this->auditLogs->log(
                $user->id,
                str_starts_with($channel, 'api') ? 'API_LOGIN_FAILED' : 'LOGIN_FAILED',
                str_starts_with($channel, 'api') ? 'SANCTUM' : 'WEB',
                $ip
            );
        }
    }

    private function findUserByIdentifier(string $identifier): ?UserAccount
    {
        $cleanDigits = preg_replace('/\D+/', '', $identifier);

        return UserAccount::query()
            ->with(['profile', 'roles'])
            ->where(function ($query) use ($identifier, $cleanDigits) {
                $query->where('email', $identifier)
                    ->orWhere('username', $identifier);

                if ($cleanDigits !== '') {
                    $query->orWhere('username', $cleanDigits)
                        ->orWhereHas('profile', function ($q) use ($cleanDigits) {
                            $q->where('id_number', $cleanDigits);
                        });
                }
            })
            ->first();
    }
}