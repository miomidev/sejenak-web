<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDailyTask extends Model
{
    use HasFactory;

    protected $table = 'user_daily_tasks';

    protected $fillable = [
        'user_id',
        'daily_task_id',
        'status',
        'notes',
        'points_earned',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'points_earned' => 'integer',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public const STATUS_PENDING = 'pending';
    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_SKIPPED = 'skipped';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function dailyTask()
    {
        return $this->belongsTo(DailyTask::class);
    }

    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', self::STATUS_COMPLETED);
    }

    public function scopePending($query)
    {
        return $query->where('status', self::STATUS_PENDING);
    }
}
