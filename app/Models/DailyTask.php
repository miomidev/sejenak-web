<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyTask extends Model
{
    use HasFactory;

    protected $table = 'daily_tasks';

    protected $fillable = [
        'user_id',
        'task_template_id',
        'date',
        'title',
        'description',
        'category',
        'type',
        'source',
        'points',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'date' => 'date',
        'points' => 'integer',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public const SOURCES = ['mood', 'journal', 'template', 'ai'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function taskTemplate()
    {
        return $this->belongsTo(TaskTemplate::class);
    }

    public function userDailyTask()
    {
        return $this->hasOne(UserDailyTask::class);
    }

    public function scopeForDate($query, $date)
    {
        return $query->where('date', $date);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopePending($query)
    {
        return $query->where('is_completed', false);
    }
}
