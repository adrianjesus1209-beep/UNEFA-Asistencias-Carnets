<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class SystemRole extends Model
{
    protected $table = 'system_role';

    public $timestamps = false;

    protected $fillable = [
        'role_name',
        'hierarchy_level',
        'description',
    ];

    protected $casts = [
        'hierarchy_level' => 'integer',
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(
            UserAccount::class,
            'user_role',
            'role_id',
            'user_id'
        );
    }
}