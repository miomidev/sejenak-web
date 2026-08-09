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
        'content_type',
        'description',
        'content',
        'video_url',
        'media_path',
        'author_name',
        'duration_minutes'
    ];

    protected $casts = [
        'type' => 'string',
        'content_type' => 'string'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'exercise_user')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}