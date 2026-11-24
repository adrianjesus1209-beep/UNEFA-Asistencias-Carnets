<?php

namespace App\DAO;

use App\DAO\Contracts\AttendanceDAOInterface;
use App\Models\Attendance;
use App\Support\Sanitizer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AttendanceDAO implements AttendanceDAOInterface {
    public function registerAttendance(
        int $sessionId,
        int $studentId,
        string $status,
        string $method,
        ?int $registeredById = null
    ): Attendance {
        return Attendance::updateOrCreate(
            ['session_id' => $sessionId, 'student_id' => $studentId],
            [
                'registered_by_id'  => $registeredById,
                'attendance_status' => $status,
                'registration_method' => $method,
            ]
        );
    }

    public function hasAttendance(int $sessionId, int $studentId): bool {
        return Attendance::where('session_id', $sessionId)
            ->where('student_id', $studentId)
            ->exists();
    }

    public function attendanceBySession(int $sessionId): Collection {
        return Attendance::with('student.profile')
            ->where('session_id', $sessionId)
            ->get();
    }

    // % de asistencia de un estudiante en una seccion //
    public function percentageByStudentAndSection(int $studentId, int $sectionId): float {
        $total = DB::table('class_session')
            ->where('section_id', $sectionId)
            ->where('status', 'Closed')
            ->count();

        if ($total === 0) {
            return 0.0;
        }

        $present = DB::table('attendance')
            ->join('class_session', 'class_session.id', '=', 'attendance.session_id')
            ->where('class_session.section_id', $sectionId)
            ->where('attendance.student_id', $studentId)
            ->whereIn('attendance.attendance_status', ['Present', 'Late'])
            ->count();

        return round(($present / $total) * 100, 2);
    }

    public function historyByStudent(int $studentId, int $limit = 50): Collection {
        return Attendance::with(['session.section.subject'])
            ->where('student_id', $studentId)
            ->orderByDesc('recorded_at')
            ->limit($limit)
            ->get();
    }

    // estadisticas por seccion //
    public function statisticsBySection(int $sectionId): array {
        $totalStudents = DB::table('section_enrollment')
            ->where('section_id', $sectionId)
            ->whereIn('status', ['Enrolled', 'Approved'])
            ->count();

        $sessionsCount = DB::table('class_session')
            ->where('section_id', $sectionId)
            ->where('status', 'Closed')
            ->count();

        $attendanceRate = DB::table('attendance')
            ->join('class_session', 'class_session.id', '=', 'attendance.session_id')
            ->where('class_session.section_id', $sectionId)
            ->where('class_session.status', 'Closed')
            ->selectRaw("ROUND(AVG(CASE WHEN attendance_status IN ('Present','Late') THEN 100 ELSE 0 END), 2) as rate")
            ->value('rate');

        return [
            'students'        => $totalStudents,
            'sessions'        => $sessionsCount,
            'attendance_rate' => (float) ($attendanceRate ?? 0),
        ];
    }

    // estadisticas globales del periodo //
    public function globalStatisticsByPeriod(int $periodId): array {
        $rate = DB::table('attendance')
            ->join('class_session', 'class_session.id', '=', 'attendance.session_id')
            ->where('class_session.period_id', $periodId)
            ->selectRaw("ROUND(AVG(CASE WHEN attendance_status IN ('Present','Late') THEN 100 ELSE 0 END), 2) as rate")
            ->value('rate');

        return ['attendance_rate' => (float) ($rate ?? 0)];
    }

    // asistencia consolidada por facultad/carrera //
    public function statisticsByFaculty(int $periodId): array {
        return DB::table('attendance')
            ->join('class_session', 'class_session.id', '=', 'attendance.session_id')
            ->join('section', 'section.id', '=', 'class_session.section_id')
            ->join('subject', 'subject.id', '=', 'section.subject_id')
            ->join('career', 'career.id', '=', 'subject.career_id')
            ->where('class_session.period_id', $periodId)
            ->groupBy('career.id', 'career.career_name')
            ->selectRaw("career.id, career.career_name,
                ROUND(AVG(CASE WHEN attendance_status IN ('Present','Late') THEN 100 ELSE 0 END), 2) as rate")
            ->get()
            ->toArray();
    }

    // docentes que abrieron sesion hoy //
    public function attendanceOfTeacherToday(int $teacherId, string $date): array {
        $sessionsToday = DB::table('class_session')
            ->join('section', 'section.id', '=', 'class_session.section_id')
            ->where('section.teacher_id', $teacherId)
            ->where('class_session.session_date', $date)
            ->count();

        return ['sessions_today' => $sessionsToday];
    }
}