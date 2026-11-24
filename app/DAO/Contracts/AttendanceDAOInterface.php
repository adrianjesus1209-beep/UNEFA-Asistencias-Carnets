<?php

namespace App\DAO\Contracts;

use App\Models\Attendance;
use Illuminate\Support\Collection;

interface AttendanceDAOInterface {
    public function registerAttendance(int $sessionId, int $studentId, string $status, string $method, ?int $registeredById = null): Attendance;
    public function hasAttendance(int $sessionId, int $studentId): bool;
    public function attendanceBySession(int $sessionId): Collection;
    public function percentageByStudentAndSection(int $studentId, int $sectionId): float;
    public function historyByStudent(int $studentId, int $limit = 50): Collection;
    public function statisticsBySection(int $sectionId): array;
    public function globalStatisticsByPeriod(int $periodId): array;
    public function statisticsByFaculty(int $periodId): array;
    public function attendanceOfTeacherToday(int $teacherId, string $date): array;
}