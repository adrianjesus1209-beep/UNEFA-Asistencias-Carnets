<?php

namespace App\DAO;

use App\DAO\Contracts\SectionDAOInterface;
use App\Models\Section;
use Illuminate\Support\Collection;

class SectionDAO implements SectionDAOInterface {
    public function findById(int $id): ?Section {
        return Section::find($id);
    }

    public function findWithSubjectAndPeriod(int $sectionId): ?Section {
        return Section::with(['subject', 'period', 'teacher.profile'])
            ->find($sectionId);
    }

    // secciones activas del profesor  //
    public function activeSectionsByTeacher(int $teacherId, int $periodId): Collection {
        return Section::with(['subject', 'period'])
            ->where('teacher_id', $teacherId)
            ->where('period_id', $periodId)
            ->where('status', 'Active')
            ->get();
    }

    // secciones de una carrera en el periodo //
    public function sectionsByCareer(int $careerId, int $periodId): Collection {
        return Section::query()
            ->join('subject', 'subject.id', '=', 'section.subject_id')
            ->where('subject.career_id', $careerId)
            ->where('section.period_id', $periodId)
            ->select('section.*')
            ->with(['subject', 'teacher.profile'])
            ->get();
    }

    public function activeSectionsCountByCareer(int $careerId, int $periodId): int {
        return Section::query()
            ->join('subject', 'subject.id', '=', 'section.subject_id')
            ->where('subject.career_id', $careerId)
            ->where('section.period_id', $periodId)
            ->where('section.status', 'Active')
            ->count();
    }

    public function createSection(array $data): Section {
        return Section::create($data);
    }

    public function updateSection(int $id, array $data): bool {
        return (bool) Section::where('id', $id)->update($data);
    }
}