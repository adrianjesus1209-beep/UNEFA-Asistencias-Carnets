<?php

namespace App\DAO\Contracts;

use App\Models\SectionEnrollment;
use Illuminate\Support\Collection;

interface SectionEnrollmentDAOInterface {
    public function activeEnrollmentsForStudent(int $studentId): Collection;
    public function enrolledSectionsWithSubjects(int $studentId, int $periodId): Collection;
    public function pendingEnrollmentsByCareer(int $careerId): Collection;
    public function validateEnrollment(int $enrollmentId, int $coordinatorId): bool;
    public function rejectEnrollment(int $enrollmentId, string $reason): bool;
    public function globalEnrollmentCount(int $periodId): int;
    public function studentsBySection(int $sectionId): Collection;
}