<?php

namespace App\DAO;

use App\DAO\Contracts\ClassSessionDAOInterface;
use App\Models\ClassSession;
use App\Support\Sanitizer;
use Illuminate\Support\Collection;

class ClassSessionDAO implements ClassSessionDAOInterface {
    public function findById(int $id): ?ClassSession {
        return ClassSession::find($id);
    }

    public function findOpenBySection(int $sectionId): ?ClassSession {
        return ClassSession::where('section_id', $sectionId)
            ->where('status', 'Open')
            ->first();
    }

    public function sessionsBySection(int $sectionId, int $limit = 20): Collection {
        return ClassSession::where('section_id', $sectionId)
            ->orderByDesc('session_date')
            ->limit($limit)
            ->get();
    }

    public function openSession(int $sectionId, int $periodId, int $openedById, array $data): ClassSession {
        return ClassSession::create([
            'section_id'        => $sectionId,
            'period_id'         => $periodId,
            'opened_by_id'      => $openedById,
            'session_date'      => $data['session_date'] ?? now()->toDateString(),
            'start_time'        => $data['start_time'] ?? now()->toTimeString(),
            'tolerance_minutes' => $data['tolerance_minutes'] ?? 15,
            'session_type'      => $data['session_type'] ?? 'Regular',
            'week_number'       => $data['week_number'] ?? null,
            'status'            => 'Open',
            'observations'      => isset($data['observations'])
                ? Sanitizer::clean($data['observations'])
                : null,
        ]);
    }

    public function closeSession(int $sessionId): bool {
        return (bool) ClassSession::where('id', $sessionId)->update([
            'status'   => 'Closed',
            'end_time' => now()->toTimeString(),
        ]);
    }

    public function countSessionsByTeacher(int $teacherId, int $periodId): int {
        return ClassSession::query()
            ->join('section', 'section.id', '=', 'class_session.section_id')
            ->where('section.teacher_id', $teacherId)
            ->where('class_session.period_id', $periodId)
            ->where('class_session.status', 'Closed')
            ->count();
    }
}