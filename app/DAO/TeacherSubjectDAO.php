<?php

namespace App\DAO;

use App\DAO\Contracts\TeacherSubjectDAOInterface;
use App\Models\TeacherSubject;
use Illuminate\Support\Collection;

class TeacherSubjectDAO implements TeacherSubjectDAOInterface {
    public function subjectsByTeacher(int $teacherId): Collection {
        return TeacherSubject::with('subject')
            ->where('teacher_id', $teacherId)
            ->get();
    }

    // docentes adscritos a una carrera //
    public function teachersByCareer(int $careerId): Collection {
        return TeacherSubject::query()
            ->join('subject', 'subject.id', '=', 'teacher_subject.subject_id')
            ->where('subject.career_id', $careerId)
            ->select('teacher_subject.teacher_id')
            ->distinct()
            ->get();
    }

    public function assignTeacherToSubject(int $teacherId, int $subjectId, ?int $assignedById = null): bool {
        return (bool) TeacherSubject::updateOrCreate(
            ['teacher_id' => $teacherId, 'subject_id' => $subjectId],
            ['assigned_by_id' => $assignedById]
        );
    }

    public function removeTeacherFromSubject(int $teacherId, int $subjectId): bool {
        return (bool) TeacherSubject::where('teacher_id', $teacherId)
            ->where('subject_id', $subjectId)
            ->delete();
    }
}