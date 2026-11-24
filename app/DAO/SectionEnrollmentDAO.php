<?php

namespace App\DAO;

use App\DAO\Contracts\SectionEnrollmentDAOInterface;
use App\Models\SectionEnrollment;
use App\Support\Sanitizer;
use Illuminate\Support\Collection;

class SectionEnrollmentDAO implements SectionEnrollmentDAOInterface {
    public function activeEnrollmentsForStudent(int $studentId): Collection {
        return SectionEnrollment::with(['section.subject', 'section.teacher.profile'])
            ->where('student_id', $studentId)
            ->whereIn('status', ['Enrolled', 'Approved'])
            ->get();
    }

    public function enrolledSectionsWithSubjects(int $studentId, int $periodId): Collection {
        return SectionEnrollment::with(['section.subject', 'section.teacher.profile'])
            ->where('student_id', $studentId)
            ->where('period_id', $periodId)
            ->whereIn('status', ['Enrolled', 'Approved'])
            ->get();
    }

    // solicitudes pendientes que el coordinador debe validar //
    public function pendingEnrollmentsByCareer(int $careerId): Collection {
        return SectionEnrollment::query()
            ->join('section', 'section.id', '=', 'section_enrollment.section_id')
            ->join('subject', 'subject.id', '=', 'section.subject_id')
            ->where('subject.career_id', $careerId)
            ->where('section_enrollment.status', 'Pending')
            ->select('section_enrollment.*')
            ->with(['student.profile', 'section.subject'])
            ->get();
    }

    public function validateEnrollment(int $enrollmentId, int $coordinatorId): bool {
        return (bool) SectionEnrollment::where('id', $enrollmentId)->update([
            'status'                  => 'Enrolled',
            'validated_by_coordinator' => 1,
        ]);
    }

    public function rejectEnrollment(int $enrollmentId, string $reason): bool {
        $reason = Sanitizer::clean($reason);

        return (bool) SectionEnrollment::where('id', $enrollmentId)->update([
            'status' => 'Rejected',
        ]);
    }

    public function globalEnrollmentCount(int $periodId): int {
        return SectionEnrollment::where('period_id', $periodId)
            ->whereIn('status', ['Enrolled', 'Approved'])
            ->count();
    }

    public function studentsBySection(int $sectionId): Collection {
        return SectionEnrollment::with('student.profile')
            ->where('section_id', $sectionId)
            ->whereIn('status', ['Enrolled', 'Approved'])
            ->get();
    }
}