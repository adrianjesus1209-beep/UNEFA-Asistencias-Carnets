<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Profile extends Model
{
    protected $table = 'profile';

    public $timestamps = true;

    protected $fillable = [
        'career_id',
        'id_number',
        'id_type',
        'first_name',
        'middle_name',
        'last_name',
        'second_last_name',
        'current_semester',
        'has_dragged_subjects',
        'address',
        'phone',
        'job_title',
        'profile_picture',
    ];

    protected $casts = [
        'current_semester'     => 'integer',
        'has_dragged_subjects' => 'boolean',
    ];

    public function career(): BelongsTo
    {
        return $this->belongsTo(Career::class, 'career_id');
    }

    public function userAccount(): HasOne
    {
        return $this->hasOne(UserAccount::class, 'profile_id');
    }

    public function getFullNameAttribute(): string
    {
        $parts = array_filter([
            $this->first_name,$this->middle_name,
            $this->last_name,$this->second_last_name,
        ]);

        return implode(' ', $parts);
    }
}