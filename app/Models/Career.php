<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Career extends Model
{
    protected $table = 'career';

    protected $fillable = [
        'career_code',
        'career_name',
    ];

    public function profiles(): HasMany
    {
        return $this->hasMany(Profile::class, 'career_id');
    }
}