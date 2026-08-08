<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChallengeUserTableSeeder extends Seeder
{
    public function run()
    {
        $participations = [
            ['challenge_id' => 1, 'user_id' => 3, 'status' => 'in_progress'],
            ['challenge_id' => 1, 'user_id' => 4, 'status' => 'completed'],
            ['challenge_id' => 2, 'user_id' => 3, 'status' => 'pending'],
            ['challenge_id' => 3, 'user_id' => 4, 'status' => 'in_progress'],
            ['challenge_id' => 4, 'user_id' => 3, 'status' => 'completed'],
        ];

        DB::table('challenge_user')->insert($participations);
    }
}