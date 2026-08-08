@extends('layouts.app')

@section('title', 'Meditasi White Noise')

@section('content')
<div id="meditationPage" class="w-full  bg-background font-main p-4 md:p-8">


    <div class="flex flex-col lg:flex-row gap-6 h-full">
        <!-- Panel Kiri: Daftar Audio -->
        <aside class="lg:w-1/4 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg p-4 overflow-y-auto">
            <h2 class="text-h4 text-dark font-bold mb-4">Daftar Audio</h2>
            <div class="space-y-3" id="audio-list">
                <!-- Item audio akan diisi melalui JavaScript -->
            </div>
        </aside>

        <!-- Panel Tengah: Kontrol Utama -->
        <main class="lg:w-2/4 flex flex-col gap-6">
            <!-- Player Kontrol -->
            <div class="bg-white border-2 border-dark rounded-playful-lg shadow-border-offset-lg p-6 flex-1">

    <div class="flex flex-col items-center justify-center h-72 space-y-6">
        
        <!-- Info Lagu -->
        <div class="text-center">
            <h3 id="current-audio-title" class="text-xl font-bold text-dark mb-1">Pilih Audio</h3>
            <p id="current-audio-desc" class="text-sm text-gray-500">Belum ada audio yang diputar</p>
        </div>
        
        <!-- Progress & Durasi -->
        <div class="w-full max-w-md">
            <div class="flex items-center justify-between text-xs text-gray-600 mb-1">
                <span id="current-time">0:00</span>
                <span id="duration">0:00</span>
            </div>
            <input type="range" id="progress-bar" 
                class="w-full h-2 rounded-full cursor-pointer accent-primary bg-gray-200 
                       shadow-inner appearance-none" value="0" min="0">
        </div>
        
        <!-- Kontrol Utama -->
        <div class="flex justify-center items-center space-x-6">
            <button id="prev-btn" 
                class="w-12 h-12 flex items-center justify-center rounded-full bg-accent text-dark 
                       border-2 border-dark shadow-border-offset transition-all duration-200 
                       hover:scale-110 active:shadow-none active:translate-x-0.5 active:translate-y-0.5">
                <i class="fas fa-step-backward text-lg"></i>
            </button>
            
            <button id="play-btn" 
                class="w-16 h-16 flex items-center justify-center rounded-full bg-primary text-dark 
                       border-2 border-dark shadow-border-offset-lg transition-all duration-200 
                       hover:scale-110 active:shadow-none active:translate-x-0.5 active:translate-y-0.5">
                <i class="fas fa-play text-2xl"></i>
            </button>
            
            <button id="next-btn" 
                class="w-12 h-12 flex items-center justify-center rounded-full bg-accent text-dark 
                       border-2 border-dark shadow-border-offset transition-all duration-200 
                       hover:scale-110 active:shadow-none active:translate-x-0.5 active:translate-y-0.5">
                <i class="fas fa-step-forward text-lg"></i>
            </button>
        </div>
        
        <!-- Kontrol Volume -->
        <div class="flex justify-center mt-2">
            <div class="flex items-center gap-3 bg-gray-100 px-4 py-2 rounded-playful-md border-2 border-dark shadow-border-offset">
                <button id="volume-btn" class="text-dark hover:text-primary transition-colors">
                    <i class="fas fa-volume-up"></i>
                </button>
                <input type="range" id="volume-control" 
                    class="w-28 h-2 rounded-full accent-primary cursor-pointer appearance-none bg-gray-300">
            </div>
        </div>
    </div>
</div>

            
            <!-- Timer -->
            <div class="bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg p-6 flex-1">
                <h2 class="text-h4 text-dark font-bold mb-4">Timer Meditasi</h2>
                <div class="text-center">
                    <div id="timer-display" class="text-h1 font-mono text-dark mb-4">00:00</div>
                    <div class="flex justify-center gap-4">
                        <button id="start-timer" class="px-6 py-3 bg-secondary text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent hover:bg-secondary/80">Mulai</button>
                        <button id="stop-timer" class="px-6 py-3 bg-orange text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent hover:bg-orange/80">Selesai</button>
                        <button id="reset-timer" class="px-6 py-3 bg-gray-200 text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset-accent hover:bg-gray-300">Reset</button>
                    </div>
                </div>
            </div>
        </main>

        <!-- Panel Kanan: Kategori Audio -->
        <aside class="lg:w-1/4 bg-white border-2 border-dark rounded-playful-md shadow-border-offset-lg p-4 overflow-y-auto">
            <h2 class="text-h4 text-dark font-bold mb-4">Kategori</h2>
            <div class="space-y-3" id="category-list">
                <!-- Item kategori akan diisi melalui JavaScript -->
            </div>
        </aside>
    </div>
