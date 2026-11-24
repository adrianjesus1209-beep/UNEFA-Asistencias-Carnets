<?php

namespace App\DAO\Contracts;

interface AuditLogDAOInterface {
    public function log(?int $userId, string $action, ?string $detail = null, ?string $ip = null): void;
}