<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChallengesTableSeeder extends Seeder
{
    public function run()
    {
        $challenges = [
            [
                'title' => '7 Days of Gratitude',
                'description' => 'Write down 3 things you\'re grateful for each day for 7 days',
                'date' => now()->addDays(7),
            ],
            [
                'title' => 'Mindful Breathing Challenge',
                'description' => 'Practice 10 minutes of mindful breathing daily for 14 days',
                'date' => now()->addDays(14),
            ],
            [
                'title' => 'Digital Detox Weekend',
                'description' => 'Reduce screen time and focus on real connections for a weekend',
                'date' => now()->addDays(3),
            ],
            [
                'title' => '30-Day Meditation',
                'description' => 'Meditate for at least 15 minutes every day for 30 days',
                'date' => now()->addDays(30),
            ],
        ];

        DB::table('challenges')->insert($challenges);
    }
}