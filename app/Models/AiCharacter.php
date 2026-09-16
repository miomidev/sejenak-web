<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AiCharacter extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'personality',
        'avatar_url',
        'first_message',
        'tone',
        'expertise',
        'is_active',
        'is_default',
    ];

    protected $casts = [
        'expertise' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function conversations()
    {
        return $this->hasMany(CharacterConversation::class, 'ai_character_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }
}
