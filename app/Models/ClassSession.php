<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ClassSession extends Model
{
    protected $table = 'class_session';

    public $timestamps = false;

    protected $fillable = [
        'section_id',
        'period_id',
        'opened_by_id',
        'session_date',
        'start_time',
        'end_time',
        'tolerance_minutes',
        'session_type',
        'week_number',
        'status',
        'observations',
        'created_at',
    ];

    protected $casts = [
        'session_date' => 'date',
        'start_time'   => 'datetime:H:i:s',
        'end_time'     => 'datetime:H:i:s',
        'created_at'   => 'datetime',
    ];

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class, 'period_id');
    }

    public function opener(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'opened_by_id');
    }

    public function attendance(): HasMany
    {
        return $this->hasMany(Attendance::class, 'session_id');
    }
}