<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CharacterConversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ai_character_id',
        'journal_entry_id',
        'message',
        'is_from_character',
    ];

    protected $casts = [
        'is_from_character' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function character()
    {
        return $this->belongsTo(AiCharacter::class, 'ai_character_id');
    }

    public function journalEntry()
    {
        return $this->belongsTo(Journal::class, 'journal_entry_id');
    }

    public function scopeForCharacter($query, $characterId)
    {
        return $query->where('ai_character_id', $characterId);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeRecent($query, $limit = 20)
    {
        return $query->orderBy('created_at', 'desc')->limit($limit);
    }
}
