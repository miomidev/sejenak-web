<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DailyChallengesSeeder extends Seeder
{
    public function run(): void
    {
        $now = Carbon::now();

        $challenges = [
            [
                'title' => 'Minum air putih setelah bangun tidur',
                'description' => 'Mulailah harimu dengan minum satu gelas air putih.',
                'type' => 'off_app',
                'category' => 'physical_health',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Cuci muka di pagi hari',
                'description' => 'Segarkan wajahmu agar lebih siap menjalani hari.',
                'type' => 'off_app',
                'category' => 'daily_activity',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Menulis jurnal harian',
                'description' => 'Tuangkan pikiran dan perasaanmu hari ini.',
                'type' => 'in_app',
                'category' => 'self_reflection',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Posting perasaan ke komunitas',
                'description' => 'Bagikan perasaanmu hari ini dengan komunitas.',
                'type' => 'in_app',
                'category' => 'social_interaction',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'title' => 'Merapikan tempat tidur',
                'description' => 'Awali hari dengan kebiasaan positif: rapikan tempat tidurmu.',
                'type' => 'off_app',
                'category' => 'habit_building',
                'is_active' => true,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('daily_challenges')->insert($challenges);
    }
}
