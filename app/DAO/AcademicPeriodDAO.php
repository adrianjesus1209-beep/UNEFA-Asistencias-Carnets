<?php

namespace App\DAO;

use App\DAO\Contracts\AcademicPeriodDAOInterface;
use App\Models\AcademicPeriod;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class AcademicPeriodDAO implements AcademicPeriodDAOInterface {
    public function findById(int $id): ?AcademicPeriod {
        return AcademicPeriod::find($id);
    }

    public function active(): ?AcademicPeriod {
        return AcademicPeriod::where('status', 'Active')->first();
    }

    public function all(): Collection {
        return AcademicPeriod::orderByDesc('start_date')->get();
    }

    // metricas globales del periodo (director) //
    public function statistics(int $periodId): array {
        $enrollments = DB::table('section_enrollment')
            ->where('period_id', $periodId)
            ->count();

        $sessions = DB::table('class_session')
            ->where('period_id', $periodId)
            ->count();

        $attendanceRate = DB::table('attendance')
            ->join('class_session', 'class_session.id', '=', 'attendance.session_id')
            ->where('class_session.period_id', $periodId)
            ->selectRaw("ROUND(AVG(CASE WHEN attendance_status IN ('Present','Late') THEN 100 ELSE 0 END), 2) as rate")
            ->value('rate');

        return [
            'enrollments'     => $enrollments,
            'sessions'        => $sessions,
            'attendance_rate' => (float) ($attendanceRate ?? 0),
        ];
    }
}