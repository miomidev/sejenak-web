<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskTemplate extends Model
{
    use HasFactory;

    protected $table = 'task_templates';

    protected $fillable = [
        'title',
        'description',
        'category',
        'type',
        'mood_trigger',
        'points',
        'is_active',
    ];

    protected $casts = [
        'points' => 'integer',
        'is_active' => 'boolean',
    ];

    public const CATEGORIES = [
        'daily_activity',
        'mental_recovery',
        'brain_refresh',
        'physical_health',
        'time_management',
        'self_discipline',
        'social_interaction',
        'mindfulness',
        'habit_building',
        'self_reflection',
    ];

    public const TYPE_IN_APP = 'in_app';
    public const TYPE_OFF_APP = 'off_app';

    public function dailyTasks()
    {
        return $this->hasMany(DailyTask::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeForMood($query, $mood)
    {
        return $query->where('mood_trigger', $mood)->orWhereNull('mood_trigger');
    }
}
