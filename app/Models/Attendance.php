<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attendance extends Model
{
    protected $table = 'attendance';

    public $timestamps = false;

    protected $fillable = [
        'session_id',
        'student_id',
        'registered_by_id',
        'attendance_status',
        'registration_method',
        'observation',
        'recorded_at',
    ];

    protected $casts = [
        'recorded_at' => 'datetime',
    ];

    public function session(): BelongsTo
    {
        return $this->belongsTo(ClassSession::class, 'session_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'student_id');
    }

    public function registeredBy(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'registered_by_id');
    }
}