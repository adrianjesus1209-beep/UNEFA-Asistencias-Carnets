<?php

namespace App\DAO\Contracts;

use App\Models\UserAccount;

interface UserAccountDAOInterface {
    public function findById(int $id): ?UserAccount;
    public function findByUsername(string $username): ?UserAccount;
    public function findByEmail(string $email): ?UserAccount;
    public function findByIdNumber(string $idType, string $idNumber): ?UserAccount;
    public function create(array $data): UserAccount;
    public function updateStatus(int $id, string $status): bool;
    public function updatePassword(int $id, string $passwordHash): bool;
    public function updateSecurityToken(int $id, string $tokenHash, string $tokenPrefix): bool;
    public function revokeSecurityToken(int $id): bool;
    public function findBySecurityTokenHash(string $tokenHash): ?UserAccount;
}