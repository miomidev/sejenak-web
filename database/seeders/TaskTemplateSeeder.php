<?php

namespace Database\Seeders;

use App\Models\TaskTemplate;
use Illuminate\Database\Seeder;

class TaskTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $templates = [
            // Daily Activity
            [
                'title' => 'Minum Air Putih 8 Gelas',
                'description' => 'Pastikan kamu minum setidaknya 8 gelas air hari ini untuk menjaga tubuh tetap terhidrasi.',
                'category' => 'daily_activity',
                'type' => 'off_app',
                'mood_trigger' => null,
                'points' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Bersihkan Meja Kerja',
                'description' => 'Luangkan 10 menit untuk merapikan dan membersihkan meja kerjamu.',
                'category' => 'daily_activity',
                'type' => 'off_app',
                'mood_trigger' => null,
                'points' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Jalan Santai 15 Menit',
                'description' => 'Lakukan jalan santai atau peregangan selama 15 menit untuk menjaga tubuh tetap aktif.',
                'category' => 'daily_activity',
                'type' => 'off_app',
                'mood_trigger' => 'tired',
                'points' => 15,
                'is_active' => true,
            ],

            // Mental Recovery
            [
                'title' => 'Meditasi 5 Menit',
                'description' => 'Lakukan meditasi singkat selama 5 menit untuk menenangkan pikiran.',
                'category' => 'mental_recovery',
                'type' => 'in_app',
                'mood_trigger' => 'stressed',
                'points' => 15,
                'is_active' => true,
            ],
            [
                'title' => 'Tulis 3 Hal Baik Hari Ini',
                'description' => 'Tuliskan minimal 3 hal baik yang terjadi hari ini dalam jurnalmu.',
                'category' => 'mental_recovery',
                'type' => 'in_app',
                'mood_trigger' => 'sad',
                'points' => 15,
                'is_active' => true,
            ],
            [
                'title' => 'Istirahat dari Layar 10 Menit',
                'description' => 'Jauhi semua layar gadget selama 10 menit dan biarkan mata beristirahat.',
                'category' => 'mental_recovery',
                'type' => 'off_app',
                'mood_trigger' => 'anxious',
                'points' => 10,
                'is_active' => true,
            ],

            // Brain Refresh
            [
                'title' => 'Baca Artikel Baru 10 Menit',
                'description' => 'Baca artikel atau buku tentang topik yang menarik selama 10 menit.',
                'category' => 'brain_refresh',
                'type' => 'off_app',
                'mood_trigger' => null,
                'points' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Teka-Teki Otak',
                'description' => 'Selesaikan teka-teki atau puzzle sederhana untuk melatih otak.',
                'category' => 'brain_refresh',
                'type' => 'off_app',
                'mood_trigger' => null,
                'points' => 10,
                'is_active' => true,
            ],

            // Physical Health
            [
                'title' => 'Latihan Pernapasan 4-4-4-4',
                'description' => 'Lakukan teknik pernapasan kotak 4-4-4-4 sebanyak 3 kali.',
                'category' => 'physical_health',
                'type' => 'in_app',
                'mood_trigger' => 'anxious',
                'points' => 15,
                'is_active' => true,
            ],
            [
                'title' => 'Peregangan Pagi',
                'description' => 'Lakukan peregangan ringan saat bangun tidur selama 5 menit.',
                'category' => 'physical_health',
                'type' => 'off_app',
                'mood_trigger' => 'tired',
                'points' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Tidur 30 Menit Lebih Awal',
                'description' => 'Usahakan untuk tidur 30 menit lebih awal dari biasanya malam ini.',
                'category' => 'physical_health',
                'type' => 'off_app',
                'mood_trigger' => 'tired',
                'points' => 20,
                'is_active' => true,
            ],

            // Time Management
            [
                'title' => 'Buat To-Do List Hari Ini',
                'description' => 'Tuliskan 3-5 prioritas utama yang harus diselesaikan hari ini.',
                'category' => 'time_management',
                'type' => 'in_app',
                'mood_trigger' => null,
                'points' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Fokus 25 Menit (Pomodoro)',
                'description' => 'Lakukan satu sesi Pomodoro 25 menit tanpa gangguan.',
                'category' => 'time_management',
                'type' => 'off_app',
                'mood_trigger' => null,
                'points' => 15,
                'is_active' => true,
            ],

            // Self Discipline
            [
                'title' => 'Tunda Gratifikasi 30 Menit',
                'description' => 'Tunda aktivitas menyenangkan (scrolling, nonton) selama 30 menit dan fokus pada tugas.',
                'category' => 'self_discipline',
                'type' => 'off_app',
                'mood_trigger' => null,
                'points' => 15,
                'is_active' => true,
            ],
            [
                'title' => 'Bangun Tanpa Snooze',
                'description' => 'Bangun dari alarm pertama tanpa menekan tombol snooze.',
                'category' => 'self_discipline',
                'type' => 'off_app',
                'mood_trigger' => null,
                'points' => 20,
                'is_active' => true,
            ],

            // Social Interaction
            [
                'title' => 'Hubungi Orang Tersayang',
                'description' => 'Kirim pesan atau telepon seseorang yang kamu sayangi.',
                'category' => 'social_interaction',
                'type' => 'off_app',
                'mood_trigger' => 'sad',
                'points' => 15,
                'is_active' => true,
            ],
            [
                'title' => 'Ucapkan Terima Kasih',
                'description' => 'Ucapkan terima kasih kepada seseorang yang telah membantumu hari ini.',
                'category' => 'social_interaction',
                'type' => 'off_app',
                'mood_trigger' => 'happy',
                'points' => 10,
                'is_active' => true,
            ],

            // Mindfulness
            [
                'title' => 'Perhatikan 5 Hal di Sekitarmu',
                'description' => 'Perhatikan 5 hal yang bisa kamu lihat, 4 yang bisa kamu dengar, 3 yang bisa kamu sentuh.',
                'category' => 'mindfulness',
                'type' => 'in_app',
                'mood_trigger' => 'anxious',
                'points' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Makan dengan Penuh Kesadaran',
                'description' => 'Makan satu kali tanpa distraksi (HP, TV), fokus pada rasa dan tekstur makanan.',
                'category' => 'mindfulness',
                'type' => 'off_app',
                'mood_trigger' => null,
                'points' => 10,
                'is_active' => true,
            ],

            // Habit Building
            [
                'title' => 'Bangun di Jam yang Sama',
                'description' => 'Bangun di jam yang sama seperti kemarin untuk membangun rutinitas.',
                'category' => 'habit_building',
                'type' => 'off_app',
                'mood_trigger' => null,
                'points' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Tulis Jurnal 100 Kata',
                'description' => 'Tuliskan minimal 100 kata tentang perasaan dan pikiranmu hari ini.',
                'category' => 'habit_building',
                'type' => 'in_app',
                'mood_trigger' => null,
                'points' => 15,
                'is_active' => true,
            ],

            // Self Reflection
            [
                'title' => 'Evaluasi Hari Ini',
                'description' => 'Luangkan 5 menit untuk mengevaluasi apa yang sudah dan belum diselesaikan hari ini.',
                'category' => 'self_reflection',
                'type' => 'in_app',
                'mood_trigger' => null,
                'points' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Tulis Rencana Besok',
                'description' => 'Tuliskan minimal 3 hal yang ingin kamu capai besok.',
                'category' => 'self_reflection',
                'type' => 'in_app',
                'mood_trigger' => null,
                'points' => 10,
                'is_active' => true,
            ],
            [
                'title' => 'Ucapkan Syukur',
                'description' => 'Tuliskan 3 hal yang kamu syukuri dari hari ini.',
                'category' => 'self_reflection',
                'type' => 'in_app',
                'mood_trigger' => 'sad',
                'points' => 15,
                'is_active' => true,
            ],
        ];

        foreach ($templates as $template) {
            TaskTemplate::create($template);
        }
    }
}
