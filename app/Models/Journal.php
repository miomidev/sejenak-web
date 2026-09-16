<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Journal extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'content',
        'audio_path',
        'audio_duration',
        'transcription_model',
        'transcription_confidence',
        'mood',
        'category',
        'card_type',
        'is_voice_entry',
        'ai_metadata',
    ];

    protected $casts = [
        'is_voice_entry' => 'boolean',
        'ai_metadata' => 'array',
        'audio_duration' => 'float',
        'transcription_confidence' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function characterConversations()
    {
        return $this->hasMany(CharacterConversation::class, 'journal_entry_id');
    }

    public function scopeVoiceEntries($query)
    {
        return $query->where('is_voice_entry', true);
    }

    public function scopeByMood($query, $mood)
    {
        return $query->where('mood', $mood);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByCardType($query, $cardType)
    {
        return $query->where('card_type', $cardType);
    }
}