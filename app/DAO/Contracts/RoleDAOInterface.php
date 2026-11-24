<?php

namespace App\DAO\Contracts;

use Illuminate\Support\Collection;

interface RoleDAOInterface {
    public function activeRolesForUser(int $userId): Collection;
    public function hasPermission(int $userId, string $permissionKey): bool;
    public function primaryRoleName(int $userId): ?string;
}