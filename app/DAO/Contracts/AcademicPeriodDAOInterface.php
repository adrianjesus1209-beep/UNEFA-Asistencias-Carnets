<?php

namespace App\DAO\Contracts;

use App\Models\AcademicPeriod;
use Illuminate\Support\Collection;

interface AcademicPeriodDAOInterface {
    public function findById(int $id): ?AcademicPeriod;
    public function active(): ?AcademicPeriod;
    public function all(): Collection;
    public function statistics(int $periodId): array;
}