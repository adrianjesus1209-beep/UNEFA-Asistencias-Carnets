<?php

namespace App\DAO;

use App\DAO\Contracts\AuditLogDAOInterface;
use App\Models\AuditLog;
use App\Support\Sanitizer;

class AuditLogDAO implements AuditLogDAOInterface {
    public function log(?int $userId, string $action, ?string $detail = null, ?string $ip = null): void {
        AuditLog::create([
            'user_id'    => $userId,
            'action'     => Sanitizer::clean($action) ?? 'unknown',
            'detail'     => $detail !== null ? Sanitizer::clean($detail) : null,
            'ip_address' => $ip,
        ]);
    }
}