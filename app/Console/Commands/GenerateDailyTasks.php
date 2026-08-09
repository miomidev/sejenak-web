<?php

namespace App\Console\Commands;

use App\Services\TaskGeneratorService;
use Illuminate\Console\Command;
use Carbon\Carbon;

class GenerateDailyTasks extends Command
{
    protected $signature = 'tasks:generate {--date= : Date to generate tasks for (Y-m-d)} {--user= : Generate for specific user ID}';
    protected $description = 'Generate daily tasks for all users based on mood, journal, and templates';

    public function handle(TaskGeneratorService $taskService): int
    {
        $date = $this->option('date') ?? Carbon::today()->toDateString();
        $userId = $this->option('user');

        $this->info("Generating daily tasks for {$date}...");

        if ($userId) {
            $user = \App\Models\User::find($userId);
            if (!$user) {
                $this->error("User with ID {$userId} not found.");
                return Command::FAILURE;
            }

            $count = $taskService->generateForUser($user, $date);
            $this->info("Generated {$count} tasks for user {$user->name}.");
        } else {
            $count = $taskService->generateForAllUsers($date);
            $this->info("Generated {$count} tasks for all active users.");
        }

        return Command::SUCCESS;
    }
}
