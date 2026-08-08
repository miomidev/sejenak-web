<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ExerciseUser extends Pivot
{
    use HasFactory;

    protected $table = 'exercise_user';

    protected $fillable = [
        'exercise_id',
        'user_id',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];
}