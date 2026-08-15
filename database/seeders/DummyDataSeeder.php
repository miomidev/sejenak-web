<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Journal;
use App\Models\Session;
use App\Models\Message;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Str;

class DummyDataSeeder extends Seeder
{
    public function run()
    {
        // Get normal users and counselor
        $users = User::whereHas('role', function($q) { $q->where('name', 'user'); })->take(2)->get();
        $counselor = User::whereHas('role', function($q) { $q->where('name', 'konselor'); })->first();

        if ($users->isEmpty() || !$counselor) {
            $this->command->warn('Pastikan seeder UsersTableSeeder sudah dijalankan sebelumnya!');
            return;
        }

        $mainUser = $users->first();

        // 1. Seed Journals
        $this->command->info('Seeding Journals...');
        $journalTitles = [
            'Hari yang cukup melelahkan',
            'Merasa lebih baik setelah meditasi',
            'Bersyukur untuk hal-hal kecil',
            'Sedikit cemas memikirkan masa depan',
            'Tidur sangat nyenyak semalam'
        ];
        
        foreach ($journalTitles as $index => $title) {
            Journal::create([
                'user_id' => $mainUser->id,
                'title' => $title,
                'content' => 'Ini adalah isi dari jurnal ' . $title . '. Hari ini saya belajar banyak hal tentang mengelola emosi.',
                'created_at' => Carbon::now()->subDays(5 - $index),
                'updated_at' => Carbon::now()->subDays(5 - $index),
            ]);
        }

        // 2. Seed Transactions
        $this->command->info('Seeding Transactions...');
        Transaction::create([
            'order_id' => 'TRX-' . Str::upper(Str::random(10)),
            'user_id' => $mainUser->id,
            'package_name' => 'Paket Premium 1000 Token',
            'token_amount' => 1000,
            'price' => 50000,
            'status' => 'success',
            'created_at' => Carbon::now()->subDays(3),
            'updated_at' => Carbon::now()->subDays(3),
        ]);
        
        Transaction::create([
            'order_id' => 'TRX-' . Str::upper(Str::random(10)),
            'user_id' => $mainUser->id,
            'package_name' => 'Paket Hemat 500 Token',
            'token_amount' => 500,
            'price' => 25000,
            'status' => 'pending',
            'created_at' => Carbon::now()->subHours(2),
            'updated_at' => Carbon::now()->subHours(2),
        ]);

        // 3. Seed Sessions
        $this->command->info('Seeding Sessions...');
        
        // Sesi Selesai (Completed)
        $completedSession = Session::create([
            'user_id' => $mainUser->id,
            'konselor_id' => $counselor->id,
            'status' => 'completed',
            'created_at' => Carbon::now()->subDays(2),
            'updated_at' => Carbon::now()->subDays(2),
        ]);

        // Sesi Ongoing
        $ongoingSession = Session::create([
            'user_id' => $mainUser->id,
            'konselor_id' => $counselor->id,
            'status' => 'ongoing',
            'created_at' => Carbon::now()->subHours(5),
            'updated_at' => Carbon::now()->subHours(1),
        ]);

        // Sesi Pending
        $pendingSession = Session::create([
            'user_id' => $users->last()->id,
            'konselor_id' => $counselor->id,
            'status' => 'pending',
            'created_at' => Carbon::now()->subMinutes(30),
            'updated_at' => Carbon::now()->subMinutes(30),
        ]);

        // 4. Seed Messages for Ongoing Session
        $this->command->info('Seeding Messages...');
        $messages = [
            ['sender_id' => $mainUser->id, 'receiver_id' => $counselor->id, 'body' => 'Halo dok, selamat siang.'],
            ['sender_id' => $counselor->id, 'receiver_id' => $mainUser->id, 'body' => 'Halo, selamat siang. Ada yang bisa saya bantu hari ini?'],
            ['sender_id' => $mainUser->id, 'receiver_id' => $counselor->id, 'body' => 'Akhir-akhir ini saya merasa sangat kewalahan dengan tugas-tugas saya.'],
            ['sender_id' => $counselor->id, 'receiver_id' => $mainUser->id, 'body' => 'Saya mengerti, mari kita bicarakan pelan-pelan. Sejak kapan mulai merasakannya?']
        ];

        foreach ($messages as $index => $msg) {
            Message::create([
                'sender_id' => $msg['sender_id'],
                'receiver_id' => $msg['receiver_id'],
                'body' => $msg['body'],
                'read' => true,
                'created_at' => Carbon::now()->subHours(1)->addMinutes($index * 2),
                'updated_at' => Carbon::now()->subHours(1)->addMinutes($index * 2),
            ]);
        }

        $this->command->info('Semua Dummy Data tambahan berhasil dibuat!');
    }
}
