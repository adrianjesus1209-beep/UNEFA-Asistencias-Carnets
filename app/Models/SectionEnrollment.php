<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SectionEnrollment extends Model
{
    protected $table = 'section_enrollment';

    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'section_id',
        'period_id',
        'status',
        'is_dragged',
        'final_grade',
        'validated_by_coordinator',
        'is_cycle_closed',
        'assigned_at',
        'updated_at',
    ];

    protected $casts = [
        'is_dragged'               => 'boolean',
        'validated_by_coordinator' => 'boolean',
        'is_cycle_closed'          => 'boolean',
        'assigned_at'              => 'datetime',
        'updated_at'               => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'student_id');
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class, 'period_id');
    }
}