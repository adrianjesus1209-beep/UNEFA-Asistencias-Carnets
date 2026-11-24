<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class UserAccount extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $table = 'user_account';

    public $timestamps = true;

    protected $fillable = [
        'profile_id',
        'username',
        'email',
        'password_hash',
        'qr_token',
        'security_token_hash',
        'security_token_prefix',
        'security_token_rotated_at',
        'security_token_revoked_at',
        'security_pin_hash',
        'pin_expires_at',
        'pin_updated_at',
        'status',
    ];

    protected $hidden = [
        'password_hash',
        'security_token_hash',
        'security_pin_hash',
        'qr_token',
    ];

    protected $casts = [
        'security_token_rotated_at' => 'datetime',
        'security_token_revoked_at' => 'datetime',
        'pin_expires_at'            => 'datetime',
        'pin_updated_at'            => 'datetime',
    ];

    public function getAuthPassword(): string
    {
        return (string) $this->password_hash;
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class, 'profile_id');
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(
            SystemRole::class,
            'user_role',
            'user_id',
            'role_id'
        )->withPivot([
            'is_active',
            'credential_number',
            'credential_issued_at',
            'credential_expires_at',
        ]);
    }

    public function auditLogs(): HasMany
    {
        return $this->hasMany(AuditLog::class, 'user_id');
    }

    public function sectionsAsTeacher(): HasMany
    {
        return $this->hasMany(Section::class, 'teacher_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(SectionEnrollment::class, 'student_id');
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class, 'student_id');
    }

    public function isActive(): bool
    {
        $status = strtolower(trim((string) $this->status));

        return in_array($status, ['approved', 'active', '1'], true);
    }

    public function primaryActiveRoleName(): ?string
    {
        $role = $this->roles()
            ->wherePivot('is_active', 1)
            ->orderBy('hierarchy_level')
            ->first();

        return $role?->role_name;
    }
}