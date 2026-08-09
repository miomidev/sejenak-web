<?php

namespace App\Services;

use App\Models\User;
use App\Models\DailyTask;
use App\Models\UserDailyTask;
use App\Models\TaskTemplate;
use App\Models\Mood;
use App\Models\Journal;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TaskGeneratorService
{
    private const TASKS_PER_USER = 5;
    private const MOOD_TASK_WEIGHT = 3;
    private const JOURNAL_TASK_WEIGHT = 2;
    private const TEMPLATE_TASK_WEIGHT = 1;

    private $moodMapping = [
        'happy' => [
            'preferred_categories' => ['self_reflection', 'social_interaction', 'habit_building'],
            'avoid_categories' => [],
            'message_prefix' => 'Kamu lagi baik, pertahankan!',
        ],
        'sad' => [
            'preferred_categories' => ['mental_recovery', 'mindfulness', 'self_reflection'],
            'avoid_categories' => ['social_interaction'],
            'message_prefix' => 'Kamu butuh waktu untuk diri sendiri.',
        ],
        'anxious' => [
            'preferred_categories' => ['mindfulness', 'mental_recovery', 'physical_health'],
            'avoid_categories' => ['brain_refresh'],
            'message_prefix' => 'Tarik napas dalam, kita hadapi bareng.',
        ],
        'stressed' => [
            'preferred_categories' => ['mental_recovery', 'mindfulness', 'physical_health'],
            'avoid_categories' => [],
            'message_prefix' => 'Waktunya rehat sejenak.',
        ],
        'calm' => [
            'preferred_categories' => ['habit_building', 'daily_activity', 'self_reflection'],
            'avoid_categories' => [],
            'message_prefix' => 'Kondisi tenang, saatnya produktif.',
        ],
        'angry' => [
            'preferred_categories' => ['mindfulness', 'physical_health', 'mental_recovery'],
            'avoid_categories' => ['social_interaction'],
            'message_prefix' => 'Kita keluarkan emosi dengan cara sehat.',
        ],
        'tired' => [
            'preferred_categories' => ['physical_health', 'mental_recovery', 'daily_activity'],
            'avoid_categories' => [],
            'message_prefix' => 'Istirahat itu penting, tapi kita tetap bergerak.',
        ],
        'energetic' => [
            'preferred_categories' => ['physical_health', 'social_interaction', 'daily_activity'],
            'avoid_categories' => [],
            'message_prefix' => 'Energimu luar biasa! Gunakan dengan baik.',
        ],
        'relaxed' => [
            'preferred_categories' => ['self_reflection', 'habit_building', 'mindfulness'],
            'avoid_categories' => [],
            'message_prefix' => 'Nikmati ketenanganmu.',
        ],
    ];

    /**
     * Generate daily tasks untuk semua user aktif
     */
    public function generateForAllUsers(?string $date = null): int
    {
        $date = $date ?? Carbon::today()->toDateString();
        $users = User::where('is_suspended', false)->get();
        $totalGenerated = 0;

        foreach ($users as $user) {
            $count = $this->generateForUser($user, $date);
            $totalGenerated += $count;
        }

        Log::info("Daily tasks generated for {$totalGenerated} tasks across " . $users->count() . " users on {$date}");
        return $totalGenerated;
    }

    /**
     * Generate daily tasks untuk satu user
     */
    public function generateForUser(User $user, ?string $date = null): int
    {
        $date = $date ?? Carbon::today()->toDateString();

        $existingCount = DailyTask::where('user_id', $user->id)
            ->where('date', $date)
            ->count();

        if ($existingCount >= self::TASKS_PER_USER) {
            return 0;
        }

        $recentMood = $this->getRecentMood($user->id);
        $recentJournal = $this->getRecentJournal($user->id);
        $selectedTemplates = $this->selectTemplates($recentMood, $recentJournal, self::TASKS_PER_USER);

        $generated = 0;

        DB::beginTransaction();
        try {
            foreach ($selectedTemplates as $templateData) {
                $dailyTask = DailyTask::create([
                    'user_id' => $user->id,
                    'task_template_id' => $templateData['template']->id ?? null,
                    'date' => $date,
                    'title' => $templateData['title'],
                    'description' => $templateData['description'],
                    'category' => $templateData['category'],
                    'type' => $templateData['type'] ?? 'in_app',
                    'source' => $templateData['source'],
                    'points' => $templateData['points'] ?? 10,
                    'is_completed' => false,
                ]);

                UserDailyTask::create([
                    'user_id' => $user->id,
                    'daily_task_id' => $dailyTask->id,
                    'status' => 'pending',
                    'points_earned' => 0,
                ]);

                $generated++;
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Failed to generate tasks for user {$user->id}: " . $e->getMessage());
            throw $e;
        }

        return $generated;
    }

    /**
     * Ambil mood terakhir user
     */
    private function getRecentMood(int $userId): ?string
    {
        $mood = Mood::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();

        return $mood?->mood;
    }

    /**
     * Ambil jurnal terakhir user
     */
    private function getRecentJournal(int $userId): ?Journal
    {
        return Journal::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->first();
    }

    /**
     * Pilih template berdasarkan mood dan jurnal
     */
    private function selectTemplates(?string $mood, ?Journal $journal, int $count): array
    {
        $selected = [];
        $usedTemplateIds = [];

        $moodData = $this->moodMapping[$mood] ?? null;
        $preferredCategories = $moodData['preferred_categories'] ?? [];

        if (!empty($preferredCategories)) {
            $moodTemplates = TaskTemplate::active()
                ->whereIn('category', $preferredCategories)
                ->whereNotIn('id', $usedTemplateIds)
                ->inRandomOrder()
                ->limit(min(2, $count))
                ->get();

            foreach ($moodTemplates as $template) {
                $selected[] = [
                    'template' => $template,
                    'title' => $template->title,
                    'description' => $template->description,
                    'category' => $template->category,
                    'type' => $template->type,
                    'source' => 'mood',
                    'points' => $template->points,
                ];
                $usedTemplateIds[] = $template->id;
                $count--;
            }
        }

        if ($journal && $count > 0) {
            $journalTask = $this->generateJournalTask($journal);
            if ($journalTask) {
                $selected[] = $journalTask;
                $count--;
            }
        }

        if ($count > 0) {
            $remainingTemplates = TaskTemplate::active()
                ->whereNotIn('id', $usedTemplateIds)
                ->inRandomOrder()
                ->limit($count)
                ->get();

            foreach ($remainingTemplates as $template) {
                $selected[] = [
                    'template' => $template,
                    'title' => $template->title,
                    'description' => $template->description,
                    'category' => $template->category,
                    'type' => $template->type,
                    'source' => 'template',
                    'points' => $template->points,
                ];
                $count--;
            }
        }

        return $selected;
    }

    /**
     * Generate task berdasarkan jurnal
     */
    private function generateJournalTask(Journal $journal): ?array
    {
        $content = strtolower($journal->content ?? '');
        $title = 'Refleksi Jurnal Hari Ini';

        if (str_contains($content, 'sedih') || str_contains($content, 'galau') || str_contains($content, 'kecewa')) {
            $title = 'Tuliskan 3 Hal Baik yang Terjadi Hari Ini';
        } elseif (str_contains($content, 'stres') || str_contains($content, 'lelah') || str_contains($content, 'capek')) {
            $title = 'Lakukan Relaksasi 5 Menit';
        } elseif (str_contains($content, 'senang') || str_contains($content, 'bahagia') || str_contains($content, 'syukur')) {
            $title = 'Bagikan Kebahagiaan ke Teman';
        }

        return [
            'template' => null,
            'title' => $title,
            'description' => 'Berdasarkan jurnal terakhirmu, lakukan aktivitas ini untuk kesejahteraan mentalmu.',
            'category' => 'self_reflection',
            'type' => 'in_app',
            'source' => 'journal',
            'points' => 15,
        ];
    }

    /**
     * Tandai task selesai
     */
    public function completeTask(int $userId, int $dailyTaskId, ?string $notes = null): ?UserDailyTask
    {
        $userTask = UserDailyTask::where('user_id', $userId)
            ->where('daily_task_id', $dailyTaskId)
            ->first();

        if (!$userTask || $userTask->status === UserDailyTask::STATUS_COMPLETED) {
            return null;
        }

        $dailyTask = DailyTask::find($dailyTaskId);

        $userTask->update([
            'status' => UserDailyTask::STATUS_COMPLETED,
            'notes' => $notes,
            'points_earned' => $dailyTask->points,
            'completed_at' => now(),
        ]);

        $dailyTask->update([
            'is_completed' => true,
            'completed_at' => now(),
        ]);

        $user = User::find($userId);
        if ($user) {
            $user->increment('tokens_balance', $dailyTask->points);
        }

        return $userTask;
    }

    /**
     * Ambil tasks user untuk tanggal tertentu
     */
    public function getUserTasks(int $userId, ?string $date = null): array
    {
        $date = $date ?? Carbon::today()->toDateString();

        $tasks = DailyTask::with('taskTemplate')
            ->where('user_id', $userId)
            ->where('date', $date)
            ->get();

        $userTasks = UserDailyTask::where('user_id', $userId)
            ->whereHas('dailyTask', function ($q) use ($date) {
                $q->where('date', $date);
            })
            ->get()
            ->keyBy('daily_task_id');

        $result = [];
        foreach ($tasks as $task) {
            $userTask = $userTasks->get($task->id);
            $result[] = [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'category' => $task->category,
                'type' => $task->type,
                'source' => $task->source,
                'points' => $task->points,
                'status' => $userTask?->status ?? 'pending',
                'completed_at' => $userTask?->completed_at,
                'points_earned' => $userTask?->points_earned ?? 0,
            ];
        }

        return $result;
    }

    /**
     * Ambil statistik task user
     */
    public function getUserStats(int $userId): array
    {
        $today = Carbon::today()->toDateString();
        $weekAgo = Carbon::now()->subDays(7)->toDateString();

        $todayTasks = DailyTask::where('user_id', $userId)
            ->where('date', $today)
            ->count();

        $todayCompleted = UserDailyTask::where('user_id', $userId)
            ->where('status', UserDailyTask::STATUS_COMPLETED)
            ->whereHas('dailyTask', function ($q) use ($today) {
                $q->where('date', $today);
            })
            ->count();

        $weekCompleted = UserDailyTask::where('user_id', $userId)
            ->where('status', UserDailyTask::STATUS_COMPLETED)
            ->whereHas('dailyTask', function ($q) use ($weekAgo) {
                $q->where('date', '>=', $weekAgo);
            })
            ->count();

        $totalPoints = UserDailyTask::where('user_id', $userId)
            ->where('status', UserDailyTask::STATUS_COMPLETED)
            ->sum('points_earned');

        return [
            'today_total' => $todayTasks,
            'today_completed' => $todayCompleted,
            'week_completed' => $weekCompleted,
            'total_points' => $totalPoints,
        ];
    }
}
