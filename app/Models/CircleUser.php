<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CircleUser extends Pivot
{
    use HasFactory;

    protected $table = 'circle_user';

    protected $fillable = [
        'circle_id',
        'user_id',
        'role'
    ];

    protected $casts = [
        'role' => 'string'
    ];
}