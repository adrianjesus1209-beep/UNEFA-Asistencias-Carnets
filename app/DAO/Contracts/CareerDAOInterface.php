<?php

namespace App\DAO\Contracts;

use App\Models\Career;
use Illuminate\Support\Collection;

interface CareerDAOInterface {
    public function findById(int $id): ?Career;
    public function findByCode(string $code): ?Career;
    public function all(): Collection;
    public function allWithStatistics(): Collection;
    public function coordinatorOf(int $careerId): ?int;
    public function assignCoordinator(int $careerId, int $coordinatorId): bool;
    public function statisticsByCareer(int $careerId): array;
}