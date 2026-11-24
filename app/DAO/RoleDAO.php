<?php

namespace App\DAO;

use App\DAO\Contracts\RoleDAOInterface;
use App\Models\SystemRole;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class RoleDAO implements RoleDAOInterface {
    public function activeRolesForUser(int $userId): Collection {
        return SystemRole::query()
            ->join('user_role', 'user_role.role_id', '=', 'system_role.id')
            ->where('user_role.user_id', $userId)
            ->where('user_role.is_active', 1)
            ->select(
                'system_role.*',
                'user_role.credential_number',
                'user_role.credential_issued_at',
                'user_role.credential_expires_at'
            )
            ->orderBy('system_role.hierarchy_level')
            ->get();
    }

    public function hasPermission(int $userId, string $permissionKey): bool {
        return DB::table('user_role')
            ->join('role_permission', 'role_permission.role_id', '=', 'user_role.role_id')
            ->join('permission', 'permission.id', '=', 'role_permission.permission_id')
            ->where('user_role.user_id', $userId)
            ->where('user_role.is_active', 1)
            ->where('permission.permission_key', $permissionKey)
            ->exists();
    }

    public function primaryRoleName(int $userId): ?string {
        $role = SystemRole::query()
            ->join('user_role', 'user_role.role_id', '=', 'system_role.id')
            ->where('user_role.user_id', $userId)
            ->where('user_role.is_active', 1)
            ->orderBy('system_role.hierarchy_level')
            ->select('system_role.role_name')
            ->first();

        return $role?->role_name;
    }
}