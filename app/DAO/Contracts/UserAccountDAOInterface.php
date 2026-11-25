<?php

namespace App\DAO\Contracts;

use App\Models\UserAccount;
use Illuminate\Support\Collection;

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

    // Consultas del estudiante como usuario
    public function hasActiveStudentRole(int $userId): bool;
    public function findStudentWithProfileAndCareer(int $studentId): ?UserAccount;
    public function studentOwnsSession(int $studentId, int $sessionId): bool;
    public function sessionCountsBySections(array $sectionIds): array;
    public function attendedCountsByStudentAndSections(int $studentId, array $sectionIds): array;
    public function documentsByUser(int $userId, int $limit = 10): Collection;
    public function createDocument(array $data): int;
}