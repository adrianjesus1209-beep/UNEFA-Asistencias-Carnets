<?php

namespace App\DAO;

use App\DAO\Contracts\UserAccountDAOInterface;
use App\Models\Attendance;
use App\Models\ClassSession;
use App\Models\SectionEnrollment;
use App\Models\UserAccount;
use App\Support\Sanitizer;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class UserAccountDAO implements UserAccountDAOInterface {
    public function findById(int $id): ?UserAccount {
        return UserAccount::find($id);
    }

    public function findByUsername(string $username): ?UserAccount {
        $username = Sanitizer::clean($username);
        if (!$username) return null;
        return UserAccount::where('username', $username)->first();
    }

    public function findByEmail(string $email): ?UserAccount {
        $email = strtolower(trim((string) $email));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) return null;
        return UserAccount::where('email', $email)->first();
    }

    public function findByIdNumber(string $idType, string $idNumber): ?UserAccount {
        $idType   = strtoupper(trim($idType)) === 'E' ? 'E' : 'V';
        $idNumber = Sanitizer::cedula($idNumber);
        if (!$idNumber) return null;

        return UserAccount::query()
            ->join('profile', 'profile.id', '=', 'user_account.profile_id')
            ->where('profile.id_type', $idType)
            ->where('profile.id_number', $idNumber)
            ->select('user_account.*')
            ->first();
    }

    public function create(array $data): UserAccount {
        return UserAccount::create($data);
    }

    public function updateStatus(int $id, string $status): bool {
        return (bool) UserAccount::where('id', $id)->update(['status' => $status]);
    }

    public function updatePassword(int $id, string $passwordHash): bool {
        return (bool) UserAccount::where('id', $id)->update(['password_hash' => $passwordHash]);
    }

    public function updateSecurityToken(int $id, string $tokenHash, string $tokenPrefix): bool {
        return (bool) UserAccount::where('id', $id)->update([
            'security_token_hash'       => $tokenHash,
            'security_token_prefix'     => $tokenPrefix,
            'security_token_rotated_at' => now(),
            'security_token_revoked_at' => null,
        ]);
    }

    public function revokeSecurityToken(int $id): bool {
        return (bool) UserAccount::where('id', $id)->update([
            'security_token_revoked_at' => now(),
        ]);
    }

    public function findBySecurityTokenHash(string $tokenHash): ?UserAccount {
        return UserAccount::where('security_token_hash', $tokenHash)
            ->whereNull('security_token_revoked_at')
            ->first();
    }

    // Consultas del estudiante como usuario
    public function hasActiveStudentRole(int $userId): bool {
        $user = $this->findById($userId);
        if (!$user || !$user->isActive()) {
            return false;
        }

        return $user->roles()
            ->wherePivot('is_active', 1)
            ->where('role_name', 'Student')
            ->exists();
    }

    public function findStudentWithProfileAndCareer(int $studentId): ?UserAccount {
        $user = $this->findById($studentId);
        if (!$user || !$user->isActive()) {
            return null;
        }

        $hasStudentRole = $user->roles()
            ->wherePivot('is_active', 1)
            ->where('role_name', 'Student')
            ->exists();

        if (!$hasStudentRole) {
            return null;
        }

        return $user->load([
            'profile.career',
            'roles' => fn ($q) => $q->wherePivot('is_active', 1)->where('role_name', 'Student'),
        ]);
    }

    public function studentOwnsSession(int $studentId, int $sessionId): bool {
        $session = ClassSession::find($sessionId);
        if (!$session) {
            return false;
        }

        return SectionEnrollment::where('student_id', $studentId)
            ->where('section_id', $session->section_id)
            ->whereNotIn('status', ['Withdrawn', 'Rejected'])
            ->exists();
    }

    public function sessionCountsBySections(array $sectionIds): array {
        if ($sectionIds === []) {
            return [];
        }

        return ClassSession::whereIn('section_id', $sectionIds)
            ->selectRaw('section_id, COUNT(*) as total_sessions')
            ->groupBy('section_id')
            ->pluck('total_sessions', 'section_id')
            ->all();
    }

    public function attendedCountsByStudentAndSections(int $studentId, array $sectionIds): array {
        if ($sectionIds === []) {
            return [];
        }

        return Attendance::query()
            ->join('class_session', 'class_session.id', '=', 'attendance.session_id')
            ->where('attendance.student_id', $studentId)
            ->whereIn('class_session.section_id', $sectionIds)
            ->whereIn('attendance.attendance_status', ['Present', 'Late', 'Excused'])
            ->selectRaw('class_session.section_id, COUNT(*) as attended_sessions')
            ->groupBy('class_session.section_id')
            ->pluck('attended_sessions', 'class_session.section_id')
            ->all();
    }

    public function documentsByUser(int $userId, int $limit = 10): Collection {
        return DB::table('document_registration')
            ->where('user_id', $userId)
            ->orderByDesc('uploaded_at')
            ->limit($limit)
            ->select(['id', 'file_name', 'file_type', 'status', 'observations', 'uploaded_at'])
            ->get();
    }

    public function createDocument(array $data): int {
        return (int) DB::table('document_registration')->insertGetId($data);
    }
}