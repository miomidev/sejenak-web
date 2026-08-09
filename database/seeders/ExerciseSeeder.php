<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Exercise;

class ExerciseSeeder extends Seeder
{
    public function run()
    {
        $exercises = [
            [
                'title' => 'Panduan Pernapasan Diaphragmatic Redakan Cemas',
                'type' => 'breathing',
                'content_type' => 'video',
                'description' => 'Latihan pernapasan perut mendalam yang dipandu oleh Konselor untuk menurunkan detak jantung dan meredakan ketegangan tubuh saat cemas.',
                'content' => null,
                'video_url' => 'https://www.youtube.com/embed/inpok4MKVLM',
                'media_path' => null,
                'author_name' => 'Dr. Anisa Rahma, M.Psi (Konselor)',
                'duration_minutes' => 5,
            ],
            [
                'title' => 'Teknik Grounding 5-4-3-2-1 Saat Mengalami Panic Attack',
                'type' => 'grounding',
                'content_type' => 'video',
                'description' => 'Saksikan panduan instruksi kesadaran sensorik untuk mengatasi serangan panik secara mendadak.',
                'content' => null,
                'video_url' => 'https://www.youtube.com/embed/30VMIEmA144',
                'media_path' => null,
                'author_name' => 'Rian Hidayat, S.Psi (Konselor)',
                'duration_minutes' => 7,
            ],
            [
                'title' => 'Panduan Meditasi Kesadaran Penuh (Mindfulness) untuk Pemula',
                'type' => 'mindfulness',
                'content_type' => 'text',
                'description' => 'Artikel panduan lengkap melatih kesadaran pikiran tanpa penghakiman dalam kehidupan sehari-hari.',
                'content' => '
                    <article class="prose max-w-none text-dark">
                        <p class="text-lg font-semibold text-gray-700 leading-relaxed mb-4">
                            Mindfulness atau kesadaran penuh adalah praktik melatih pikiran untuk hadir sepenuhnya di momen saat ini. Ketika kita mengalami stres atau overthinking, pikiran kita cenderung melayang ke masa lalu yang penuh penyesalan atau masa depan yang belum tentu terjadi.
                        </p>
                        
                        <h3 class="text-xl font-bold text-dark mt-6 mb-3">Mengapa Mindfulness Sangat Penting?</h3>
                        <p class="mb-4">
                            Studi neurosains menunjukkan bahwa latihan mindfulness rutin selama 10 menit setiap hari mampu menurunkan aktivitas di amygdala (pusat respons stres otak) dan memperkuat korteks prefrontal yang bertanggung jawab atas pengisian daya emosional dan fokus.
                        </p>

                        <h3 class="text-xl font-bold text-dark mt-6 mb-3">Langkah Praktis Melakukan Mindfulness:</h3>
                        <ol class="list-decimal pl-6 space-y-3 font-medium mb-6">
                            <li><strong>Posisi Duduk Nyaman:</strong> Duduklah tegak namun santai di kursi atau lantai. Letakkan kedua tangan di atas paha.</li>
                            <li><strong>Fokus pada Pernapasan:</strong> Tutup mata Anda atau tatap satu titik secara lembut. Tarik napas perlahan melalui hidung (4 detik) dan hembuskan melalui mulut (6 detik).</li>
                            <li><strong>Amati Sensasi Tubuh:</strong> Rasakan udara dingin yang masuk melalui hidung dan pergerakan naik turun dada serta perut Anda.</li>
                            <li><strong>Sambut Pikiran Tanpa Menilai:</strong> Saat pikiran melayang (hal ini sangat wajar), cukup sadari tanpa menyalahkan diri sendiri, lalu secara perlahan arahkan kembali fokus Anda ke pernapasan.</li>
                        </ol>

                        <blockquote class="p-4 bg-primary/20 border-l-4 border-primary rounded-r font-bold text-dark italic my-6">
                            "Menjadi mindful bukan berarti mengosongkan pikiran, melainkan belajar menjadi pengamat yang tenang terhadap apa pun yang muncul."
                        </blockquote>

                        <h3 class="text-xl font-bold text-dark mt-6 mb-3">Ringkasan Sesi Hari Ini</h3>
                        <p class="mb-4">
                            Coba luangkan waktu 5-10 menit sebelum memulai aktivitas Anda atau sebelum tidur. Konsistensi kecil setiap hari jauh lebih berdampak daripada latihan lama yang jarang dilakukan.
                        </p>
                    </article>
                ',
                'video_url' => null,
                'media_path' => null,
                'author_name' => 'Tim Psikologi Sejenak',
                'duration_minutes' => 6,
            ],
            [
                'title' => 'Teknik Relaksasi Otot Progresif (PMR) Melepas Ketegangan Otot',
                'type' => 'relaxation',
                'content_type' => 'text',
                'description' => 'Panduan latihan fisik ringan untuk menegangkan dan merelaksasikan kelompok otot tubuh secara bertahap.',
                'content' => '
                    <article class="prose max-w-none text-dark">
                        <p class="text-lg font-semibold text-gray-700 leading-relaxed mb-4">
                            Progressive Muscle Relaxation (PMR) adalah metode relaksasi fisik yang dikembangkan untuk mengurangi kecemasan dengan cara menegangkan dan mengendurkan kelompok otot tubuh secara berurutan.
                        </p>

                        <h3 class="text-xl font-bold text-dark mt-6 mb-3">Urutan Gerakan Latihan Otot:</h3>
                        <ul class="list-disc pl-6 space-y-3 font-medium mb-6">
                            <li><strong>Bahu dan Leher:</strong> Tarik bahu Anda ke atas menuju telinga, tahan ketegangan selama 5 detik, lalu lemaskan seketika. Rasakan sensasi hangat dan lemas yang mengalir.</li>
                            <li><strong>Tangan dan Lengan:</strong> Kepalkan kedua tangan sekuat tenaga selama 5 detik, kemudian buka kepalan tangan dan lepaskan seluruh ketegangan.</li>
                            <li><strong>Wajah dan Rahang:</strong> Kerutkan dahi dan atur gigitan rahang secara lembut selama 5 detik, lalu lepaskan.</li>
                            <li><strong>Kaki dan Betis:</strong> Tekuk jari-jari kaki ke arah dalam selama 5 detik, lalu kendurkan sepenuhnya.</li>
                        </ul>

                        <div class="p-4 bg-secondary/30 border-2 border-dark rounded-playful-md my-6">
                            <h4 class="font-bold text-dark mb-1">💡 Tips Praktis Sebelum Tidur</h4>
                            <p class="text-sm">Lakukan PMR di atas tempat tidur dengan pencahayaan temaram untuk kualitas tidur yang lebih nyenyak dan menyegarkan.</p>
                        </div>
                    </article>
                ',
                'video_url' => null,
                'media_path' => null,
                'author_name' => 'Konselor Dimas, M.Psi',
                'duration_minutes' => 8,
            ],
            [
                'title' => 'Latihan Menulis Ekspresif (Expressive Writing) untuk Merilis Emosi',
                'type' => 'mindfulness',
                'content_type' => 'text',
                'description' => 'Metode merilis emosi terpendam dengan menuliskan beban pikiran secara jujur tanpa rasa takut dinilai.',
                'content' => '
                    <article class="prose max-w-none text-dark">
                        <p class="text-lg font-semibold text-gray-700 leading-relaxed mb-4">
                            Expressive Writing adalah teknik terapi yang terbukti secara klinis dapat mengurangi stres emosional dan memproses trauma ringan dengan menuangkan perasaan ke dalam bentuk tulisan.
                        </p>

                        <h3 class="text-xl font-bold text-dark mt-6 mb-3">Aturan Emas Expressive Writing:</h3>
                        <ol class="list-decimal pl-6 space-y-3 font-medium mb-6">
                            <li>Tuliskan apa pun yang terasa memberatkan dada Anda tanpa memedulikan tata bahasa atau ejaan.</li>
                            <li>Fokus pada perasaan mendalam dan pikiran yang biasanya enggan Anda ceritakan pada orang lain.</li>
                            <li>Lakukan selama 10-15 menit tanpa berhenti.</li>
                        </ol>

                        <p class="mb-4">
                            Setelah selesai menulis, Anda bisa menyimpan atau menghapus catatan ini di fitur Jurnal Sejenak yang dienkripsi aman secara pribadi.
                        </p>
                    </article>
                ',
                'video_url' => null,
                'media_path' => null,
                'author_name' => 'Siti Rahma, S.Psi',
                'duration_minutes' => 10,
            ]
        ];

        foreach ($exercises as $ex) {
            Exercise::updateOrCreate(['title' => $ex['title']], $ex);
        }
    }
}