</div>
@endsection

@section('script')
<script>
    // Data audio dari backend
    const meditationAudios = @json($audios);

    // Data kategori dari backend
    const categories = @json($categories);

    let currentAudio = null;
    let isPlaying = false;
    let timerInterval;
    let seconds = 0;
    let currentAudioIndex = 0;
    let filteredAudios = [...meditationAudios];

    document.addEventListener('DOMContentLoaded', function() {
        renderAudioList();
        renderCategories();
        setupEventListeners();
    });

    function renderAudioList() {
        const audioList = document.getElementById('audio-list');
        audioList.innerHTML = '';
        
        filteredAudios.forEach((audio, index) => {
    const audioItem = document.createElement('div');
    audioItem.className = `
        p-3 mb-2 border-2 border-dark rounded-playful-md shadow-border-offset 
        cursor-pointer transition-all duration-200
        hover:translate-x-1 hover:bg-primary/10
        ${index === currentAudioIndex ? 'bg-primary/20 border-primary' : 'bg-white'}
    `;
    audioItem.dataset.index = index;

    audioItem.innerHTML = `
        <div class="flex items-center justify-between">
            <div>
                <div class="font-bold text-dark flex items-center gap-2">
                    ${index === currentAudioIndex 
                        ? '<i class="fas fa-volume-up text-primary"></i>' 
                        : '<i class="fas fa-music text-gray-400"></i>'}
                    ${audio.title}
                </div>
                <div class="text-sm text-gray-600">${audio.description ?? ''}</div>
                <div class="text-xs text-gray-500 mt-1">${audio.duration ?? ''} • ${audio.category}</div>
            </div>
            <div class="text-xs font-semibold text-gray-400">
                #${index + 1}
            </div>
        </div>
    `;

    // klik pilih audio
    audioItem.addEventListener('click', () => selectAudio(index));

    audioList.appendChild(audioItem);
});

    }

    function renderCategories() {
    const categoryList = document.getElementById('category-list');
    categoryList.innerHTML = '';

    categories.forEach(category => {
        const categoryItem = document.createElement('div');
        categoryItem.className = `
            px-4 py-2 mb-2 border border-dark rounded-playful-sm 
            cursor-pointer text-center font-medium text-dark
            bg-white shadow-border-offset transition-all duration-200
            hover:bg-secondary/20 hover:scale-105 active:scale-95
        `;
        categoryItem.textContent = category;

        categoryItem.addEventListener('click', () => {
            // hilangkan highlight dari semua kategori
            [...categoryList.children].forEach(el => 
                el.classList.remove('bg-secondary/40', 'text-white', 'shadow-border-offset-lg')
            );
            
            // highlight kategori yang dipilih
            categoryItem.classList.add('bg-secondary/40', 'text-white', 'shadow-border-offset-lg');

            filterByCategory(category);
        });

        categoryList.appendChild(categoryItem);
    });
}


    function filterByCategory(category) {
        if (category === 'Semua') {
            filteredAudios = [...meditationAudios];
        } else {
            filteredAudios = meditationAudios.filter(audio => audio.category === category);
        }
        currentAudioIndex = 0;
        renderAudioList();
        if (currentAudio) {
            currentAudio.pause();
            isPlaying = false;
            updatePlayButton();
        }
    }

    function selectAudio(index) {
        currentAudioIndex = index;
        renderAudioList();
        
        if (currentAudio) {
            currentAudio.pause();
        }
        
        const audio = filteredAudios[currentAudioIndex];
        currentAudio = new Audio(`/storage/${audio.file_path}`);
        currentAudio.volume = document.getElementById('volume-control').value / 100;
        
        document.getElementById('current-audio-title').textContent = audio.title;
        document.getElementById('current-audio-desc').textContent = audio.description ?? '';
        
        currentAudio.addEventListener('loadedmetadata', function() {
            document.getElementById('duration').textContent = formatTime(currentAudio.duration);
        });
        
        currentAudio.addEventListener('timeupdate', function() {
            document.getElementById('current-time').textContent = formatTime(currentAudio.currentTime);
            document.getElementById('progress-bar').value = (currentAudio.currentTime / currentAudio.duration) * 100 || 0;
        });
        
        currentAudio.addEventListener('ended', function() {
            playNext();
        });
        
        currentAudio.play();
        isPlaying = true;
        updatePlayButton();
    }

    function formatTime(seconds) {
        const mins = Math.floor(seconds / 60);
        const secs = Math.floor(seconds % 60);
        return `${mins}:${secs < 10 ? '0' : ''}${secs}`;
    }

    function updatePlayButton() {
        const playIcon = document.querySelector('#play-btn i');
        if (isPlaying) {
            playIcon.className = 'fas fa-pause';
        } else {
            playIcon.className = 'fas fa-play';
        }
    }

    function playNext() {
        if (currentAudioIndex < filteredAudios.length - 1) {
            selectAudio(currentAudioIndex + 1);
        } else {
            selectAudio(0);
        }
    }

    function playPrev() {
        if (currentAudioIndex > 0) {
            selectAudio(currentAudioIndex - 1);
        } else {
            selectAudio(filteredAudios.length - 1);
        }
    }

    function setupEventListeners() {
        document.getElementById('play-btn').addEventListener('click', function() {
            if (!currentAudio) {
                if (filteredAudios.length > 0) {
                    selectAudio(0);
                }
                return;
            }
            
            if (isPlaying) {
                currentAudio.pause();
            } else {
                currentAudio.play();
            }
            isPlaying = !isPlaying;
            updatePlayButton();
        });
        
        document.getElementById('next-btn').addEventListener('click', playNext);
        document.getElementById('prev-btn').addEventListener('click', playPrev);
        
        document.getElementById('progress-bar').addEventListener('input', function() {
            if (currentAudio) {
                const percent = this.value;
                currentAudio.currentTime = (percent / 100) * currentAudio.duration;
            }
        });
        
        document.getElementById('volume-control').addEventListener('input', function() {
            if (currentAudio) {
                currentAudio.volume = this.value / 100;
            }
        });
        
        document.getElementById('start-timer').addEventListener('click', () => {
            clearInterval(timerInterval);
            timerInterval = setInterval(() => {
                seconds++;
                const mins = String(Math.floor(seconds / 60)).padStart(2, '0');
                const secs = String(seconds % 60).padStart(2, '0');
                document.getElementById('timer-display').innerText = `${mins}:${secs}`;
            }, 1000);
        });
        
        document.getElementById('stop-timer').addEventListener('click', () => {
            clearInterval(timerInterval);
        });
        
        document.getElementById('reset-timer').addEventListener('click', () => {
            clearInterval(timerInterval);
            seconds = 0;
            document.getElementById('timer-display').innerText = "00:00";
        });
    }
</script>


<style>
    /* Styling untuk range input */
    input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
        background: transparent;
        cursor: pointer;
    }
    
    input[type="range"]::-webkit-slider-track {
        background: #e5e7eb;
        height: 0.5rem;
        border-radius: 0.5rem;
        border: 1px solid #1a202c;
    }
    
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        height: 1.25rem;
        width: 1.25rem;
        border-radius: 50%;
        background: #4a5568;
        border: 2px solid #1a202c;
        cursor: pointer;
        box-shadow: 2px 2px 0 #1a202c;
    }
    
    input[type="range"]::-webkit-slider-thumb:active {
        box-shadow: 1px 1px 0 #1a202c;
        transform: translate(1px, 1px);
    }
    
    /* Transisi untuk tombol */
    button {
        transition: all 0.2s ease;
    }
    
    button:active {
        transform: translate(2px, 2px);
        box-shadow: none;
    }
</style>
@endsection