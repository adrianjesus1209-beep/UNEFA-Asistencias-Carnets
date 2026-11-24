<?php

namespace App\DAO;

use App\DAO\Contracts\FailedAttemptDAOInterface;
use App\Models\FailedAttempt;
use App\Support\Sanitizer;

class FailedAttemptDAO implements FailedAttemptDAOInterface {
    public function register(string $ip, string $type, ?string $identifier = null): void {
        FailedAttempt::create([
            'ip_address'   => substr($ip, 0, 45),
            'attempt_type' => Sanitizer::clean($type) ?? 'login',
            'identifier'   => $identifier !== null ? Sanitizer::clean($identifier) : null,
        ]);
    }

    public function countRecent(string $ip, string $type, int $minutes = 15): int {
        return FailedAttempt::query()
            ->where('ip_address', $ip)
            ->where('attempt_type', $type)
            ->where('attempted_at', '>=', now()->subMinutes($minutes))
            ->count();
    }

    public function clear(string $ip, string $type): void {
        FailedAttempt::query()
            ->where('ip_address', $ip)
            ->where('attempt_type', $type)
            ->delete();
    }
}