<?php

namespace App\DAO\Contracts;

use Illuminate\Support\Collection;

interface TeacherSubjectDAOInterface {
    public function subjectsByTeacher(int $teacherId): Collection;
    public function teachersByCareer(int $careerId): Collection;
    public function assignTeacherToSubject(int $teacherId, int $subjectId, ?int $assignedById = null): bool;
    public function removeTeacherFromSubject(int $teacherId, int $subjectId): bool;
}