<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Challenge extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'date'
    ];

    protected $casts = [
        'date' => 'date'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'challenge_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}