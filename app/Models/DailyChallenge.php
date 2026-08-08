<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DailyChallenge extends Model
{
    use HasFactory;

    // Nama tabel jika tidak sesuai konvensi
    protected $table = 'daily_challenges';

    // Field yang boleh diisi mass assignment
    protected $fillable = [
        'title',
        'description',
        'type',
        'category',
        'is_active',
    ];

    /**
     * Tipe challenge (enum)
     */
    public const TYPE_IN_APP = 'in_app';
    public const TYPE_OFF_APP = 'off_app';

    /**
     * Kategori challenge (enum)
     */
    public const CATEGORY_DAILY_ACTIVITY = 'daily_activity';
    public const CATEGORY_MENTAL_RECOVERY = 'mental_recovery';
    public const CATEGORY_BRAIN_REFRESH = 'brain_refresh';
    public const CATEGORY_PHYSICAL_HEALTH = 'physical_health';
    public const CATEGORY_TIME_MANAGEMENT = 'time_management';
    public const CATEGORY_SELF_DISCIPLINE = 'self_discipline';
    public const CATEGORY_SOCIAL_INTERACTION = 'social_interaction';
    public const CATEGORY_MINDFULNESS = 'mindfulness';
    public const CATEGORY_HABIT_BUILDING = 'habit_building';
    public const CATEGORY_SELF_REFLECTION = 'self_reflection';

    // Contoh relasi jika diperlukan
    // public function userChallenges()
    // {
    //     return $this->hasMany(UserChallenge::class);
    // }
}
