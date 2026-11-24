<?php

namespace App\DAO\Contracts;

use App\Models\ClassSession;
use Illuminate\Support\Collection;

interface ClassSessionDAOInterface {
    public function findById(int $id): ?ClassSession;
    public function findOpenBySection(int $sectionId): ?ClassSession;
    public function sessionsBySection(int $sectionId, int $limit = 20): Collection;
    public function openSession(int $sectionId, int $periodId, int $openedById, array $data): ClassSession;
    public function closeSession(int $sessionId): bool;
    public function countSessionsByTeacher(int $teacherId, int $periodId): int;
}