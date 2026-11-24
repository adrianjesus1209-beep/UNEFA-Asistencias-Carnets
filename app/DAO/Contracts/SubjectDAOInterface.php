<?php

namespace App\DAO\Contracts;

use App\Models\Subject;
use Illuminate\Support\Collection;

interface SubjectDAOInterface {
    public function findById(int $id): ?Subject;
    public function byCareer(int $careerId): Collection;
    public function findByCareerAndSemester(int $careerId, int $semester): Collection;
    public function allWithCareer(): Collection;
}