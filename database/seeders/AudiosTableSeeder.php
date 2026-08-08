<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AudiosTableSeeder extends Seeder
{
    public function run()
    {
        $audios = [
            [
                'title' => 'Guided Meditation for Anxiety',
                'file_path' => 'audios/meditation_anxiety.mp3',
                'category' => 'meditation',
            ],
            [
                'title' => 'Deep Breathing Exercise',
                'file_path' => 'audios/breathing_exercise.mp3',
                'category' => 'exercise',
            ],
            [
                'title' => 'Sleep Story: Peaceful Garden',
                'file_path' => 'audios/sleep_story.mp3',
                'category' => 'sleep',
            ],
            [
                'title' => 'Morning Affirmations',
                'file_path' => 'audios/morning_affirmations.mp3',
                'category' => 'affirmation',
            ],
        ];

        DB::table('audios')->insert($audios);
    }
}