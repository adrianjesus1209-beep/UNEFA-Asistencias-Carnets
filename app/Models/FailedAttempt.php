<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FailedAttempt extends Model
{
    protected $table = 'failed_attempt';

    public $timestamps = false;

    protected $fillable = [
        'ip_address',
        'attempt_type',
        'identifier',
        'attempted_at',
    ];

    protected $casts = [
        'attempted_at' => 'datetime',
    ];
}