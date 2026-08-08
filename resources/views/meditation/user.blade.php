@extends('layouts.app')

@section('title', 'Meditasi')

@section('content')
<div id="main-meditation-page" class="w-full h-full flex flex-col lg:flex-row bg-background p-4 my-8 md:py-0 md:px-8 lg:px-12 font-main">

    <div class="flex-1 p-0 md:p-4 flex flex-col items-center justify-center gap-6">

        <div class="h-1/4 click-1 w-full  p-6 bg-white border-2 border-dark rounded-playful-sm shadow-border-offset ">
            <h2 class="text-h6 text-dark font-bold mb-2">Terakhir Anda Bermeditasi</h2>
            <div class="flex items-center justify-between">
                <p id="last-activity-text" class="text-sm text-gray-600">Memuat data terakhir...</p>
                <i class="fas fa-history text-secondary"></i>
            </div>
        </div>

        @if($dailySong)
        <div class="h-1/4 click-1 w-full p-6 bg-white border-2 border-dark rounded-playful-sm shadow-border-offset-lg">
            <h3 class="text-h5 text-dark font-bold mb-4">Putar Meditasi Harian</h3>
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button id="play-pause-btn" class="hover-1 w-12 h-12 rounded-full bg-primary text-dark flex items-center justify-center border-2 border-dark shadow-border-offset-accent">
                        <i id="play-pause-icon" class="fas fa-play text-xl"></i>
                    </button>
                    <div>
                        <p class="font-bold text-dark">{{ $dailySong->title }}</p>
                        <p class="text-xs text-gray-500">{{ $dailySong->category }}</p>
                    </div>
                </div>
                <div class="text-sm font-semibold text-gray-600">
                    <span id="current-time">0:00</span> / <span id="duration-time">0:00</span>
                </div>
            </div>

            <input type="range" id="meditation-progress" value="0" max="100" class="w-full h-2 mt-4 rounded-full accent-primary appearance-none bg-gray-200">

            <audio id="meditation-audio">
                <source src="{{ asset('storage/' . $dailySong->file_path) }}" type="audio/mpeg">
                Browser Anda tidak mendukung elemen audio.
            </audio>
        </div>
        @else
        <div class="w-full max-w-xl p-6 bg-white border-2 border-dark rounded-playful-sm shadow-border-offset-lg">
             <h3 class="text-h5 text-dark font-bold mb-2">Putar Meditasi Harian</h3>
             <p class="text-gray-600 text-sm">Maaf, meditasi harian tidak tersedia saat ini. Silakan coba lagi nanti.</p>
        </div>
        @endif


        <div class="w-full p-0  h-2/4 grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="click-1 p-6 bg-white border-2 border-dark rounded-playful-md flex flex-col justify-between">
                <div class="container">
                <h4 class="text-h5 text-dark font-bold mb-2">Meditasi Tanpa Panduan</h4>
                <p class="text-gray-600 text-sm mb-4">Gunakan white noise untuk bermeditasi sesuai durasi yang Anda inginkan.</p>
                </div>
                <a href="{{ route('user.meditation.meditasi') }}" class="hover-1 w-full px-4 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent text-center block">
                    <i class="fas fa-stopwatch mr-2"></i> Mulai sekarang
                </a>
            </div>

            <div class="click-1 p-6 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg flex flex-col justify-between">
                <div class="container">
                <h4 class="text-h5 text-dark font-bold mb-2">Latihan Singkat</h4>
                <p class="text-gray-600 text-sm mb-4">Latihan singkat untuk menenangkan pikiran.</p>
                </div>
                <a href="{{ route('user.exercise'); }}" class="hover-1 w-full px-4 py-3 bg-white text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent text-center block">
                    <i class="fas fa-wind mr-2"></i> Latihan
                </a>
            </div>
        </div>

    </div>

    <div class="hidden  w-1/2 h-full lg:flex  flex-col p-0 items-center justify-center gap-0">

        <div class="w-full h-full p-6 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg click-1">
            <h3 class="text-h4 text-dark font-bold mb-4 text-center">Ringkasan Meditasi Anda</h3>
            <div class="flex justify-around items-center space-x-4 text-center">
                <div class="flex-1">
                    <p class="text-h3 text-primary font-extrabold mb-1">25</p>
                    <p class="text-sm text-gray-600">Sesi Selesai</p>
                </div>
                <div class="flex-1">
                    <p class="text-h3 text-secondary font-extrabold mb-1">150</p>
                    <p class="text-sm text-gray-600">Total Menit</p>
                </div>
                <div class="flex-1">
                    <p class="text-h3 text-dark font-extrabold mb-1">7</p>
                    <p class="text-sm text-gray-600">Hari Beruntun</p>
                </div>
            </div>
            <div class="mt-8">
                <canvas id="meditation-chart" width="400" height="200"></canvas>
            </div>
        </div>



    </div>
