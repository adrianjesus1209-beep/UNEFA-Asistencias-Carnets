<?php

namespace App\DAO\Contracts;

interface FailedAttemptDAOInterface {
    public function register(string $ip, string $type, ?string $identifier = null): void;
    public function countRecent(string $ip, string $type, int $minutes = 15): int;
    public function clear(string $ip, string $type): void;
}