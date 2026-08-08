<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserChallenge extends Model
{
    use HasFactory;

    protected $table = 'user_challenges';

    protected $fillable = [
        'user_id',
        'daily_challenge_id',
        'date',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'date' => 'date',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    // Relasi ke User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi ke DailyChallenge
    public function dailyChallenge()
    {
        return $this->belongsTo(DailyChallenge::class);
    }
}
