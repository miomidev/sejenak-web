<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            ChallengesTableSeeder::class,
            ChallengeUserTableSeeder::class,
            PostsTableSeeder::class,
            MoodsTableSeeder::class,
            AudiosTableSeeder::class,
            DailyChallengesSeeder::class,
        ]);

    }
}
