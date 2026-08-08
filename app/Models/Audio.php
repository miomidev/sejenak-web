<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audio extends Model
{
    use HasFactory;

    protected $table = 'audios'; // pastikan sesuai dengan nama tabel di migration

    protected $fillable = [
        'title',
        'file_path',
        'category',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_audio')
                    ->withTimestamps();
    }
}