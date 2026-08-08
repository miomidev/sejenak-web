<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ChallengeUser extends Pivot
{
    use HasFactory;

    protected $table = 'challenge_user';

    protected $fillable = [
        'challenge_id',
        'user_id',
        'status'
    ];

    protected $casts = [
        'status' => 'string'
    ];
}