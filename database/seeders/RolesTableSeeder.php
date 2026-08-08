<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            ['name' => 'admin'],
            ['name' => 'konselor'],
            ['name' => 'user'],
            ['name' => 'super_admin']
        ];

        DB::table('roles')->insert($roles);
    }
}