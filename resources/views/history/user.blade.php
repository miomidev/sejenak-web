@extends('layouts.app')

@section('title', 'Riwayat & Rekap Aktivitas')

@section('style')
<style>
    .calendar-cell {
        @apply min-h-[52px] p-1.5 border-2 border-dark bg-white rounded-playful-sm flex flex-col justify-between items-center transition-all cursor-pointer hover:bg-secondary/30 hover:border-black shadow-[2px_2px_0_#080330];
    }
    .calendar-cell.today {
        @apply bg-primary/30 border-black font-extrabold shadow-none translate-x-0.5 translate-y-0.5;
    }
    .activity-badge {
        @apply w-2 h-2 rounded-full border border-black inline-block;
    }
</style>
@endsection

@section('content')
<div class="w-full h-full flex flex-col gap-6 bg-background p-4 md:p-8 font-main max-w-7xl mx-auto overflow-y-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 border-2 border-dark rounded-playful-lg shadow-border-offset">
        <div>
            <span class="px-3 py-1 rounded-full bg-primary text-black font-extrabold text-xs uppercase border-2 border-dark shadow-[2px_2px_0_#080330]">
                🚀 REKAP SELF-CARE
            </span>
            <h1 class="text-2xl md:text-4xl font-extrabold text-dark mt-2">Riwayat & Rekap Aktivitas</h1>
            <p class="text-sm md:text-base text-gray-600 font-semibold mt-1">Pantau jejak jurnal, postingan komunitas, grafik suasana hati (mood), dan konsistensi harianmu.</p>
        </div>
        <div class="flex items-center gap-3 bg-secondary/30 p-3 border-2 border-dark rounded-playful-md whitespace-nowrap shadow-[2px_2px_0_#080330]">
            <span class="text-3xl">🔥</span>
            <div>
                <p class="text-xs font-bold text-gray-600">Streak Berturut-turut</p>
                <p class="text-lg font-extrabold text-dark">{{ $streakCount }} Hari Aktif</p>
            </div>
        </div>
    </div>

    <!-- Stat Cards Top Row -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 w-full">
        <div class="p-5 bg-white border-2 border-dark rounded-playful-lg text-center shadow-border-offset hover:-translate-y-1 transition-all">
            <span class="text-3xl mb-1 block">📝</span>
            <p class="text-3xl md:text-4xl font-black text-primary">{{ $journalCount }}</p>
            <p class="text-sm font-extrabold text-dark mt-1">Jurnal Ditulis</p>
        </div>
        <div class="p-5 bg-white border-2 border-dark rounded-playful-lg text-center shadow-border-offset hover:-translate-y-1 transition-all">
            <span class="text-3xl mb-1 block">💬</span>
            <p class="text-3xl md:text-4xl font-black text-secondary">{{ $postCount }}</p>
            <p class="text-sm font-extrabold text-dark mt-1">Post Komunitas</p>
        </div>
        <div class="p-5 bg-white border-2 border-dark rounded-playful-lg text-center shadow-border-offset hover:-translate-y-1 transition-all">
            <span class="text-3xl mb-1 block">⚡</span>
            <p class="text-3xl md:text-4xl font-black text-dark">{{ $streakCount }}</p>
            <p class="text-sm font-extrabold text-dark mt-1">Hari Berturut-turut</p>
        </div>
    </div>

    <!-- Main Content Grid: Kalender & Grafik Mood -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 w-full items-start">
        
        <!-- Kalender Aktivitas Bulanan (Left 7 Cols) -->
        <div class="lg:col-span-7 bg-white border-2 border-dark rounded-playful-lg p-6 shadow-border-offset flex flex-col justify-between">
            <div class="flex justify-between items-center mb-4 pb-3 border-b-2 border-dark">
                <a href="{{ route('user.history') }}?month={{ $month == 1 ? 12 : $month - 1 }}&year={{ $month == 1 ? $year - 1 : $year }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-secondary hover:bg-secondary/80 border-2 border-dark font-extrabold text-dark shadow-[2px_2px_0_#080330] transition-all" title="Bulan Sebelumnya">
                    &larr;
                </a>
                <h3 class="text-xl font-extrabold text-dark">
                    {{ \Carbon\Carbon::create($year, $month, 1)->translatedFormat('F Y') }}
                </h3>
                <a href="{{ route('user.history') }}?month={{ $month == 12 ? 1 : $month + 1 }}&year={{ $month == 12 ? $year + 1 : $year }}" class="w-9 h-9 flex items-center justify-center rounded-full bg-secondary hover:bg-secondary/80 border-2 border-dark font-extrabold text-dark shadow-[2px_2px_0_#080330] transition-all" title="Bulan Berikutnya">
                    &rarr;
                </a>
            </div>

            <!-- Nama Hari -->
            <div class="grid grid-cols-7 gap-1.5 text-center font-extrabold text-xs text-dark/70 uppercase mb-2">
                <span>Min</span><span>Sen</span><span>Sel</span><span>Rab</span><span>Kam</span><span>Jum</span><span>Sab</span>
            </div>

            <!-- Grid Tanggal -->
            <div id="calendar-grid" class="grid grid-cols-7 gap-1.5">
                @php
                    $firstDayOfMonth = \Carbon\Carbon::create($year, $month, 1)->dayOfWeek;
                    $daysInMonth = \Carbon\Carbon::create($year, $month, 1)->daysInMonth;
                    $today = \Carbon\Carbon::today();

                    $postDays = $calendarData['postDays'] ?? [];
                    $journalDays = $calendarData['journalDays'] ?? [];
                    $exerciseDays = $calendarData['exerciseDays'] ?? [];
                    $moodDays = $calendarData['moodDays'] ?? [];
                @endphp

                <!-- Cell kosong sebelum tanggal 1 -->
                @for ($i = 0; $i < $firstDayOfMonth; $i++)
                    <div class="min-h-[52px]"></div>
                @endfor

                <!-- Render Setiap Tanggal -->
                @for ($day = 1; $day <= $daysInMonth; $day++)
                    @php
                        $isToday = ($today->day == $day && $today->month == $month && $today->year == $year);
                        $hasPost = in_array($day, $postDays);
                        $hasJournal = in_array($day, $journalDays);
                        $hasExercise = in_array($day, $exerciseDays);
                        $dayMood = $moodDays[$day] ?? null;

                        $moodEmojis = [
                            'happy' => '😊', 'relaxed' => '😌', 'calm' => '😐', 
                            'sad' => '😢', 'angry' => '😡', 'energetic' => '💪',
                            'anxious' => '😰', 'stressed' => '😣', 'tired' => '😴'
                        ];
                    @endphp

                    <div class="calendar-cell {{ $isToday ? 'today' : '' }}" onclick="showDayDetails({{ $day }}, '{{ $dayMood }}', {{ $hasJournal ? 'true' : 'false' }}, {{ $hasPost ? 'true' : 'false' }}, {{ $hasExercise ? 'true' : 'false' }})">
                        <span class="text-xs font-extrabold text-dark">{{ $day }}</span>
                        
                        <!-- Emoji Mood atau Indikator Dot -->
                        <div class="flex items-center gap-1 my-0.5">
                            @if($dayMood && isset($moodEmojis[$dayMood]))
                                <span class="text-sm">{{ $moodEmojis[$dayMood] }}</span>
                            @endif
                        </div>

                        <!-- Dots Aktivitas -->
                        <div class="flex gap-1 items-center">
                            @if($hasJournal) <span class="activity-badge bg-primary" title="Jurnal"></span> @endif
                            @if($hasPost) <span class="activity-badge bg-secondary" title="Post"></span> @endif
                            @if($hasExercise) <span class="activity-badge bg-purple-400" title="Exercise"></span> @endif
                        </div>
                    </div>
                @endfor
            </div>

            <!-- Legend Indikator -->
            <div class="flex flex-wrap items-center justify-around gap-3 mt-5 pt-3 border-t-2 border-dark/10 text-xs font-extrabold text-dark/80">
                <div class="flex items-center gap-1.5"><span class="activity-badge bg-primary"></span> Jurnal</div>
                <div class="flex items-center gap-1.5"><span class="activity-badge bg-secondary"></span> Post Komunitas</div>
                <div class="flex items-center gap-1.5"><span class="activity-badge bg-purple-400"></span> Exercise</div>
                <div class="flex items-center gap-1.5"><span>😊</span> Record Mood</div>
            </div>
        </div>

        <!-- Trafik Mood 7 Hari Terakhir & Summary (Right 5 Cols) -->
        <div class="lg:col-span-5 flex flex-col gap-6 w-full">
            <!-- Mood Chart Box -->
            <div class="bg-white border-2 border-dark rounded-playful-lg p-6 shadow-border-offset">
                <div class="flex justify-between items-center mb-4 pb-3 border-b-2 border-dark">
                    <h3 class="text-lg font-extrabold text-dark flex items-center gap-2">
                        <span>🌈</span> Trafik Mood 7 Hari
                    </h3>
                    <span class="text-xs font-extrabold bg-secondary border border-dark px-2.5 py-1 rounded-playful-sm">Mingguan</span>
                </div>

                <div class="h-52 w-full">
                    <canvas id="moodChart"></canvas>
                </div>
            </div>

            <!-- Mood Summary Counts Badges -->
            <div class="bg-white border-2 border-dark rounded-playful-lg p-5 shadow-border-offset">
                <h4 class="text-sm font-extrabold text-dark mb-3 uppercase tracking-wider">Ringkasan Suasana Hati:</h4>
                <div class="grid grid-cols-3 gap-2 text-center">
                    @php
                        $counts = $moodData['moodCounts'] ?? [];
                    @endphp
                    <div class="p-2 bg-yellow-100 border border-dark rounded-playful-sm">
                        <span class="text-xl">😊</span>
                        <p class="text-xs font-extrabold text-dark mt-0.5">Bahagia: {{ $counts['Bahagia'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-blue-100 border border-dark rounded-playful-sm">
                        <span class="text-xl">😌</span>
                        <p class="text-xs font-extrabold text-dark mt-0.5">Tenang: {{ $counts['Tenang'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-gray-100 border border-dark rounded-playful-sm">
                        <span class="text-xl">😐</span>
                        <p class="text-xs font-extrabold text-dark mt-0.5">Biasa: {{ $counts['Biasa'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-purple-100 border border-dark rounded-playful-sm">
                        <span class="text-xl">😢</span>
                        <p class="text-xs font-extrabold text-dark mt-0.5">Sedih: {{ $counts['Sedih'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-red-100 border border-dark rounded-playful-sm">
                        <span class="text-xl">😡</span>
                        <p class="text-xs font-extrabold text-dark mt-0.5">Marah: {{ $counts['Marah'] ?? 0 }}</p>
                    </div>
                    <div class="p-2 bg-green-100 border border-dark rounded-playful-sm">
                        <span class="text-xl">💪</span>
                        <p class="text-xs font-extrabold text-dark mt-0.5">Semangat: {{ $counts['Semangat'] ?? 0 }}</p>
                    </div>
                </div>
            </div>

            <!-- Target Streak Card -->
            <div class="bg-primary/20 border-2 border-dark rounded-playful-lg p-5 shadow-border-offset">
                <div class="flex items-center justify-between mb-2">
                    <h4 class="font-extrabold text-dark text-sm">🎯 Target 7 Hari Konsistensi</h4>
                    <span class="text-xs font-extrabold text-dark">{{ min($streakCount, 7) }}/7 Hari</span>
                </div>
                <div class="w-full bg-white border-2 border-dark rounded-full h-4 p-0.5 overflow-hidden">
                    <div class="bg-primary h-full rounded-full transition-all duration-500" style="width: {{ min(($streakCount / 7) * 100, 100) }}%;"></div>
                </div>
                <p class="text-xs font-bold text-dark/70 mt-2">Tetap jaga kebiasaan baikmu untuk menjaga kesejahteraan emosional.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Data mood dari controller
        const moodData = @json($moodData);
        const moodHistory = moodData && moodData.moodHistory ? moodData.moodHistory : [];

        const chartCanvas = document.getElementById('moodChart');
        if (chartCanvas && moodHistory.length) {
            const ctx = chartCanvas.getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: moodHistory.map(d => d.day),
                    datasets: [{
                        label: 'Tingkat Mood',
                        data: moodHistory.map(d => d.value),
                        backgroundColor: moodHistory.map(d => {
                            switch(d.mood) {
                                case 'Bahagia': return 'rgba(245, 158, 11, 0.8)';
                                case 'Tenang': return 'rgba(59, 130, 246, 0.8)';
                                case 'Biasa': return 'rgba(156, 163, 175, 0.8)';
                                case 'Sedih': return 'rgba(139, 92, 246, 0.8)';
                                case 'Marah': return 'rgba(239, 68, 68, 0.8)';
                                case 'Semangat': return 'rgba(34, 197, 94, 0.8)';
                                default: return 'rgba(156, 163, 175, 0.8)';
                            }
                        }),
                        borderColor: '#080330',
                        borderWidth: 2,
                        borderRadius: 8,
                        borderSkipped: false
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(ctx) {
                                    const index = ctx.dataIndex;
                                    const item = moodHistory[index];
                                    return `Mood: ${item ? item.mood : 'Biasa'}`;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            min: 0,
                            max: 100,
                            ticks: { display: false },
                            grid: { color: 'rgba(0, 0, 0, 0.05)' }
                        },
                        x: {
                            ticks: {
                                font: { family: 'Lexend', weight: 'bold' },
                                color: '#080330'
                            },
                            grid: { display: false }
                        }
                    }
                }
            });
        }

        window.showDayDetails = function(day, mood, hasJournal, hasPost, hasExercise) {
            let details = `📅 Detail Aktivitas Tanggal ${day}:\n`;
            details += mood ? `• Mood: ${mood.toUpperCase()}\n` : `• Mood: Belum dicatat\n`;
            details += hasJournal ? `• Jurnal: Ditulis ✅\n` : `• Jurnal: Tidak ada\n`;
            details += hasPost ? `• Post Komunitas: Ada ✅\n` : `• Post Komunitas: Tidak ada\n`;
            details += hasExercise ? `• Exercise: Selesai ✅` : `• Exercise: Tidak ada`;
            alert(details);
        };
    });
</script>
@endsection
