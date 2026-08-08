<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'description',
        'media_path'
    ];

    protected $casts = [
        'type' => 'string'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'exercise_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}