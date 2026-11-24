<?php

namespace App\DAO\Contracts;

use App\Models\Section;
use Illuminate\Support\Collection;

interface SectionDAOInterface {
    public function findById(int $id): ?Section;
    public function findWithSubjectAndPeriod(int $sectionId): ?Section;
    public function activeSectionsByTeacher(int $teacherId, int $periodId): Collection;
    public function sectionsByCareer(int $careerId, int $periodId): Collection;
    public function activeSectionsCountByCareer(int $careerId, int $periodId): int;
    public function createSection(array $data): Section;
    public function updateSection(int $id, array $data): bool;
}