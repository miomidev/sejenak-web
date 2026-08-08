<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeLog extends Model
{
    use HasFactory;

    protected $table = 'challenge_logs';

    protected $fillable = [
        'user_challenge_id',
        'notes',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array', // otomatis decode/encode JSON ke array
    ];

    // Relasi ke UserChallenge
    public function userChallenge()
    {
        return $this->belongsTo(UserChallenge::class);
    }
}
