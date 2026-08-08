<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'content',
        'title',
        'image',
        'is_anonymous',
        'is_banned',
        'is_pinned',
        'ban_reason',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_banned'    => 'boolean',
        'is_pinned'    => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }
    public function scopeNotBanned($query)
    {
        return $query->where('is_banned', false);
    }
    public function isLikedByUser()
    {
        return $this->likes()->where('user_id', Auth::id())->exists();
    }
    public function scopeBanned($query)
    {
        return $query->where('is_banned', true);
    }
}