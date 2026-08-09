@extends('layouts.app')

@section('title', 'Exercise & Latihan Meringankan Stres')

@section('style')
<style>
    .exercise-card {
        @apply bg-white border-2 border-dark rounded-playful-lg p-6 shadow-border-offset hover:-translate-y-1 hover:shadow-border-offset-lg transition-all duration-200 cursor-pointer flex flex-col justify-between h-full;
    }
</style>
@endsection

@section('content')
<div id="main-exercise-page" class="w-full h-full flex flex-col gap-6 bg-background p-4 md:p-8 font-main max-w-7xl mx-auto">
    <!-- Header Section -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white p-6 border-2 border-dark rounded-playful-lg shadow-border-offset">
        <div>
            <span class="px-3 py-1 rounded-full bg-secondary text-dark font-extrabold text-xs uppercase border-2 border-dark shadow-[2px_2px_0_#080330]">
                🧘 PANDUAN EXERCISE SEJENAK
            </span>
            <h1 class="text-2xl md:text-4xl font-extrabold text-dark mt-2">Latihan & Teknik Merelaksasi Pikiran</h1>
            <p class="text-sm md:text-base text-gray-600 font-semibold mt-1">Dipandu langsung oleh Tim Konselor & Admin dalam format Video interaktif dan Artikel Blog terbimbing.</p>
        </div>
        <a href="{{ route('user.meditation') }}" class="px-5 py-3 bg-primary hover:bg-primary/90 text-dark font-extrabold rounded-playful-md border-2 border-dark shadow-[3px_3px_0_#080330] hover:translate-x-0.5 hover:translate-y-0.5 transition-all flex items-center gap-2 whitespace-nowrap">
            <span>🎵</span> Ke Audio Meditasi
        </a>
    </div>

    <!-- Category Filter Tabs -->
    <div class="flex flex-wrap items-center gap-3 bg-white p-4 border-2 border-dark rounded-playful-lg shadow-border-offset">
        <span class="text-xs font-extrabold text-dark uppercase tracking-wider mr-2">Filter Jenis Latihan:</span>
        <button class="filter-tab-btn px-4 py-2 rounded-playful-md border-2 border-dark text-xs font-extrabold bg-primary text-black shadow-[2px_2px_0_#080330]" data-filter="all">Semua</button>
        <button class="filter-tab-btn px-4 py-2 rounded-playful-md border-2 border-dark text-xs font-extrabold bg-white hover:bg-secondary/40 text-dark shadow-[2px_2px_0_#080330]" data-filter="video">📹 Video Exercise</button>
        <button class="filter-tab-btn px-4 py-2 rounded-playful-md border-2 border-dark text-xs font-extrabold bg-white hover:bg-secondary/40 text-dark shadow-[2px_2px_0_#080330]" data-filter="text">📖 Artikel Blog</button>
        <button class="filter-tab-btn px-4 py-2 rounded-playful-md border-2 border-dark text-xs font-extrabold bg-white hover:bg-secondary/40 text-dark shadow-[2px_2px_0_#080330]" data-type-filter="breathing">💨 Pernapasan</button>
        <button class="filter-tab-btn px-4 py-2 rounded-playful-md border-2 border-dark text-xs font-extrabold bg-white hover:bg-secondary/40 text-dark shadow-[2px_2px_0_#080330]" data-type-filter="mindfulness">🧠 Mindfulness</button>
        <button class="filter-tab-btn px-4 py-2 rounded-playful-md border-2 border-dark text-xs font-extrabold bg-white hover:bg-secondary/40 text-dark shadow-[2px_2px_0_#080330]" data-type-filter="grounding">⛰️ Grounding</button>
    </div>

    <!-- Exercise Grid List -->
    <div id="exercise-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($exercises as $ex)
            <div class="exercise-card item-filter" data-content-type="{{ $ex->content_type }}" data-type="{{ $ex->type }}" onclick="openExerciseModal({{ $ex->id }})">
                <div>
                    <div class="flex justify-between items-start mb-4">
                        <span class="px-3 py-1 rounded-full border-2 border-dark text-xs font-extrabold {{ $ex->content_type === 'video' ? 'bg-purple-200 text-purple-900' : 'bg-green-200 text-green-900' }} shadow-[2px_2px_0_#080330] uppercase">
                            {{ $ex->content_type === 'video' ? '📹 Video Exercise' : '📖 Artikel Blog' }}
                        </span>
                        <span class="text-xs font-extrabold text-gray-500 bg-gray-100 px-3 py-1 rounded-playful-sm border border-dark">
                            ⏱️ {{ $ex->duration_minutes }} Menit
                        </span>
                    </div>

                    <h3 class="text-xl font-extrabold text-dark mb-2 leading-snug hover:text-primary transition-colors">
                        {{ $ex->title }}
                    </h3>
                    <p class="text-xs font-extrabold text-gray-500 mb-3">
                        ✍️ {{ $ex->author_name }}
                    </p>
                    <p class="text-sm text-gray-600 line-clamp-4 leading-relaxed mb-4">
                        {{ $ex->description }}
                    </p>
                </div>

                <div class="pt-4 border-t-2 border-dark/10 flex justify-between items-center">
                    <span class="text-xs font-extrabold text-dark uppercase tracking-wider">
                        Kategori: {{ ucfirst($ex->type) }}
                    </span>
                    <button class="px-4 py-2 bg-secondary hover:bg-secondary/80 border-2 border-dark rounded-playful-md text-xs font-extrabold text-dark shadow-[2px_2px_0_#080330] transition-all">
                        {{ $ex->content_type === 'video' ? 'Tonton Video ▶' : 'Baca Artikel 📖' }}
                    </button>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16 text-gray-500 font-semibold bg-white border-2 border-dark rounded-playful-lg p-8">
                Belum ada materi exercise yang diunggah oleh konselor.
            </div>
        @endforelse
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
        // Tab Filter
        document.querySelectorAll('.filter-tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filter-tab-btn').forEach(b => {
                    b.classList.remove('bg-primary', 'text-black');
                    b.classList.add('bg-white', 'text-dark');
                });
                this.classList.add('bg-primary', 'text-black');
                this.classList.remove('bg-white');

                const contentTypeFilter = this.getAttribute('data-filter');
                const typeFilter = this.getAttribute('data-type-filter');

                document.querySelectorAll('.item-filter').forEach(card => {
                    const matchesContent = !contentTypeFilter || contentTypeFilter === 'all' || card.getAttribute('data-content-type') === contentTypeFilter;
                    const matchesType = !typeFilter || card.getAttribute('data-type') === typeFilter;

                    if (matchesContent && matchesType) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Modal Functionality
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
