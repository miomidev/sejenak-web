@extends('layouts.app')

@section('title', 'Meditasi & Panduan Exercise')

@section('style')
<style>
    .timer-btn {
        @apply px-4 py-2 rounded-playful-md border-2 border-dark font-extrabold text-sm transition-all cursor-pointer bg-white text-dark shadow-[2px_2px_0_#080330] hover:bg-secondary/40;
    }
    .timer-btn.active {
        @apply bg-primary text-black border-dark shadow-none translate-x-0.5 translate-y-0.5;
    }
    .ambient-card {
        @apply p-3 rounded-playful-md border-2 border-dark cursor-pointer transition-all flex items-center gap-3 bg-white hover:bg-secondary/30 shadow-[2px_2px_0_#080330];
    }
    .ambient-card.active {
        @apply bg-primary border-dark text-black font-bold shadow-none translate-x-0.5 translate-y-0.5;
    }
    .exercise-card {
        @apply bg-white border-2 border-dark rounded-playful-lg p-5 shadow-border-offset hover:-translate-y-1 hover:shadow-border-offset-lg transition-all duration-200 cursor-pointer flex flex-col justify-between h-full;
    }
</style>
@endsection

@section('content')
<div id="main-meditation-page" class="w-full h-full overflow-y-auto flex flex-col gap-8 bg-background p-4 md:p-8 font-main max-w-7xl mx-auto">
    <!-- Header Page -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 border-2 border-dark rounded-playful-lg shadow-border-offset">
        <div>
            <span class="px-3 py-1 rounded-full bg-primary text-black font-extrabold text-xs uppercase border-2 border-dark shadow-[2px_2px_0_#080330]">
                🧘 SEJENAK MINDFULNESS
            </span>
            <h1 class="text-2xl md:text-4xl font-extrabold text-dark mt-2">Ruang Meditasi & Exercise</h1>
            <p class="text-sm md:text-base text-gray-600 font-semibold mt-1">Tenangkan pikiran dengan audio meditasi harian, timer tanpa panduan, serta panduan exercise video & artikel dari konselor.</p>
        </div>
        <div class="flex items-center gap-3 bg-secondary/30 p-3 border-2 border-dark rounded-playful-md whitespace-nowrap shadow-[2px_2px_0_#080330]">
            <span class="text-2xl">⚡</span>
            <div>
                <p class="text-xs font-bold text-gray-600">Streak Meditasi</p>
                <p class="text-base font-extrabold text-dark">7 Hari Berturut-turut</p>
            </div>
        </div>
    </div>

    <!-- Section 1 & 2: Top Grid (Audio Player + Timer) -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 w-full">
        
        <!-- PLAYER AUDIO MEDITASI HARIAN -->
        <div class="bg-white border-2 border-dark rounded-playful-lg p-6 shadow-border-offset flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-4 pb-3 border-b-2 border-dark">
                    <h3 class="text-lg md:text-xl font-extrabold text-dark flex items-center gap-2">
                        <span>🎵</span> Audio Meditasi Harian
                    </h3>
                    <span id="player-category-tag" class="px-3 py-1 rounded-full bg-secondary border-2 border-dark text-xs font-extrabold text-dark shadow-[2px_2px_0_#080330]">
                        {{ $dailySong ? ucfirst($dailySong->category) : 'Panduan' }}
                    </span>
                </div>

                <!-- Playlist Selector -->
                <div class="mb-4">
                    <label for="track-select" class="block text-xs font-extrabold text-dark/70 uppercase tracking-wider mb-1.5">Pilih Lagu / Track Meditasi:</label>
                    <select id="track-select" class="w-full p-2.5 rounded-playful-md border-2 border-dark bg-gray-50 text-dark font-extrabold text-sm focus:outline-none focus:bg-white shadow-[2px_2px_0_#080330]">
                        @forelse($audios as $audio)
                            <option value="{{ asset('storage/' . $audio->file_path) }}" data-title="{{ $audio->title }}" data-category="{{ $audio->category }}">
                                🎧 {{ $audio->title }} ({{ ucfirst($audio->category) }})
                            </option>
                        @empty
                            <option value="https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=meditation-piano-112191.mp3" data-title="Ketenangan Hati & Pikiran" data-category="Mindfulness">
                                🎧 Ketenangan Hati & Pikiran (Default)
                            </option>
                        @endforelse
                    </select>
                </div>

                <!-- Active Track Card -->
                <div class="flex items-center gap-4 bg-primary/20 p-4 border-2 border-dark rounded-playful-md mb-4 shadow-[2px_2px_0_#080330]">
                    <button id="play-pause-btn" class="w-14 h-14 rounded-full bg-primary hover:bg-primary/90 text-dark flex items-center justify-center border-2 border-dark shadow-[3px_3px_0_#080330] hover:translate-x-0.5 hover:translate-y-0.5 transition-all flex-shrink-0">
                        <i id="play-pause-icon" class="fas fa-play text-2xl ml-1"></i>
                    </button>
                    <div class="flex-1 overflow-hidden">
                        <p id="player-track-title" class="font-extrabold text-dark text-base md:text-lg truncate">
                            {{ $dailySong ? $dailySong->title : 'Ketenangan Hati & Pikiran' }}
                        </p>
                        <p id="player-track-sub" class="text-xs font-bold text-gray-600 mt-0.5">
                            Dipandu oleh Tim Konselor Sejenak
                        </p>
                    </div>
                </div>

                <!-- Progress Bar & Volume -->
                <div class="space-y-2">
                    <div class="flex justify-between text-xs font-extrabold text-dark">
                        <span id="current-time">0:00</span>
                        <span id="duration-time">0:00</span>
                    </div>
                    <input type="range" id="meditation-progress" value="0" max="100" class="w-full h-3 rounded-full accent-primary appearance-none bg-gray-200 border-2 border-dark cursor-pointer">
                    
                    <div class="flex items-center justify-between pt-2">
                        <div class="flex items-center gap-2">
                            <i class="fas fa-volume-up text-dark text-sm"></i>
                            <input type="range" id="volume-slider" min="0" max="1" step="0.05" value="0.8" class="w-24 h-2 accent-dark bg-gray-200 rounded-lg cursor-pointer">
                        </div>
                        <button id="repeat-btn" class="text-xs font-extrabold text-dark/70 hover:text-dark flex items-center gap-1">
                            <i class="fas fa-redo"></i> Ulangi
                        </button>
                    </div>
                </div>

                <audio id="meditation-audio" preload="metadata">
                    <source id="audio-source" src="{{ $dailySong ? asset('storage/' . $dailySong->file_path) : 'https://cdn.pixabay.com/download/audio/2022/05/27/audio_1808fbf07a.mp3?filename=meditation-piano-112191.mp3' }}" type="audio/mpeg">
                </audio>
            </div>
        </div>

        <!-- MEDITASI TANPA PANDUAN (TIMER & WHITE NOISE) -->
        <div class="bg-white border-2 border-dark rounded-playful-lg p-6 shadow-border-offset flex flex-col justify-between">
            <div>
                <div class="flex justify-between items-center mb-4 pb-3 border-b-2 border-dark">
                    <h3 class="text-lg md:text-xl font-extrabold text-dark flex items-center gap-2">
                        <span>⏱️</span> Meditasi Mandiri (Timer & Sound)
                    </h3>
                    <span class="px-3 py-1 rounded-full bg-primary border-2 border-dark text-xs font-extrabold text-dark shadow-[2px_2px_0_#080330]">
                        Mandiri
                    </span>
                </div>

                <!-- Durasi Timer Selector -->
                <div class="mb-4">
                    <label class="block text-xs font-extrabold text-dark/70 uppercase tracking-wider mb-2">Pilih Durasi Meditasi:</label>
                    <div class="flex flex-wrap gap-2">
                        <button class="timer-btn" data-minutes="3">3 Menit</button>
                        <button class="timer-btn active" data-minutes="5">5 Menit</button>
                        <button class="timer-btn" data-minutes="10">10 Menit</button>
                        <button class="timer-btn" data-minutes="15">15 Menit</button>
                        <button class="timer-btn" data-minutes="30">30 Menit</button>
                    </div>
                </div>

                <!-- Ambient Sound Selector -->
                <div class="mb-5">
                    <label class="block text-xs font-extrabold text-dark/70 uppercase tracking-wider mb-2">Suara Latar (Ambient Sound):</label>
                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-2">
                        <div class="ambient-card active" data-sound="rain">
                            <span>🌧️</span> <span class="text-xs font-extrabold">Hujan</span>
                        </div>
                        <div class="ambient-card" data-sound="waves">
                            <span>🌊</span> <span class="text-xs font-extrabold">Ombak</span>
                        </div>
                        <div class="ambient-card" data-sound="forest">
                            <span>🌲</span> <span class="text-xs font-extrabold">Hutan</span>
                        </div>
                        <div class="ambient-card" data-sound="chimes">
                            <span>🔔</span> <span class="text-xs font-extrabold">Lonceng</span>
                        </div>
                        <div class="ambient-card" data-sound="silent">
                            <span>🤫</span> <span class="text-xs font-extrabold">Hening</span>
                        </div>
                    </div>
                </div>

                <!-- Countdown Display & Control Buttons -->
                <div class="bg-secondary/20 p-5 border-2 border-dark rounded-playful-md text-center shadow-[2px_2px_0_#080330]">
                    <div id="timer-display" class="text-4xl md:text-5xl font-black text-dark tracking-wider mb-4">
                        05:00
                    </div>
                    <div class="flex justify-center items-center gap-3">
                        <button id="start-timer-btn" class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-dark font-extrabold text-sm rounded-playful-md border-2 border-dark shadow-[3px_3px_0_#080330] hover:translate-x-0.5 hover:translate-y-0.5 transition-all flex items-center gap-2">
                            <i class="fas fa-play"></i> Mulai Meditasi
                        </button>
                        <button id="reset-timer-btn" class="px-4 py-2.5 bg-gray-100 hover:bg-gray-200 text-dark font-extrabold text-sm rounded-playful-md border-2 border-dark shadow-[2px_2px_0_#080330] transition-all">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Audio Loop for White Noise Ambient -->
            <audio id="ambient-audio" loop prefetch="auto">
                <source id="ambient-source" src="https://cdn.pixabay.com/download/audio/2021/09/06/audio_8b211f4228.mp3?filename=rain-and-thunder-nature-sounds-7803.mp3" type="audio/mpeg">
            </audio>
            <!-- Bell Gong Sound on Complete -->
            <audio id="gong-audio" prefetch="auto">
                <source src="https://cdn.pixabay.com/download/audio/2022/03/15/audio_c8c8868c22.mp3?filename=singing-bowl-gong-sound-84724.mp3" type="audio/mpeg">
            </audio>
        </div>
    </div>

    <!-- Section 3: Modul Exercise / Panduan Video & Blog (Diupload Admin / Konselor) -->
    <div class="bg-white border-2 border-dark rounded-playful-lg p-6 shadow-border-offset w-full">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pb-4 border-b-2 border-dark">
            <div>
                <span class="px-3 py-1 rounded-full bg-secondary text-dark font-extrabold text-xs uppercase border-2 border-dark shadow-[2px_2px_0_#080330]">
                    📚 MATERI EXERCISE KONSELOR
                </span>
                <h3 class="text-xl md:text-2xl font-extrabold text-dark mt-2">Exercise Video & Panduan Teks (Blog)</h3>
                <p class="text-sm text-gray-600 font-semibold mt-0.5">Dibuat khusus oleh Tim Konselor Sejenak untuk memandu latihan relaksasi Anda.</p>
            </div>

            <!-- Category Filter Tabs -->
            <div class="flex flex-wrap gap-2">
                <button class="filter-tab-btn px-3 py-1.5 rounded-playful-md border-2 border-dark text-xs font-extrabold bg-primary text-black shadow-[2px_2px_0_#080330]" data-filter="all">Semua</button>
                <button class="filter-tab-btn px-3 py-1.5 rounded-playful-md border-2 border-dark text-xs font-extrabold bg-white hover:bg-secondary/40 text-dark shadow-[2px_2px_0_#080330]" data-filter="video">📹 Video</button>
                <button class="filter-tab-btn px-3 py-1.5 rounded-playful-md border-2 border-dark text-xs font-extrabold bg-white hover:bg-secondary/40 text-dark shadow-[2px_2px_0_#080330]" data-filter="text">📖 Artikel Blog</button>
            </div>
        </div>

        <!-- Exercise Card Grid -->
        <div id="exercise-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($exercises as $ex)
                <div class="exercise-card item-filter" data-content-type="{{ $ex->content_type }}" data-type="{{ $ex->type }}" onclick="openExerciseModal({{ $ex->id }})">
                    <div>
                        <div class="flex justify-between items-start mb-3">
                            <span class="px-3 py-1 rounded-full border-2 border-dark text-xs font-extrabold {{ $ex->content_type === 'video' ? 'bg-purple-200 text-purple-900' : 'bg-green-200 text-green-900' }} shadow-[2px_2px_0_#080330] uppercase">
                                {{ $ex->content_type === 'video' ? '📹 Video Exercise' : '📖 Artikel Blog' }}
                            </span>
                            <span class="text-xs font-extrabold text-gray-500 bg-gray-100 px-2.5 py-1 rounded-playful-sm border border-dark">
                                ⏱️ {{ $ex->duration_minutes }} Menit
                            </span>
                        </div>

                        <h4 class="text-lg font-extrabold text-dark mb-2 leading-snug hover:text-primary transition-colors">
                            {{ $ex->title }}
                        </h4>
                        <p class="text-xs font-extrabold text-gray-500 mb-3">
                            ✍️ {{ $ex->author_name }}
                        </p>
                        <p class="text-sm text-gray-600 line-clamp-3 leading-relaxed mb-4">
                            {{ $ex->description }}
                        </p>
                    </div>

                    <div class="pt-3 border-t-2 border-dark/10 flex justify-between items-center">
                        <span class="text-xs font-extrabold text-dark uppercase tracking-wider">
                            Kategori: {{ ucfirst($ex->type) }}
                        </span>
                        <button class="px-4 py-2 bg-secondary hover:bg-secondary/80 border-2 border-dark rounded-playful-md text-xs font-extrabold text-dark shadow-[2px_2px_0_#080330] transition-all">
                            {{ $ex->content_type === 'video' ? 'Tonton Video ▶' : 'Baca Artikel 📖' }}
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12 text-gray-500 font-semibold">
                    Belum ada exercise yang diunggah oleh konselor.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- MODAL DETAIL EXERCISE (VIDEO & BLOG TEXT READER) -->
<div id="exercise-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
    <div class="bg-white border-3 border-dark rounded-playful-lg shadow-[8px_8px_0_#080330] w-full max-w-3xl max-h-[90vh] flex flex-col overflow-hidden relative">
        <!-- Modal Header -->
        <div class="flex justify-between items-center p-5 bg-primary border-b-3 border-dark">
            <div class="flex items-center gap-3">
                <span id="modal-badge-type" class="px-3 py-1 rounded-full bg-white border-2 border-dark text-xs font-extrabold text-dark shadow-[2px_2px_0_#080330] uppercase">
                    ARTIKEL BLOG
                </span>
                <h3 id="modal-title" class="text-lg md:text-xl font-extrabold text-dark truncate max-w-md">
                    Judul Exercise
                </h3>
            </div>
            <button id="close-modal-btn" class="w-9 h-9 rounded-full bg-white hover:bg-red-100 text-dark hover:text-red-600 border-2 border-dark flex items-center justify-center font-bold text-lg transition shadow-[2px_2px_0_#080330]">
                ✕
            </button>
        </div>

        <!-- Modal Body Content -->
        <div class="p-6 overflow-y-auto flex-1 space-y-4">
            <!-- Author info -->
            <div class="flex items-center justify-between pb-3 border-b-2 border-dark/10">
                <div class="flex items-center gap-2">
                    <span class="text-xl">👨‍⚕️</span>
                    <div>
                        <p id="modal-author" class="text-sm font-extrabold text-dark">Tim Konselor Sejenak</p>
                        <p id="modal-duration" class="text-xs font-bold text-gray-500">Estimasi Latihan: 5 Menit</p>
                    </div>
                </div>
            </div>

            <!-- Video Player Container (If Video) -->
            <div id="video-container" class="hidden aspect-video w-full border-2 border-dark rounded-playful-md overflow-hidden shadow-[3px_3px_0_#080330]">
                <iframe id="video-iframe" class="w-full h-full" src="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

            <!-- Description -->
            <p id="modal-description" class="text-base font-semibold text-dark/80 bg-secondary/20 p-4 border-2 border-dark rounded-playful-md italic">
                Deskripsi singkat exercise...
            </p>

            <!-- Blog Content (If Text) -->
            <div id="text-content" class="hidden text-dark leading-relaxed">
                <!-- Rich HTML Content rendered here -->
            </div>
        </div>

        <!-- Modal Footer Actions -->
        <div class="p-4 bg-gray-50 border-t-2 border-dark flex justify-between items-center">
            <span class="text-xs font-extrabold text-gray-500">Sejenak Wellness Guide</span>
            <button id="complete-exercise-btn" class="px-6 py-2.5 bg-primary hover:bg-primary/90 text-dark font-extrabold text-sm rounded-playful-md border-2 border-dark shadow-[3px_3px_0_#080330] hover:translate-x-0.5 hover:translate-y-0.5 transition-all flex items-center gap-2">
                <i class="fas fa-check-circle"></i> Tandai Selesai
            </button>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // === 1. AUDIO PLAYER HARIAN SCRIPT ===
        const audio = document.getElementById('meditation-audio');
        const audioSource = document.getElementById('audio-source');
        const trackSelect = document.getElementById('track-select');
        const playPauseBtn = document.getElementById('play-pause-btn');
        const playPauseIcon = document.getElementById('play-pause-icon');
        const progress = document.getElementById('meditation-progress');
        const currentTimeEl = document.getElementById('current-time');
        const durationTimeEl = document.getElementById('duration-time');
        const volumeSlider = document.getElementById('volume-slider');
        const repeatBtn = document.getElementById('repeat-btn');
        const playerTrackTitle = document.getElementById('player-track-title');
        const playerCategoryTag = document.getElementById('player-category-tag');

        let isRepeat = false;

        function formatTime(seconds) {
            if (isNaN(seconds)) return '0:00';
            const mins = Math.floor(seconds / 60);
            const secs = Math.floor(seconds % 60);
            return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }

        if (trackSelect) {
            trackSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                audioSource.src = this.value;
                playerTrackTitle.textContent = selectedOption.getAttribute('data-title') || 'Track Meditasi';
                playerCategoryTag.textContent = selectedOption.getAttribute('data-category') || 'Panduan';
                audio.load();
                audio.play();
                playPauseIcon.className = 'fas fa-pause text-2xl';
            });
        }

        if (playPauseBtn && audio) {
            playPauseBtn.addEventListener('click', function() {
                if (audio.paused) {
                    audio.play();
                    playPauseIcon.className = 'fas fa-pause text-2xl';
                } else {
                    audio.pause();
                    playPauseIcon.className = 'fas fa-play text-2xl ml-1';
                }
            });

            audio.addEventListener('timeupdate', function() {
                if (!isNaN(audio.duration)) {
                    progress.value = (audio.currentTime / audio.duration) * 100;
                    currentTimeEl.textContent = formatTime(audio.currentTime);
                    durationTimeEl.textContent = formatTime(audio.duration);
                }
            });

            progress.addEventListener('input', function() {
                if (!isNaN(audio.duration)) {
                    audio.currentTime = (progress.value / 100) * audio.duration;
                }
            });

            volumeSlider.addEventListener('input', function() {
                audio.volume = this.value;
            });

            repeatBtn.addEventListener('click', function() {
                isRepeat = !isRepeat;
                this.classList.toggle('text-primary', isRepeat);
            });

            audio.addEventListener('ended', function() {
                if (isRepeat) {
                    audio.currentTime = 0;
                    audio.play();
                } else {
                    playPauseIcon.className = 'fas fa-play text-2xl ml-1';
                    progress.value = 0;
                }
            });
        }

        // === 2. MEDITASI MANDIRI (TIMER & AMBIENT) SCRIPT ===
        let timerMinutes = 5;
        let timerSeconds = timerMinutes * 60;
        let timerInterval = null;
        let isTimerRunning = false;

        const timerDisplay = document.getElementById('timer-display');
        const startTimerBtn = document.getElementById('start-timer-btn');
        const resetTimerBtn = document.getElementById('reset-timer-btn');
        const ambientAudio = document.getElementById('ambient-audio');
        const ambientSource = document.getElementById('ambient-source');
        const gongAudio = document.getElementById('gong-audio');

        const ambientSounds = {
            rain: "https://cdn.pixabay.com/download/audio/2021/09/06/audio_8b211f4228.mp3?filename=rain-and-thunder-nature-sounds-7803.mp3",
            waves: "https://cdn.pixabay.com/download/audio/2022/01/18/audio_d0a13f69d2.mp3?filename=ocean-waves-ambient-10255.mp3",
            forest: "https://cdn.pixabay.com/download/audio/2022/03/10/audio_512b1897c9.mp3?filename=forest-birds-ambient-19042.mp3",
            chimes: "https://cdn.pixabay.com/download/audio/2022/05/16/audio_db633fb67b.mp3?filename=wind-chimes-ambient-110292.mp3",
            silent: ""
        };

        function updateTimerDisplay() {
            const mins = Math.floor(timerSeconds / 60);
            const secs = timerSeconds % 60;
            timerDisplay.textContent = `${mins < 10 ? '0' : ''}${mins}:${secs < 10 ? '0' : ''}${secs}`;
        }

        document.querySelectorAll('.timer-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.timer-btn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                timerMinutes = parseInt(this.getAttribute('data-minutes'));
                timerSeconds = timerMinutes * 60;
                updateTimerDisplay();
                if (isTimerRunning) stopTimer();
            });
        });

        document.querySelectorAll('.ambient-card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.ambient-card').forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                const soundKey = this.getAttribute('data-sound');
                const url = ambientSounds[soundKey];

                if (url) {
                    ambientSource.src = url;
                    ambientAudio.load();
                    if (isTimerRunning) ambientAudio.play();
                } else {
                    ambientAudio.pause();
                }
            });
        });

        function startTimer() {
            isTimerRunning = true;
            startTimerBtn.innerHTML = '<i class="fas fa-pause"></i> Jeda';
            startTimerBtn.classList.replace('bg-primary', 'bg-warning');

            const activeSoundKey = document.querySelector('.ambient-card.active')?.getAttribute('data-sound');
            if (activeSoundKey && ambientSounds[activeSoundKey]) {
                ambientAudio.play();
            }

            timerInterval = setInterval(() => {
                timerSeconds--;
                updateTimerDisplay();

                if (timerSeconds <= 0) {
                    stopTimer();
                    ambientAudio.pause();
                    gongAudio.play();
                    alert("🎉 Sesi Meditasi Anda Telah Selesai!");
                }
            }, 1000);
        }

        function stopTimer() {
            isTimerRunning = false;
            clearInterval(timerInterval);
            startTimerBtn.innerHTML = '<i class="fas fa-play"></i> Mulai Meditasi';
            startTimerBtn.classList.replace('bg-warning', 'bg-primary');
            ambientAudio.pause();
        }

        startTimerBtn.addEventListener('click', function() {
            if (isTimerRunning) {
                stopTimer();
            } else {
                startTimer();
            }
        });

        resetTimerBtn.addEventListener('click', function() {
            stopTimer();
            timerSeconds = timerMinutes * 60;
            updateTimerDisplay();
        });

        // === 3. FILTER TABS & MODAL EXERCISE SCRIPT ===
        document.querySelectorAll('.filter-tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-tab-btn').forEach(b => {
                    b.classList.remove('bg-primary', 'text-black');
                    b.classList.add('bg-white', 'text-dark');
                });
                this.classList.add('bg-primary', 'text-black');
                this.classList.remove('bg-white');

                const filter = this.getAttribute('data-filter');
                document.querySelectorAll('.item-filter').forEach(card => {
                    if (filter === 'all' || card.getAttribute('data-content-type') === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        const modal = document.getElementById('exercise-modal');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const modalBadgeType = document.getElementById('modal-badge-type');
        const modalTitle = document.getElementById('modal-title');
        const modalAuthor = document.getElementById('modal-author');
        const modalDuration = document.getElementById('modal-duration');
        const modalDescription = document.getElementById('modal-description');
        const videoContainer = document.getElementById('video-container');
        const videoIframe = document.getElementById('video-iframe');
        const textContent = document.getElementById('text-content');
        const completeBtn = document.getElementById('complete-exercise-btn');
        let currentExerciseId = null;

        window.openExerciseModal = async function(id) {
            currentExerciseId = id;
            try {
                const res = await fetch(`/exercise/json/${id}`);
                const result = await res.json();

                if (result.success && result.data) {
                    const ex = result.data;
                    modalTitle.textContent = ex.title;
                    modalAuthor.textContent = ex.author_name || 'Tim Konselor Sejenak';
                    modalDuration.textContent = `Estimasi Latihan: ${ex.duration_minutes || 5} Menit`;
                    modalDescription.textContent = ex.description || '';

                    if (ex.content_type === 'video') {
                        modalBadgeType.textContent = '📹 VIDEO EXERCISE';
                        modalBadgeType.className = 'px-3 py-1 rounded-full bg-purple-200 text-purple-900 border-2 border-dark text-xs font-extrabold shadow-[2px_2px_0_#080330]';
                        videoContainer.classList.remove('hidden');
                        textContent.classList.add('hidden');
                        videoIframe.src = ex.video_url || 'https://www.youtube.com/embed/inpok4MKVLM';
                    } else {
                        modalBadgeType.textContent = '📖 ARTIKEL BLOG';
                        modalBadgeType.className = 'px-3 py-1 rounded-full bg-green-200 text-green-900 border-2 border-dark text-xs font-extrabold shadow-[2px_2px_0_#080330]';
                        videoContainer.classList.add('hidden');
                        videoIframe.src = '';
                        textContent.classList.remove('hidden');
                        textContent.innerHTML = ex.content || '<p>Materi panduan teks sedang diproses oleh konselor.</p>';
                    }

                    modal.classList.remove('hidden');
                }
            } catch (err) {
                console.error("Gagal memuat detail exercise:", err);
            }
        };

        closeModalBtn.addEventListener('click', function() {
            modal.classList.add('hidden');
            videoIframe.src = '';
        });

        completeBtn.addEventListener('click', async function() {
            if (!currentExerciseId) return;
            try {
                const res = await fetch(`/exercise/json/${currentExerciseId}/complete`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                });
                const data = await res.json();
                if (data.success) {
                    alert('🎉 Selamat! Latihan telah berhasil diselesaikan.');
                    modal.classList.add('hidden');
                    videoIframe.src = '';
                }
            } catch (err) {
                console.error(err);
            }
        });
    });
</script>
@endsection
