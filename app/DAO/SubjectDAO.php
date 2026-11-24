<?php

namespace App\DAO;

use App\DAO\Contracts\SubjectDAOInterface;
use App\Models\Subject;
use Illuminate\Support\Collection;

class SubjectDAO implements SubjectDAOInterface {
    public function findById(int $id): ?Subject {
        return Subject::find($id);
    }
 
    public function byCareer(int $careerId): Collection {
        return Subject::where('career_id', $careerId)
            ->orderBy('semester')
            ->orderBy('display_order')
            ->get();
    }

    public function findByCareerAndSemester(int $careerId, int $semester): Collection {
        return Subject::where('career_id', $careerId)
            ->where('semester', $semester)
            ->orderBy('display_order')
            ->get();
    }

    public function allWithCareer(): Collection {
        return Subject::with('career')->get();
    }
}