<?php

namespace App\DAO;

use App\DAO\Contracts\CareerDAOInterface;
use App\Models\Career;
use App\Support\Sanitizer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class CareerDAO implements CareerDAOInterface {
    public function findById(int $id): ?Career {
        return Career::find($id);
    }

    public function findByCode(string $code): ?Career {
        $code = Sanitizer::clean($code);
        if (!$code) return null;

        return Career::where('career_code', $code)->first();
    }

    public function all(): Collection {
        return Career::orderBy('career_name')->get();
    }

    // para el director: carreras con matricula, secciones y coordinador //
    public function allWithStatistics(): Collection {
        return Career::query()
            ->leftJoin('profile', 'profile.career_id', '=', 'career.id')
            ->leftJoin('section', 'section.subject_id', '=', DB::raw('NULL'))
            ->select('career.*', DB::raw('COUNT(DISTINCT profile.id) as student_count'))
            ->groupBy('career.id', 'career.career_code', 'career.career_name', 'career.coordinator_id')
            ->get();
    }

    public function coordinatorOf(int $careerId): ?int {
        return Career::where('id', $careerId)->value('coordinator_id');
    }

    public function assignCoordinator(int $careerId, int $coordinatorId): bool {
        return (bool) Career::where('id', $careerId)
            ->update(['coordinator_id' => $coordinatorId]);
    }

    // metricas para la tarjeta del coordinador/director //
    public function statisticsByCareer(int $careerId): array {
        $studentCount = DB::table('profile')
            ->where('career_id', $careerId)
            ->count();

        $teacherCount = DB::table('teacher_subject')
            ->join('subject', 'subject.id', '=', 'teacher_subject.subject_id')
            ->where('subject.career_id', $careerId)
            ->distinct('teacher_subject.teacher_id')
            ->count('teacher_subject.teacher_id');

        $sectionCount = DB::table('section')
            ->join('subject', 'subject.id', '=', 'section.subject_id')
            ->where('subject.career_id', $careerId)
            ->where('section.status', 'Active')
            ->count();

        return [
            'students' => $studentCount,
            'teachers' => $teacherCount,
            'sections' => $sectionCount,
        ];
    }
}