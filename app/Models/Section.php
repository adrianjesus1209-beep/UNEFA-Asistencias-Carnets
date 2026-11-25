<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Section extends Model
{
    protected $table = 'section';

    protected $fillable = [
        'subject_id',
        'teacher_id',
        'period_id',
        'section_name',
        'classroom',
        'day_of_week',
        'start_time',
        'end_time',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(UserAccount::class, 'teacher_id');
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class, 'period_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(SectionEnrollment::class, 'section_id');
    }
}