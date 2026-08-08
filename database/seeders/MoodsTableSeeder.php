<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MoodsTableSeeder extends Seeder
{
    public function run()
    {
        $moods = [
            ['user_id' => 3, 'mood' => 'happy', 'note' => 'Had a great meditation session', 'created_at' => now()],
            ['user_id' => 3, 'mood' => 'calm', 'note' => 'Feeling peaceful after yoga', 'created_at' => now()->subDays(1)],
            ['user_id' => 4, 'mood' => 'anxious', 'note' => 'Work stress getting to me', 'created_at' => now()],
            ['user_id' => 4, 'mood' => 'tired', 'note' => 'Need better sleep routine', 'created_at' => now()->subDays(2)],
            ['user_id' => 2, 'mood' => 'energetic', 'note' => 'Helping clients always brings joy', 'created_at' => now()->subDays(1)],
        ];

        DB::table('moods')->insert($moods);
    }
}