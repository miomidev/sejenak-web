@extends('layouts.app')

@section('title', 'Comunity')

    @section('style')
        <style>
            @import url('https://fonts.googleapis.com/css2?family=Exo+2:wght@400;500;600;700&family=Lexend:wght@300;400;500;600;700&display=swap');

            body {
                font-family: 'Lexend', sans-serif;
                background-color: #f8fafc;
            }

            .font-exo2 {
                font-family: 'Exo 2', sans-serif;
            }

            .font-lexend {
                font-family: 'Lexend', sans-serif;
            }

            .rounded-playful-lg {
                border-radius: 16px;
            }

            .border-dark {
                border-color: #1A1A40;
            }

            .shadow-border-offset {
                box-shadow: 4px 4px 0px #1A1A40;
            }

            .text-shadow-h1 {
                text-shadow: 2px 2px 0px #1A1A40;
            }

            .bg-primary {
                background-color: #FF6B6B;
            }

            .scrollbar-none::-webkit-scrollbar {
                display: none;
            }

            .scrollbar-none {
                -ms-overflow-style: none;
                scrollbar-width: none;
            }

            /* Animasi like */
            @keyframes heartBeat {
                0% {
                    transform: scale(1);
                }

                25% {
                    transform: scale(1.3);
                }

                50% {
                    transform: scale(0.95);
                }

                100% {
                    transform: scale(1);
                }
            }

            @keyframes likeBurst {
                0% {
                    transform: scale(0);
                    opacity: 0;
                }

                50% {
                    transform: scale(1.2);
                    opacity: 1;
                }

                100% {
                    transform: scale(1);
                    opacity: 1;
                }
            }

            @keyframes floatUp {
                0% {
                    transform: translateY(0) scale(0);
                    opacity: 0;
                }

                20% {
                    opacity: 1;
                }

                100% {
                    transform: translateY(-30px) scale(1.5);
                    opacity: 0;
                }
            }

            .animate-heart-beat {
                animation: heartBeat 0.6s ease-in-out;
            }

            .animate-like-burst {
                animation: likeBurst 0.5s ease-out;
            }

            .like-container {
                position: relative;
                display: inline-block;
            }

            .like-count-animation {
                transition: all 0.3s ease;
            }

            .like-count-up {
                transform: translateY(-5px);
                color: #EF4444;
                font-weight: bold;
            }

            .like-count-down {
                transform: translateY(5px);
                color: #6B7280;
            }

            .floating-heart {
                position: absolute;
                pointer-events: none;
                z-index: 10;
                color: #EF4444;
                animation: floatUp 1s ease-out forwards;
            }
        </style>
    @endsection
    @section('content')
        <div
            class="w-full min-h-full h-full flex flex-col pt-5 md:pt-0 md:flex-row gap-6 px-8 py-0 justify-center items-start overflow-auto">

            <div class="w-full md:hidden ">
                <div class="relative w-full">
                    <input type="text" placeholder="Pencarian..."
                        class="w-full p-4 pl-12 rounded-playful-lg border-2 border-dark shadow-border-offset font-lexend focus:outline-none">
                    <img src="{{ asset('assets/component/emote/search.svg') }}" alt="Pencarian"
                        class="absolute left-4 top-1/2 -translate-y-1/2 w-6 h-6 text-gray-400">
                </div>
            </div>

            <aside class="left-sidebar hidden md:block w-full md:w-1/4 lg:w-1/5 h-full py-4">
                <div class="bg-white p-6 rounded-playful-lg border-2 border-dark shadow-border-offset h-full">
                    <h2 class="font-bold text-xl font-exo2 text-dark mb-4">Community</h2>
                    <nav class="space-y-2">
                        <a href="#"
                            class="flex items-center gap-2 p-2 rounded-playful-lg font-medium font-lexend text-dark hover:bg-gray-100 transition-all">
                            <img src="{{ asset('assets/component/emote/home.svg') }}" alt="Homepage" class="w-6 h-6">
                            Homepage
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 p-2 rounded-playful-lg font-medium font-lexend text-dark hover:bg-gray-100 transition-all">
                            <img src="{{ asset('assets/component/emote/popular.svg') }}" alt="Popular" class="w-6 h-6">
                            Populer
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 p-2 rounded-playful-lg font-medium font-lexend text-dark hover:bg-gray-100 transition-all">
                            <img src="{{ asset('assets/component/emote/new.svg') }}" alt="Terbaru" class="w-6 h-6">
                            Terbaru
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 p-2 rounded-playful-lg font-medium font-lexend text-dark hover:bg-gray-100 transition-all">
                            <img src="{{ asset('assets/component/emote/search.svg') }}" alt="Pencarian" class="w-6 h-6">
                            Pencarian
                        </a>
                        <a href="#"
                            class="flex items-center gap-2 p-2 rounded-playful-lg font-medium font-lexend text-dark hover:bg-gray-100 transition-all">
                            <img src="{{ asset('assets/component/emote/love.svg') }}" alt="Notifikasi" class="w-6 h-6">
                            Notifikasi
                        </a>
                        <a href="#" onclick="openCreatePostModal()"
                            class="flex items-center gap-2 p-2 rounded-playful-lg font-medium font-lexend text-dark hover:bg-gray-100 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                                stroke="currentColor" class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            Create
                        </a>

                    </nav>
                </div>
            </aside>

            <main
                class="main-content w-full h-full overflow-auto md:w-2/4 lg:w-1/2 flex-grow flex flex-col items-center gap-6 pb-8 md:pb-0 p-0 m-0 scrollbar-none">
                <h1 class="font-bold text-3xl font-exo2 text-dark text-shadow-h1">Homepage</h1>

                @foreach ($posts as $post)
                    <div
                        class="post-card w-full max-w-2xl bg-primary p-6 rounded-playful-lg border-2 border-dark shadow-border-offset">
                        <div class="flex items-center mb-4 relative">
                            {{-- Bagian untuk Avatar dan Nama --}}
                            @php
                                $colors = [
                                    'bg-red-400',
                                    'bg-blue-400',
                                    'bg-green-400',
                                    'bg-yellow-400',
                                    'bg-purple-400',
                                    'bg-pink-400',
                                    'bg-orange-400',
                                    'bg-grey-400',
                                ];
                                $randomColor = $colors[array_rand($colors)];
                            @endphp

                            @if ($post->is_anonymous)
                                {{-- Skenario 1: Postingan anonim --}}
                                <div
                                    class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset mr-3 font-bold text-white {{ $randomColor }}">
                                    <img src="{{ asset('assets/component/emote/anonymous.svg') }}" alt="Anonymous"
                                        class="w-10 h-10 rounded-full border-2 border-dark shadow-border-offset object-cover">
                                </div>
                                <div class="flex-1">
                                    <h3 class="font-bold font-lexend text-dark text-lg">Anonymous</h3>
                                    <p class="text-sm text-black font-lexend">@anonymous •
                                        {{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            @else
                                {{-- Skenario 2: Postingan pengguna (dengan atau tanpa avatar) --}}
                                @if ($post->user->avatar)
                                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}"
                                        class="w-10 h-10 rounded-full border-2 border-dark shadow-border-offset mr-3 object-cover">
                                @else
                                    <div
                                        class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset mr-3 font-bold text-white {{ $randomColor }}">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="flex-1">
                                    <h3 class="font-bold font-lexend text-dark text-lg">{{ $post->user->name }}</h3>
                                    <p class="text-sm text-gray-500 font-lexend">{{ strtolower($post->user->name) }} •
                                        {{ $post->created_at->diffForHumans() }}</p>
                                </div>
                            @endif

                            {{-- New: Three-dot menu with dropdown --}}
                            <div class="absolute top-0 right-0">
                                <button class="text-dark p-2 rounded-full hover:bg-gray-200 transition-colors"
                                    onclick="toggleDropdown('dropdown-{{ $post->id }}')">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                        stroke-linecap="round" stroke-linejoin="round"
                                        class="feather feather-more-horizontal">
                                        <circle cx="12" cy="12" r="1"></circle>
                                        <circle cx="19" cy="12" r="1"></circle>
                                        <circle cx="5" cy="12" r="1"></circle>
                                    </svg>
                                </button>
                                <div id="dropdown-{{ $post->id }}"
                                    class="hidden absolute right-0 mt-2 w-40 bg-white border-2 border-dark rounded-lg shadow-lg z-10">
                                    {{-- Opsi dropdown hanya muncul jika pengguna adalah pemilik postingan --}}
                                    @if ($post->user_id == auth()->id())
                                        <a href=""
                                            class="block px-4 py-2 text-sm text-dark hover:bg-gray-100">Edit</a>
                                        <form action="{{ route('user.comunity.destroy', $post->id) }}" method="POST"
                                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="block w-full text-left px-4 py-2 text-sm text-dark hover:bg-gray-100">Hapus</button>
                                        </form>
                                    @endif
                                    <a href=""
                                        class="block px-4 py-2 text-sm text-red-500 hover:bg-gray-100">Laporkan</a>
                                </div>
                            </div>
                        </div>

                        @if ($post->image)
                            <div
                                class="w-full h-auto rounded-playful-lg mb-4 border-2 border-dark overflow-hidden shadow-border-offset">
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image"
                                    class="w-full h-full object-cover">
                            </div>
                        @endif

                        <p class="font-medium font-lexend text-dark mb-4">{{ $post->content }}</p>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4 w-30">
                                <div class="like-container">
                                    <button
                                        class="flex items-center gap-1 text-dark hover:text-red-500 transition-colors like-button"
                                        data-post-id="{{ $post->id }}"
                                        data-liked="{{ $post->isLikedByUser() ? 'true' : 'false' }}">
                                        @if ($post->isLikedByUser())
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24" class="w-7 h-7 like-icon text-red-500">
                                                <path d="M12 21.35l-1.45-1.32C5.4 15.36
                                                2 12.28 2 8.5 2 5.42 4.42 3
                                                7.5 3c1.74 0 3.41 0.81
                                                4.5 2.09C13.09 3.81 14.76 3
                                                16.5 3 19.58 3 22 5.42
                                                22 8.5c0 3.78-3.4 6.86-8.55
                                                11.18L12 21.35z" />
                                            </svg>
                                        @else
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                                viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                class="w-7 h-7 like-icon text-gray-500">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.688 3.75 5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                                            </svg>
                                        @endif
                                        <span
                                            class="font-lexend text-sm like-count like-count-animation">{{ $post->likes->count() }}</span>
                                    </button>
                                </div>

                                <button
                                    class="flex items-center gap-1 text-dark hover:text-blue-500 transition-colors comment-button"
                                    data-post-id="{{ $post->id }}" onclick="openCommentModal({{ $post->id }})">
                                    <img src="{{ asset('assets/component/emote/chat_icon.svg') }}" alt="Comment"
                                        class="w-6 h-6">
                                    <span class="font-lexend text-sm">{{ $post->comments->count() }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </main>


            <aside class="py-4 hidden md:flex right-sidebar w-full md:w-1/4 lg:w-1/5 h-full flex-shrink-0">
                <div class="bg-white p-6 rounded-playful-lg border-2 border-dark shadow-border-offset h-full">
                    <h2 class="font-bold text-xl font-exo2 text-dark mb-4">Top User</h2>
                    <div class="space-y-4">
                        @php
                            $colors = [
                                'bg-red-500',
                                'bg-blue-500',
                                'bg-green-500',
                                'bg-yellow-500',
                                'bg-purple-500',
                                'bg-pink-500',
                                'bg-indigo-500',
                                'bg-orange-500',
                            ];
                        @endphp

                        @foreach ($topUsers as $index => $user)
                            <div class="flex items-center gap-4">
                                @if ($user->avatar)
                                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}"
                                        class="w-10 h-10 rounded-full border-2 border-dark shadow-border-offset object-cover">
                                @else
                                    @php
                                        $bg = $colors[array_rand($colors)];
                                        $initial = strtoupper(substr($user->name, 0, 1));
                                    @endphp
                                    <div
                                        class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset text-white font-bold {{ $bg }}">
                                        {{ $initial }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-lexend font-bold text-dark">
                                        {{ $user->name }}
                                    </p>
                                    <p class="font-lexend text-sm text-gray-500">
                                        #{{ $index + 1 }} • Skor: {{ $user->score }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </aside>



            <a href="#" onclick="openCreatePostModal()"
                class="md:hidden fixed bottom-24 right-8 w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center border-2 border-dark shadow-border-offset click-1">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5"
                    stroke="currentColor" class="w-8 h-8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                </svg>
            </a>



        </div>

        <!-- Comment Modal -->
        <div id="commentModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden">
            <div
                class="bg-white p-6 rounded-playful-lg border-2 border-dark max-w-xl w-full shadow-border-offset overflow-y-auto max-h-[90vh]">
                <div class="flex justify-between items-center mb-4 border-b pb-4">
                    <h3 class="text-xl font-bold font-exo2 text-dark">Komentar</h3>
                    <button type="button" class="text-dark hover:text-gray-500 transition-colors" onclick="closeCommentModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <div id="commentModalContent" class="flex flex-col items-center mb-6">
                    <!-- Konten akan dimuat via AJAX -->
                    <div class="w-12 h-12 border-4 border-t-primary rounded-full animate-spin mx-auto my-8"></div>
                    <p class="text-center text-gray-500">Memuat data...</p>
                </div>

                <div id="commentsSection" class="space-y-6">
                    <!-- Komentar akan dimuat via AJAX -->
                </div>

                <!-- Form untuk menambahkan komentar baru -->
                <div class="mt-6 pt-4 border-t border-gray-200">
                    <form id="addCommentForm" class="flex gap-2">
                        @csrf
                        <input type="hidden" id="commentPostId" name="post_id">
                        <div class="flex-1">
                            <input type="text" name="content" placeholder="Tulis komentar..."
                                class="w-full p-3 rounded-playful-lg border-2 border-dark shadow-border-offset font-lexend focus:outline-none">
                        </div>
                        <button type="submit"
                            class="bg-primary text-white px-4 py-3 rounded-playful-lg border-2 border-dark font-lexend text-sm shadow-border-offset hover:bg-primary/80 transition-all active:shadow-[1px_2px_0px_#1A1A40] active:translate-x-0.5 active:translate-y-0.5">
                            Kirim
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Create Post Modal -->
        <!-- Modal Create Post -->
        <div id="createPostModal"
            class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4 hidden">
            <div
                class="bg-white p-6 rounded-playful-lg border-2 border-dark max-w-xl w-full shadow-border-offset overflow-y-auto max-h-[90vh]">

                <!-- Header -->
                <div class="flex justify-between items-center mb-4 border-b pb-4">
                    <h3 class="text-xl font-bold font-exo2 text-dark">Buat Postingan Baru</h3>
                    <button class="text-dark hover:text-gray-500 transition-colors" onclick="closeCreatePostModal()">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                <!-- Form Create Post -->
                <form action="{{ route('user.comunity.store') }}" method="POST" enctype="multipart/form-data"
                    class="space-y-4">
                    @csrf

                    <!-- Judul -->
                    <div>
                        <label class="block font-lexend text-dark font-semibold mb-2">Judul</label>
                        <input type="text" name="title"
                            class="w-full p-3 rounded-playful-lg border-2 border-dark shadow-border-offset font-lexend focus:outline-none"
                            placeholder="Masukkan judul postingan...">
                    </div>

                    <!-- Konten -->
                    <div>
                        <label class="block font-lexend text-dark font-semibold mb-2">Konten</label>
                        <textarea name="content" rows="5"
                            class="w-full p-3 rounded-playful-lg border-2 border-dark shadow-border-offset font-lexend focus:outline-none resize-none"
                            placeholder="Tulis sesuatu..."></textarea>
                    </div>

                    <!-- Upload Gambar -->
                    <div>
                        <label class="block font-lexend text-dark font-semibold mb-2">Upload Gambar (Opsional)</label>
                        <input type="file" name="image"
                            class="w-full border-2 border-dark rounded-playful-lg p-2 font-lexend shadow-border-offset bg-gray-50 focus:outline-none">
                    </div>

                    <!-- Checkbox Anonymous -->
                    <div class="flex items-center gap-2">
                        <input type="checkbox" name="is_anonymous" value="1" id="is_anonymous"
                            class="w-4 h-4 border-2 border-dark rounded">
                        <label for="is_anonymous" class="font-lexend text-dark text-sm">Posting sebagai anonim</label>
                    </div>

                    <!-- Tombol Simpan -->
                    <div class="flex justify-end gap-3">
                        <button type="button" onclick="closeCreatePostModal()"
                            class="px-4 py-2 rounded-playful-lg border-2 border-dark shadow-border-offset font-lexend text-sm bg-gray-200 hover:bg-gray-300 transition-all">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-4 py-2 rounded-playful-lg border-2 border-dark shadow-border-offset font-lexend text-sm bg-primary text-white hover:bg-primary/80 transition-all active:shadow-[1px_2px_0px_#1A1A40] active:translate-x-0.5 active:translate-y-0.5">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>
        </div>

@endsection

    @section('script')
        <script>
            function getAvatarUrl(avatarPath) {
                if (!avatarPath) return ''; // Kembalikan string kosong jika tidak ada avatar
                // Cek apakah path adalah URL absolut
                if (avatarPath.startsWith('http://') || avatarPath.startsWith('https://')) {
                    return avatarPath; // Jika ya, gunakan langsung
                }
                // Jika tidak, tambahkan prefix /storage/
                return `/storage/${avatarPath}`;
            }

            // Fungsi untuk membuka modal komentar dan memuat data via AJAX
            function openCommentModal(postId) {
                // Tampilkan modal
                document.getElementById('commentModal').classList.remove('hidden');

                // Set post ID pada form
                document.getElementById('commentPostId').value = postId;

                // Tampilkan loading state
                document.getElementById('commentModalContent').innerHTML = `
        <div class="w-12 h-12 border-4 border-t-primary rounded-full animate-spin mx-auto my-8"></div>
        <p class="text-center text-gray-500">Memuat data...</p>
    `;
                document.getElementById('commentsSection').innerHTML = '';

                // Ambil data postingan dan komentar via AJAX
                fetch(`/posts/${postId}/comments`)
                    .then(response => response.json())
                    .then(data => {
                        // Render konten postingan
                        renderPostContent(data.post);

                        // Render komentar
                        renderComments(data.comments);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        document.getElementById('commentModalContent').innerHTML = `
                <p class="text-center text-red-500">Gagal memuat data. Silakan coba lagi.</p>
            `;
                    });
            }

            // Fungsi untuk merender konten postingan
            function renderPostContent(post) {
                let imageHtml = '';
                if (post.image) {
                    imageHtml = `
            <div class="w-full max-w-md h-auto rounded-playful-lg border-2 border-dark overflow-hidden shadow-border-offset mb-4">
                <img src="/storage/${post.image}" alt="Post Image" class="w-full h-full object-cover">
            </div>
        `;
                }

                const contentHtml = `
        ${imageHtml}
        <p class="font-medium font-lexend text-dark text-center">${post.content}</p>
    `;

                document.getElementById('commentModalContent').innerHTML = contentHtml;
            }

            // Fungsi untuk merender komentar dan reply
            function renderComments(comments) {
                let commentsHtml = '';

                if (comments.length === 0) {
                    commentsHtml = '<p class="text-center text-gray-500">Belum ada komentar.</p>';
                } else {
                    comments.forEach(comment => {
                        const avatarUrl = getAvatarUrl(comment.user.avatar);
                        const userAvatar = avatarUrl ?
                            `<img src="${avatarUrl}" alt="${comment.user.name}" class="w-8 h-8 rounded-full border-2 border-dark shadow-border-offset flex-shrink-0">` :
                            `<div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset font-bold text-white bg-blue-400">${comment.user.name.charAt(0).toUpperCase()}</div>`;

                        const timeAgo = new Date(comment.created_at).toLocaleDateString('id-ID', {
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric',
                            hour: '2-digit',
                            minute: '2-digit'
                        });

                        // Render replies jika ada
                        let repliesHtml = '';
                        if (comment.replies && comment.replies.length > 0) {
                            comment.replies.forEach(reply => {
                                const replyAvatarUrl = getAvatarUrl(reply.user.avatar);
                                const replyUserAvatar = replyAvatarUrl ?
                                    `<img src="${replyAvatarUrl}" alt="${reply.user.name}" class="w-6 h-6 rounded-full border-2 border-dark shadow-border-offset flex-shrink-0">` :
                                    `<div class="w-6 h-6 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset font-bold text-white text-xs bg-green-400">${reply.user.name.charAt(0).toUpperCase()}</div>`;

                                const replyTimeAgo = new Date(reply.created_at).toLocaleDateString('id-ID', {
                                    year: 'numeric',
                                    month: 'long',
                                    day: 'numeric',
                                    hour: '2-digit',
                                    minute: '2-digit'
                                });

                                repliesHtml += `
                        <div class="reply flex gap-3 ml-8 mt-3">
                            ${replyUserAvatar}
                            <div class="flex-1">
                                <div class="bg-gray-100 p-2 rounded-playful-lg border-2 border-dark shadow-border-offset">
                                    <div class="flex justify-between items-center mb-1">
                                        <p class="font-bold font-lexend text-dark text-xs">${reply.user.name}</p>
                                        <span class="text-xs text-gray-500 font-lexend">${replyTimeAgo}</span>
                                    </div>
                                    <p class="font-lexend text-xs text-dark">${reply.content}</p>
                                </div>
                            </div>
                        </div>
                    `;
                            });
                        }

                        commentsHtml += `
                <div class="comment flex gap-3">
                    ${userAvatar}
                    <div class="flex-1">
                        <div class="bg-gray-100 p-3 rounded-playful-lg border-2 border-dark shadow-border-offset">
                            <div class="flex justify-between items-center mb-1">
                                <p class="font-bold font-lexend text-dark text-sm">${comment.user.name}</p>
                                <span class="text-xs text-gray-500 font-lexend">${timeAgo}</span>
                            </div>
                            <p class="font-lexend text-sm text-dark">${comment.content}</p>
                        </div>
                        <div class="flex items-center gap-4 mt-2 ml-3">
                            <button class="flex items-center gap-1 text-dark hover:text-red-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                </svg>
                                <span class="font-lexend text-xs">${comment.likes_count || 0}</span>
                            </button>
                            <button class="text-xs font-lexend text-gray-500 hover:text-dark transition-colors" onclick="showReplyForm('replyForm-${comment.id}')">Balas</button>
                        </div>

                    <!-- Form untuk reply -->
                    <div id="replyForm-${comment.id}" class="hidden mt-4 ml-8">
                        <form class="add-reply-form" data-comment-id="${comment.id}">
                            @csrf
                            <input type="hidden" name="comment_id" value="${comment.id}">
                            <textarea name="content" class="w-full p-2 text-sm border-2 border-dark rounded-playful-lg shadow-border-offset focus:outline-none font-lexend" placeholder="Tulis balasan..." required></textarea>
                            <div class="flex justify-end mt-2 gap-2">
                                <button type="button" class="px-3 py-1 rounded-playful-lg border-2 border-dark font-lexend text-sm bg-gray-200 hover:bg-gray-300 transition-all" onclick="hideReplyForm('replyForm-${comment.id}')">Batal</button>
                                <button type="submit" class="bg-primary text-white px-3 py-1 rounded-playful-lg border-2 border-dark font-lexend text-sm shadow-border-offset hover:bg-primary/80 transition-all active:shadow-[1px_2px_0px_#1A1A40] active:translate-x-0.5 active:translate-y-0.5">Kirim</button>
                            </div>
                        </form>
                    </div>

                        <!-- Daftar replies -->
                        <div class="replies-container mt-3">
                            ${repliesHtml}
                        </div>
                    </div>
                </div>
            `;
                    });
                }

                document.getElementById('commentsSection').innerHTML = commentsHtml;

                // Tambahkan event listener untuk form reply
                document.querySelectorAll('.add-reply-form').forEach(form => {
                    form.addEventListener('submit', handleReplySubmit);
                });
            }

            function handleReplySubmit(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const commentId = formData.get('comment_id');

                // Validasi form
                const content = formData.get('content');
                if (!content || content.trim() === '') {
                    alert('Konten balasan tidak boleh kosong');
                    return;
                }

                fetch('/replies', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(err => {
                                throw new Error(err.message || 'Network error')
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log("Response data:", data);

                        if (data.success) {
                            this.reset();

                            const replyForm = this.closest('[id^="replyForm-"]');
                            if (replyForm) {
                                replyForm.classList.add('hidden');
                            }

                            const commentElement = this.closest('.comment');
                            if (!commentElement) {
                                console.error('Comment element not found');
                                return;
                            }

                            const repliesContainer = commentElement.querySelector('.replies-container');
                            if (!repliesContainer) {
                                console.error('Replies container not found');
                                return;
                            }

                            const user = data.reply.user;
                            const initials = user.name ?
                                user.name.split(' ').map(n => n[0]).join('').substring(0, 1).toUpperCase() :
                                '?';

                            const replyAvatarUrl = getAvatarUrl(user.avatar);
                            const replyUserAvatar = replyAvatarUrl ?
                                `<img src="${replyAvatarUrl}" alt="${user.name}" class="w-6 h-6 rounded-full border-2 border-dark shadow-border-offset flex-shrink-0">` :
                                `<div class="w-6 h-6 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset font-bold text-white text-xs bg-green-400">${initials}</div>`;

                            const newReplyHtml = `
            <div class="reply flex gap-3 ml-8 mt-3">
                ${replyUserAvatar}
                <div class="flex-1">
                    <div class="bg-gray-100 p-2 rounded-playful-lg border-2 border-dark shadow-border-offset">
                        <div class="flex justify-between items-center mb-1">
                            <p class="font-bold font-lexend text-dark text-xs">${user.name}</p>
                            <span class="text-xs text-gray-500 font-lexend">Baru saja</span>
                        </div>
                        <p class="font-lexend text-xs text-dark">${data.reply.content}</p>
                    </div>
                </div>
            </div>
        `;

                            repliesContainer.innerHTML += newReplyHtml;
                        } else {
                            throw new Error(data.message || 'Failed to add reply');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menambahkan balasan: ' + error.message);
                    });
            }

            // Fungsi untuk menampilkan form reply
            function showReplyForm(formId) {
                const replyForm = document.getElementById(formId);
                if (replyForm) {
                    replyForm.classList.remove('hidden');
                    replyForm.querySelector('textarea').focus();
                }
            }

            // Fungsi untuk menyembunyikan form reply
            function hideReplyForm(formId) {
                const replyForm = document.getElementById(formId);
                if (replyForm) {
                    replyForm.classList.add('hidden');
                }
            }

            // Fungsi untuk menangani pengiriman komentar baru
            document.getElementById('addCommentForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const formData = new FormData(this);
                const postId = document.getElementById('commentPostId').value;

                fetch('/comments', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Reset form
                            this.reset();

                            // Tambahkan komentar baru ke daftar
                            const commentsSection = document.getElementById('commentsSection');
                            if (commentsSection.innerHTML.includes('Belum ada komentar')) {
                                commentsSection.innerHTML = '';
                            }

                            // Render komentar baru
                            const newCommentHtml = `
                <div class="comment flex gap-3">
                    <div class="w-8 h-8 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset font-bold text-white bg-blue-400">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-100 p-3 rounded-playful-lg border-2 border-dark shadow-border-offset">
                            <div class="flex justify-between items-center mb-1">
                                <p class="font-bold font-lexend text-dark text-sm">{{ auth()->user()->name }}</p>
                                <span class="text-xs text-gray-500 font-lexend">Baru saja</span>
                            </div>
                            <p class="font-lexend text-sm text-dark">${data.comment.content}</p>
                        </div>
                        <div class="flex items-center gap-4 mt-2 ml-3">
                            <button class="flex items-center gap-1 text-dark hover:text-red-500 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                </svg>
                                <span class="font-lexend text-xs">0</span>
                            </button>
                            <button class="text-xs font-lexend text-gray-500 hover:text-dark transition-colors" onclick="showReplyForm('replyForm-${data.comment.id}')">Balas</button>
                        </div>

                    <!-- Form untuk reply -->
                    <div id="replyForm-${data.comment.id}" class="hidden mt-4 ml-8">
                        <form class="add-reply-form" data-comment-id="${data.comment.id}">
                            @csrf
                            <input type="hidden" name="comment_id" value="${data.comment.id}">
                            <textarea name="content" class="w-full p-2 text-sm border-2 border-dark rounded-playful-lg shadow-border-offset focus:outline-none font-lexend" placeholder="Tulis balasan..." required></textarea>
                            <div class="flex justify-end mt-2 gap-2">
                                <button type="button" class="px-3 py-1 rounded-playful-lg border-2 border-dark font-lexend text-sm bg-gray-200 hover:bg-gray-300 transition-all" onclick="hideReplyForm('replyForm-${data.comment.id}')">Batal</button>
                                <button type="submit" class="bg-primary text-white px-3 py-1 rounded-playful-lg border-2 border-dark font-lexend text-sm shadow-border-offset hover:bg-primary/80 transition-all active:shadow-[1px_2px_0px_#1A1A40] active:translate-x-0.5 active:translate-y-0.5">Kirim</button>
                            </div>
                        </form>
                    </div>

                    <!-- Container untuk replies -->
                    <div class="replies-container mt-3"></div>
                </div>
            </div>
        `;

                            commentsSection.innerHTML += newCommentHtml;

                            // Tambahkan event listener untuk form reply yang baru
                            const newForm = document.querySelector(`#replyForm-${data.comment.id} .add-reply-form`);
                            if (newForm) {
                                newForm.addEventListener('submit', handleReplySubmit);
                            }

                            // Perbarui jumlah komentar di tombol
                            const commentButton = document.querySelector(
                                `.comment-button[data-post-id="${postId}"]`);
                            const countSpan = commentButton.querySelector('span');
                            countSpan.textContent = parseInt(countSpan.textContent) + 1;
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Gagal menambahkan komentar. Silakan coba lagi.');
                    });
            });

            function closeCommentModal() {
                document.getElementById('commentModal').classList.add('hidden');
            }

            function openCreatePostModal() {
                document.getElementById('createPostModal').classList.remove('hidden');
            }

            function closeCreatePostModal() {
                document.getElementById('createPostModal').classList.add('hidden');
            }

            function showReplyForm(formId) {
                const replyForm = document.getElementById(formId);
                if (replyForm) {
                    replyForm.classList.toggle('hidden');
                }
            }

            function toggleDropdown(id) {
                const dropdown = document.getElementById(id);
                dropdown.classList.toggle('hidden');
            }

            // Close modal when clicking outside
            window.onclick = function(event) {
                const commentModal = document.getElementById('commentModal');
                const createPostModal = document.getElementById('createPostModal');

                if (event.target == commentModal) {
                    closeCommentModal();
                }
                if (event.target == createPostModal) {
                    closeCreatePostModal();
                }

                // Close dropdowns when clicking outside
                const dropdowns = document.querySelectorAll('[id^="dropdown-"]');
                dropdowns.forEach(dropdown => {
                    if (!dropdown.previousElementSibling.contains(event.target) && !dropdown.contains(event
                        .target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }

            document.addEventListener('DOMContentLoaded', function() {
                const likeButtons = document.querySelectorAll('.like-button');

                likeButtons.forEach(button => {
                    button.addEventListener('click', function(e) {
                        e.preventDefault();

                        const postId = this.getAttribute('data-post-id');
                        const likeIcon = this.querySelector('.like-icon');
                        const likeCount = this.querySelector('.like-count');
                        const isLiked = this.getAttribute('data-liked') === 'true';
                        const container = this.closest('.like-container');

                        // Animasi ikon hati
                        likeIcon.classList.add('animate-heart-beat');

                        // Buat elemen hati yang mengambang
                        if (!isLiked) {
                            const floatingHeart = document.createElement('div');
                            floatingHeart.innerHTML = `
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                                    <path d="M11.645 20.91l-.007-.003-.022-.012a15.247 15.247 0 01-.383-.218 25.18 25.18 0 01-4.244-3.17C4.688 15.36 2.25 12.174 2.25 8.25 2.25 5.322 4.714 3 7.688 3A5.5 5.5 0 0112 5.052 5.5 5.5 0 0116.313 3c2.973 0 5.437 2.322 5.437 5.25 0 3.925-2.438 7.111-4.739 9.256a25.175 25.175 0 01-4.244 3.17 15.247 15.247 0 01-.383.219l-.022.012-.007.004-.003.001a.752.752 0 01-.704 0l-.003-.001z" />
                                </svg>
                            `;
                            floatingHeart.classList.add('floating-heart');
                            container.appendChild(floatingHeart);

                            // Hapus elemen setelah animasi selesai
                            setTimeout(() => {
                                container.removeChild(floatingHeart);
                            }, 1000);
                        }

                        // Animasi perubahan angka
                        likeCount.classList.remove('like-count-up', 'like-count-down');
                        void likeCount.offsetWidth; // Trigger reflow

                        if (isLiked) {
                            likeCount.classList.add('like-count-down');
                        } else {
                            likeCount.classList.add('like-count-up');
                        }

                        // Hapus kelas animasi setelah selesai
                        setTimeout(() => {
                            likeIcon.classList.remove('animate-heart-beat');
                            likeCount.classList.remove('like-count-up', 'like-count-down');
                        }, 600);

                        // Kirim request ke server
                        toggleLike(postId);
                    });
                });
            });

            // Fungsi untuk mengirim like ke server
            function toggleLike(postId) {
                fetch(`/post/${postId}/like`, {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            "Content-Type": "application/json"
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        const btn = document.querySelector(`[data-post-id="${postId}"]`);
                        const likeIcon = btn.querySelector('.like-icon');
                        const likeCount = btn.querySelector('.like-count');

                        // Perbarui tampilan berdasarkan respons server
                        likeCount.textContent = data.likes_count;

                        if (data.liked) {
                            likeIcon.innerHTML =
                                `<path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41 0.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.18L12 21.35z" />`;
                            likeIcon.classList.add('text-red-500');
                            likeIcon.classList.remove('text-gray-500');
                            btn.setAttribute('data-liked', 'true');
                        } else {
                            likeIcon.innerHTML =
                                `<path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733C11.285 4.876 9.623 3.75 7.688 3.75 5.099 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />`;
                            likeIcon.classList.remove('text-red-500');
                            likeIcon.classList.add('text-gray-500');
                            btn.setAttribute('data-liked', 'false');
                        }
                    })
                    .catch(err => console.error("Error:", err));
            }
        </script>
    @endsection
