<?php

namespace App\DAO;

use App\DAO\Contracts\UserAccountDAOInterface;
use App\Models\UserAccount;
use App\Support\Sanitizer;

class UserAccountDAO implements UserAccountDAOInterface {
    public function findById(int $id): ?UserAccount {
        return UserAccount::find($id);
    }

    public function findByUsername(string $username): ?UserAccount {
        $username = Sanitizer::clean($username);
        if (!$username) return null;
        return UserAccount::where('username', $username)->first();
    }

    public function findByEmail(string $email): ?UserAccount {
        $email = strtolower(trim((string) $email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return null;
        return UserAccount::where('email', $email)->first();
    }

    public function findByIdNumber(string $idType, string $idNumber): ?UserAccount {
        $idType   = strtoupper(trim($idType)) === 'E' ? 'E' : 'V';
        $idNumber = Sanitizer::cedula($idNumber);
        if (!$idNumber) return null;

        return UserAccount::query()
            ->join('profile', 'profile.id', '=', 'user_account.profile_id')
            ->where('profile.id_type', $idType)
            ->where('profile.id_number', $idNumber)
            ->select('user_account.*')
            ->first();
    }

    public function create(array $data): UserAccount {
        return UserAccount::create($data);
    }

    public function updateStatus(int $id, string $status): bool {
        return (bool) UserAccount::where('id', $id)->update(['status' => $status]);
    }

    public function updatePassword(int $id, string $passwordHash): bool {
        return (bool) UserAccount::where('id', $id)->update(['password_hash' => $passwordHash]);
    }

    public function updateSecurityToken(int $id, string $tokenHash, string $tokenPrefix): bool {
        return (bool) UserAccount::where('id', $id)->update([
            'security_token_hash'       => $tokenHash,
            'security_token_prefix'     => $tokenPrefix,
            'security_token_rotated_at' => now(),
            'security_token_revoked_at' => null,
        ]);
    }

    public function revokeSecurityToken(int $id): bool {
        return (bool) UserAccount::where('id', $id)->update([
            'security_token_revoked_at' => now(),
        ]);
    }

    public function findBySecurityTokenHash(string $tokenHash): ?UserAccount {
        return UserAccount::where('security_token_hash', $tokenHash)
            ->whereNull('security_token_revoked_at')
            ->first();
    }
}