</div>
@endsection

@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function() {
    const audio = document.getElementById('meditation-audio');
    const playPauseBtn = document.getElementById('play-pause-btn');
    const playPauseIcon = document.getElementById('play-pause-icon');
    const progress = document.getElementById('meditation-progress');
    const currentTimeEl = document.getElementById('current-time');
    const durationTimeEl = document.getElementById('duration-time');

    // Cek jika elemen audio player ada
    if(audio && playPauseBtn) {
        // Format detik ke menit:detik
        const formatTime = (time) => {
            if (isNaN(time)) return '0:00';
            const minutes = Math.floor(time / 60);
            const seconds = Math.floor(time % 60);
            return `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;
        };

        // Play / Pause toggle
        playPauseBtn.addEventListener('click', () => {
            if (audio.paused) {
                audio.play();
                playPauseIcon.classList.replace('fa-play', 'fa-pause');
            } else {
                audio.pause();
                playPauseIcon.classList.replace('fa-pause', 'fa-play');
            }
        });

        // Update progress + waktu berjalan
        audio.addEventListener('timeupdate', () => {
            progress.value = audio.currentTime;
            currentTimeEl.textContent = formatTime(audio.currentTime);
        });

        // Seek audio
        progress.addEventListener('input', () => {
            audio.currentTime = progress.value;
        });

        // Set durasi saat metadata loaded
        audio.addEventListener('loadedmetadata', () => {
            progress.max = Math.floor(audio.duration);
            durationTimeEl.textContent = formatTime(audio.duration);
        });

        // Reset ketika selesai
        audio.addEventListener('ended', () => {
            playPauseIcon.classList.replace('fa-pause', 'fa-play');
            progress.value = 0;
            currentTimeEl.textContent = '0:00';
        });
    }

    // ====== Bagian Tambahan ======
    // Placeholder last activity
    const lastActivityText = document.getElementById("last-activity-text");
    if (lastActivityText) {
        const lastActivityData = {
            type: 'Meditasi Berpanduan',
            detail: 'Ketenangan Pagi, 10 menit yang lalu'
        };
        lastActivityText.innerText = `Terakhir ${lastActivityData.type}: ${lastActivityData.detail}`;
    }

    // Chart.js for Meditation Summary
    const ctx = document.getElementById('meditation-chart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Sesi Meditasi Mingguan',
                    data: [5, 4, 6, 7, 5, 8, 9],
                    backgroundColor: '#8FD14F',
                    borderColor: '#080330',
                    borderWidth: 2,
                    borderRadius: 5,
                    barPercentage: 0.6,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { color: '#e5e7eb' },
                        ticks: { color: '#4b5563' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#4b5563' }
                    }
                },
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: 'rgba(255, 255, 255, 0.9)',
                        titleColor: '#080330',
                        bodyColor: '#4b5563',
                        borderColor: '#080330',
                        borderWidth: 1
                    }
                }
            }
        });
    }
});


</script>
@endsection
