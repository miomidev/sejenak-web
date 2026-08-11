<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TokenSettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\Setting::updateOrCreate(
            ['key' => 'session_price'],
            ['value' => '500']
        );

        $packages = [
            ['name' => 'Paket Basic', 'token_amount' => 50, 'price' => 2500, 'icon' => 'spa_rounded'],
            ['name' => 'Paket Hemat', 'token_amount' => 120, 'price' => 6000, 'icon' => 'savings_rounded'],
            ['name' => 'Paket Medium', 'token_amount' => 250, 'price' => 12500, 'icon' => 'card_giftcard_rounded'],
            ['name' => 'Paket Mega', 'token_amount' => 550, 'price' => 27500, 'icon' => 'star_rounded'],
            ['name' => 'Paket Super', 'token_amount' => 1200, 'price' => 60000, 'icon' => 'local_fire_department_rounded'],
            ['name' => 'Paket Ultimate', 'token_amount' => 3000, 'price' => 150000, 'icon' => 'rocket_launch_rounded'],
        ];

        foreach ($packages as $pkg) {
            \App\Models\TokenPackage::updateOrCreate(
                ['name' => $pkg['name']],
                $pkg
            );
        }
    }
}
