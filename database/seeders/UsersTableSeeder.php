<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Get the actual role IDs from the database
        $adminRoleId = DB::table('roles')->where('name', 'admin')->value('id');
        $konselorRoleId = DB::table('roles')->where('name', 'konselor')->value('id');
        $userRoleId = DB::table('roles')->where('name', 'user')->value('id');
        $superAdminRoleId = DB::table('roles')->where('name', 'super_admin')->value('id');

        $users = [
            [
                'name' => 'Admin User',
                'username' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password123'),
                'role_id' => $adminRoleId,
                'avatar' => 'avatars/admin.jpg',
                'bio' => 'System Administrator',
                'tokens_balance' => 1000,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Professional Counselor',
                'username' => 'Professional Counselor',
                'email' => 'konselor@example.com',
                'password' => Hash::make('password123'),
                'role_id' => $konselorRoleId,
                'avatar' => 'avatars/counselor.jpg',
                'bio' => 'Licensed Mental Health Professional',
                'tokens_balance' => 500,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Regular User',
                'username' => 'Regular User',
                'email' => 'user@example.com',
                'password' => Hash::make('password123'),
                'role_id' => $userRoleId,
                'avatar' => 'avatars/user1.jpg',
                'bio' => 'Mental Health Enthusiast',
                'tokens_balance' => 100,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Test User 2',
                'username' => 'Test User 2',
                'email' => 'user2@example.com',
                'password' => Hash::make('password123'),
                'role_id' => $userRoleId,
                'avatar' => 'avatars/user2.jpg',
                'bio' => 'Looking for support',
                'tokens_balance' => 50,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            // Add a super admin user if needed
            [
                'name' => 'Super Admin',
                'username' => 'Super Admin',
                'email' => 'superadmin@example.com',
                'password' => Hash::make('password123'),
                'role_id' => $superAdminRoleId,
                'avatar' => 'avatars/superadmin.jpg',
                'bio' => 'Super Administrator',
                'tokens_balance' => 2000,
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('users')->insert($users);
    }
}