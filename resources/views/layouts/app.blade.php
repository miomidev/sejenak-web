<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
     <title>Sejenak – A Safe Space for Everybody</title>
  <meta name="description" content="Sejenak adalah aplikasi meditasi & mindfulness, menyediakan ruang aman bagi siapa saja untuk menenangkan pikiran, mengelola stres, dan menjaga kesehatan mental.">
  <meta name="keywords" content="sejenak, meditasi, mindfulness, ruang aman, safe space, kesehatan mental, aplikasi meditasi, self care, relaksasi">

  <!-- Open Graph (social media sharing) -->
  <meta property="og:title" content="Sejenak – A Safe Space for Everybody">
  <meta property="og:description" content="Temukan ruang aman untuk mereset pikiran. Meditasi, latihan pernapasan, dan refleksi diri dalam satu aplikasi.">
  <meta property="og:image" content="https://sejenak.app/assets/og-image.jpg">  
  <meta property="og:url" content="https://sejenak.app">
  <meta property="og:type" content="website">
  <meta property="og:locale" content="id_ID">

  <!-- Twitter Card -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="Sejenak – A Safe Space for Everybody">
  <meta name="twitter:description" content="Ruang aman untuk menenangkan diri, meditasi, dan refleksi.">
  <meta name="twitter:image" content="https://sejenak.app/assets/og-image.jpg">

  <!-- Structured Data (Schema.org / JSON-LD) -->
  

  <!-- (tambahan opsional) canonical tag -->
  <link rel="canonical" href="https://sejenak.app" />
  
  <!-- (tambahan opsional) robots meta -->
  <meta name="robots" content="index, follow" />
    <title>Sejenak - @yield('title')</title>
    <link rel="stylesheet" href="{{ asset('assets/css/loading.css') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Lexend:wght@100..900&display=swap');

        * {
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE 10+ */
        }

        *::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Edge */
        }

        body {
            font-family: 'Lexend', sans-serif;
        }

        .dot-background {
            background-image: radial-gradient(#d6d9e1 3px, transparent 1px);
            background-size: 20px 20px;
        }

        .text-shadow-h1 {
            color: white;
            text-shadow:
                -1px -1px 0 #080330,
                1px -1px 0 #080330,
                -1px 1px 0 #080330,
                1px 1px 0 #080330,
                3px 3px 0 #080330;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
        }

        .text-shadow-soft {
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.25);
        }

        .text-shadow-glow {
            text-shadow: 0 0 6px #8FD14F;
        }

        /* Floating chat avatar and bubble styles */
        #floating-chat-container {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            /* display: flex;
            align-items: flex-start; */
        }


        #floating-chat-container.mobile {
            bottom: 20px;
            left: 20px;
            top: auto;
            right: auto;
        }

        #floating-chat-container.desktop {
            bottom: 5vh;
            right: 5vw;
            top: auto;
            left: auto;
        }

        #floating-chat-avatar-btn {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            /* background-color: #604CC3; */
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.3);
            display: flex;
            justify-content: center;
            align-items: center;
            cursor: grab;

            user-select: none;
            transition: transform 0.3s ease;
            position: relative;
            border: 2px solid #080330;
        }

        #floating-chat-avatar-btn:hover {
            transform: scale(1.1);
        }

        #floating-chat-avatar-btn img {
            z-index: 1005;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
        }

        #chat-bubble {
            position: fixed;
            bottom: 70px;
            right: 0;
            background-color: white;
            border: 2px solid #080330;
            border-radius: 18px;
            padding: 12px 15px;
            box-shadow: 3px 4px 0 #080330;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 101;
            display: flex;
            flex-direction: column;
            height: 30vh;
            transition: left 0.1s, top 0.1s;
            width: 300px;
        }

        #chat-bubble.show {
            opacity: 1;
            visibility: visible;
        }

        #chat-bubble-content {
            flex-grow: 1;
            padding-bottom: 10px;
            max-height: 250px;
            overflow-y: auto;
        }

        .chat-message-ai,
        .chat-message-user {
            padding: 8px 12px;
            margin-bottom: 8px;
            border-radius: 10px;
            max-width: 80%;
            border: #080330 2px solid;
        }

        .chat-message-ai {
            align-self: flex-start;
            background-color: #f0f0f0;
            border: 1px solid #ddd;
            border-bottom-left-radius: 0;
        }

        .chat-message-user {
            align-self: flex-end;
            background-color: #8FD14F;
            color: white;
            border-bottom-right-radius: 0;
        }

        #chat-input-area {
            display: flex;
            border-top: 1px solid #ccc;
            padding-top: 10px;
            min-width: 150px;
        }

        #chat-input-area input {
            flex-grow: 1;
            border: 1px solid #ccc;
            border-radius: 20px;
            padding: 8px 15px;
            margin-right: 8px;
        }

        #chat-input-area button {
            background-color: #8FD14F;
            color: white;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: none;
            cursor: pointer;
        }

        #weather-city {
            white-space: nowrap; /* Mencegah teks turun ke baris baru */
            overflow: hidden;    /* Menyembunyikan teks yang meluber keluar dari kotak */
            text-overflow: ellipsis; /* Menampilkan titik-titik (...) pada teks yang terpotong */
            
            /* Opsional: Beri lebar maksimal agar lebih terkontrol */
            max-width: 120px; 
        }



        @media (max-width: 768px) {
            #floating-chat-container.mobile {
                bottom: 170px;
                right: 20px;
                top: auto;
                left: auto;
            }

            #chat-bubble::after {
                bottom: -10px;
                right: 20px;
                left: auto;
            }

            #chat-bubble::before {
                bottom: -13px;
                right: 19px;
                left: auto;
            }
        }
    </style>
    <style type="text/tailwindcss">
        @layer utilities {
            .scrollbar-none::-webkit-scrollbar {
                display: none;
            }

            .scrollbar-none {
                -ms-overflow-style: none;
                /* IE/Edge */
                scrollbar-width: none;
                /* Firefox */
            }

            .calendar-day-circle {
                @apply w-10 h-10 flex items-center justify-center rounded-full border-2 transition-all cursor-pointer;
            }

            .calendar-dot {
                @apply absolute bottom-1 w-2 h-2 rounded-full;
            }

            .text-shadow-custom {
                text-shadow: 3px 5px 0px #000000;
            }

            .content-calendar {
                @apply w-[90%] h-[90%] border border-black rounded flex justify-center items-center m-0;
            }

            .td-meditation {
                @apply absolute w-3 h-3 bg-stroke border border-black rounded-full -bottom-[50%] left-[20%];
            }

            .td-jurnaling {
                @apply absolute w-3 h-3 bg-stroke border border-black rounded-full -bottom-[50%] -left-[15%];
            }

            .td-disable {
                @apply bg-stroke;
            }

            .td-purple {
                @apply bg-secondary;
            }

            .td-orange {
                @apply bg-accent;
            }

            .today {
                @apply text-accent font-bold;
            }

            .click {
                @apply transition-transform transition-shadow cursor-pointer;
                box-shadow: 4px 4px 0 rgba(0, 0, 0, 0.25);
            }

            .click:active {
                @apply translate-x-0.5;
                box-shadow: 2px 2px 0 rgba(0, 0, 0, 0.2);
            }

            .click:hover {
                transform: translateY(-2px);
                box-shadow: 6px 6px 0 rgba(0, 0, 0, 0.3);
            }

            .click-1 {
                @apply border-dark cursor-pointer shadow-border-offset active:shadow-none active:translate-x-0.5 active:translate-y-0.5 transition-all last:mb-0;
            }

            .-click-1 {
                @apply border-dark cursor-pointer active:shadow-border-offset shadow-none active:-translate-x-0.5 active:-translate-y-0.5 transition-all last:mb-0;
            }

            .-hover-1 {
                @apply border-dark cursor-pointer shadow-border-offset hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all last:mb-0;
            }

            .hover-1 {
                @apply border-dark cursor-pointer shadow-border-offset hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all last:mb-0;
            }

            /* .click-1:active {
        @apply translate-x-0.5 translate-y-0.5;
        box-shadow: 2px 2px 0 rgba(0, 0, 0, 0.2);
    }

    .click-1:hover {
        transform: translateY(-2px);
        box-shadow: 6px 6px 0 rgba(0, 0, 0, 0.3);
    } */
        }
    </style>
    @yield('style')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#94B704', // from --primary
                        secondary: '#DCD489', // from --secondary
                        dark: '#080330', // from --dark
                        light: '#ffffff', // from --light
                        white: '#f7f7f7', // from --white (duplikat, pilih salah satu)
                        stroke: '#000000', // from --stroke
                        purple: '#876582', // from --purple
                        orange: '#FF6600', // from --orange
                        black: '#080330', // same as dark
                    },
                    fontFamily: {
                        lexend: ['Lexend', 'sans-serif'],
                        exo2: ['exo-2', 'sans-serif']
                    },
                    boxShadow: {

                        '-border-offset': '-3px -4px 0 #080330',
                        'border-offset': '3px 4px 0 #080330',
                        'border-offset-lg': '5px 7px 0 #080330',
                        'border-offset-accent': '3px 4px 0 #8FD14F',
                    },
                    textShadow: {
                        h1: '2px 2px 0 #080330, 4px 4px 0 #2C2B4B',
                    },
                    fontSize: {
                        h1: ['2.5rem', {
                            lineHeight: '3rem',
                            fontWeight: '700'
                        }],
                        h2: ['2rem', {
                            lineHeight: '2.5rem',
                            fontWeight: '700'
                        }],
                        h3: ['1.75rem', {
                            lineHeight: '2.25rem',
                            fontWeight: '600'
                        }],
                        h4: ['1.5rem', {
                            lineHeight: '2rem',
                            fontWeight: '600'
                        }],
                        h5: ['1.25rem', {
                            lineHeight: '1.75rem',
                            fontWeight: '500'
                        }],
                        h6: ['1rem', {
                            lineHeight: '1.5rem',
                            fontWeight: '500'
                        }],
                    },
                    borderRadius: {
                        'playful-sm': '12px',
                        'playful-md': '18px',
                        'playful-lg': '24px',
                    },
                },
            },
        };
    </script>
</head>

<body class="bg-gray-100 min-h-screen flex lexend">
    @include('layouts.component.loading')
   <header
    class="fixed top-0 left-0 right-0 bg-primary px-4 py-3 flex items-center justify-between shadow-border-offset border-b-2 border-dark md:hidden z-40">

    <div class="flex items-center space-x-2 hover-gentle-bounce">
        <div class="w-9 h-9 rounded-playful-sm flex items-center justify-center">
            <img src="{{ asset('assets/icon/sejenak-header.svg') }}" alt="Sejenak Logo" class="w-full h-full">
        </div>
        <h1 class="text-lg font-bold font-exo2 text-dark">Sejenak</h1>
    </div>

    @php
        use Illuminate\Support\Str;

        $avatar = Auth::user()->avatar ?? null;
        if (empty($avatar)) {
            $avatarUrl = asset('assets/icon/nav-profile.svg');
        } elseif (Str::startsWith($avatar, 'http')) {
            $avatarUrl = $avatar;
        } else {
            $avatarUrl = asset('storage/' . $avatar);
        }

        $userName = Str::limit(Auth::user()->name ?? 'Pengguna', 12);
    @endphp

    <a href="{{ route('user.profiles') }}" class="flex items-center space-x-2">
        <img
            src="{{ $avatarUrl }}"
            alt="User Profile"
            class="w-8 h-8 rounded-full border-2 border-dark object-cover shadow-border-offset">
        <span class="text-dark font-exo2 font-semibold text-sm truncate max-w-[100px] hidden sm:inline">
            {{ $userName }}
        </span>
    </a>
</header>



    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 z-10 hidden"></div>

    @include('layouts.component.sidebar')

    <main class="flex-1 flex flex-col pt-16 pb-16 md:pb-0 md:pt-0">
        <div class="flex-shrink-0">
            @yield('page-header')
        </div>

        {{-- <div class="dot-background md:m-5 md:ml-1 md:rounded-[40px] border-2 border-dark md:shadow-[5px_7px_0px_#080330] p-2 md:py-6 px-0 flex flex-col md:flex-row justify-center align-middle items-center max-w-[100vw] md:max-w-[95vw] flex-1 overflow-y-auto md:overflow-hidden"> --}}
        <div
            class="dot-background md:m-5 md:ml-1 md:rounded-[40px] border-2 border-dark md:shadow-[5px_7px_0px_#080330]  flex flex-col md:flex-row justify-center align-middle items-center max-w-[100vw] md:max-w-[95vw] md:h-[94vh] md:max-h-[94vh] h-full overflow-y-auto md:overflow-hidden">
            <!-- Error Notification -->
            @if (session('error') || $errors->any())
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="fixed top-20 md:top-10 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4">
                    <div class="bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-start space-x-3 w-full">
                        <!-- Icon -->


                        <div class="flex-1">
                            <p class="font-semibold">Terjadi Kesalahan</p>

                            @if (session('error'))
                                <p class="text-sm">{{ session('error') }}</p>
                            @endif

                            @if ($errors->any())
                                <ul class="list-disc list-inside text-sm">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>

                        <!-- Tombol Close -->
                        <button @click="show = false" class="text-white/80 hover:text-white ml-2">
                            ✕
                        </button>
                    </div>
                </div>
            @endif
            @if (session('success'))
                <div x-data="{ show: true }" x-show="show" x-transition
                    class="fixed top-20 md:top-10 left-1/2 transform -translate-x-1/2 z-50 w-full max-w-md px-4">
                    <div
                        class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg flex items-start space-x-3 w-full">
                        <!-- Icon -->

                        <div class="flex-1">
                            <p class="font-semibold">Berhasil</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>

                        <!-- Tombol Close -->
                        <button @click="show = false" class="text-white/80 hover:text-white ml-2">
                            ✕
                        </button>
                    </div>
                </div>
            @endif
            @yield('content')
        </div>
    </main>

    @section('floating-chat')
        <div id="floating-chat-container" class="desktop">
            <div id="chat-bubble">
                <div id="chat-bubble-content">
                    <p class="chat-message-ai" id="ai-greeting-message">Memuat info... 🤔</p>
                </div>
                <div id="chat-input-area">
                    <input type="text" id="chat-input" placeholder="Ketik pesan Anda..."
                           onkeydown="handleKeyDown(event)">
                    <button id="chat-send-btn">
                        <i class="fas fa-paper-plane"></i>
                    </button>
                </div>
            </div>
            <div id="floating-chat-avatar-btn" class="bg-none">
                <img src="{{ asset('assets/component/lady_icon.svg') }}" alt="AI Avatar" class="bg-transparent">
            </div>
        </div>
    @show

    <nav class="fixed bottom-0 left-0 right-0 bg-white border-t-2 border-dark shadow-border-offset md:hidden z-40">
        <div class="flex justify-around items-center py-2">
            <a href="{{ route('user.dashboard') }}"
                class="flex flex-col items-center space-y-1 transition-all duration-200 hover:scale-105 active:scale-95">
                <div class="w-9 h-9 rounded-playful-sm flex items-center justify-center">
                    <img src="{{ asset('assets/icon/nav-dashboard.svg') }}" alt="Dashboard">
                </div>
                <span class="text-xs font-medium text-dark">Dashboard</span>
            </a>
            <a href="{{ route('user.comunity') }}"
                class="flex flex-col items-center space-y-1 transition-all duration-200 hover:scale-105 active:scale-95">
                <div class="w-10 h-10 rounded-playful-sm flex items-center justify-center">
                    <img src="{{ asset('assets/icon/nav-post.svg') }}" alt="Postingan">
                </div>
                <span class="text-xs font-medium text-dark">Postingan</span>
            </a>
            <a href="{{ route('user.meditation') }}"
                class="flex flex-col items-center space-y-1 transition-all duration-200 hover:scale-105 active:scale-95">
                <div class="w-10 h-10 rounded-playful-sm flex items-center justify-center">
                    <img src="{{ asset('assets/icon/nav-meditasi.svg') }}" alt="Meditasi">
                </div>
                <span class="text-xs font-medium text-dark">Meditasi</span>
            </a>
            <a href="{{ route('chat') }}"
                class="flex flex-col items-center space-y-1 transition-all duration-200 hover:scale-105 active:scale-95">
                <div class="w-9 h-9 rounded-playful-sm flex items-center justify-center">
                    <img src="{{ asset('assets/icon/nav-chat.svg') }}" alt="Chat">
                </div>
                <span class="text-xs font-medium text-dark">Chat</span>
            </a>
            <a href="{{ route('user.journal') }}"
                class="flex flex-col items-center space-y-1 transition-all duration-200 hover:scale-105 active:scale-95">
                <div class="w-9 h-9 rounded-playful-sm flex items-center justify-center">
                    <img src="{{ asset('assets/icon/nav-journal.svg') }}" alt="Journal">
                </div>
                <span class="text-xs font-medium text-dark">Journal</span>
            </a>
            <!-- <a href="{{ route('user.blog') }}" class="flex flex-col items-center space-y-1 transition-all duration-200 hover:scale-105 active:scale-95">
                <div class="w-9 h-9 rounded-playful-sm flex items-center justify-center">
                    <img src="{{ asset('assets/icon/nav-journal.svg') }}" alt="Blog">
                </div>
                <span class="text-xs font-medium text-dark">Blog</span>
            </a> -->
        </div>
    </nav>


    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const greetingElement = document.getElementById('ai-greeting-message');
            const defaultMessage = "Hai! Aku Sejenak AI. Ada yang bisa dibantu?";

            if (!greetingElement) return;

            const cachedWeather = localStorage.getItem('weatherData');
            const tenMinutes = 10 * 60 * 1000; // 10 menit

            if (cachedWeather) {
                const { data, timestamp } = JSON.parse(cachedWeather);
                const now = new Date().getTime();

                if ((now - timestamp) < tenMinutes) {
                    console.log("Floating Chat: Sapaan dimuat dari cache (super cepat!)");
                    const weatherMessage = `Cuaca hari ini ${data.description.toLowerCase()}, lho. Ada yang bisa kubantu?`;
                    greetingElement.textContent = weatherMessage;
                    return; // Selesai! Tidak perlu fetch data baru.
                }
            }
            
            console.log("Floating Chat: Cache kosong/kedaluwarsa, mengambil data baru.");

            if (!('geolocation' in navigator)) {
                console.log("Geolocation tidak didukung, menampilkan pesan default.");
                greetingElement.textContent = defaultMessage;
                return;
            }

            navigator.geolocation.getCurrentPosition(async (position) => {
                const { latitude: lat, longitude: lon } = position.coords;
                
                try {
                    const response = await fetch(`{{ route('weather.get') }}?lat=${lat}&lon=${lon}`);
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data cuaca.');
                    }
                    const data = await response.json();
                    const dataToCache = {
                        data: data,
                        timestamp: new Date().getTime()
                    };
                    localStorage.setItem('weatherData', JSON.stringify(dataToCache));
                    
                    const weatherMessage = `Cuaca hari ini ${data.description.toLowerCase()}, lho. Ada yang bisa kubantu?`;
                    greetingElement.textContent = weatherMessage;

                } catch (error) {
                    console.error("Error saat mengambil cuaca:", error);
                    greetingElement.textContent = defaultMessage;
                }
            }, () => {
                // Handle jika pengguna menolak izin lokasi
                console.log("Izin lokasi ditolak, menampilkan pesan default.");
                greetingElement.textContent = defaultMessage;
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const floatingChatContainer = document.getElementById('floating-chat-container');
            const floatingChatAvatarBtn = document.getElementById('floating-chat-avatar-btn');
            const chatBubble = document.getElementById('chat-bubble');
            const chatBubbleContent = document.getElementById('chat-bubble-content');
            const chatInput = document.getElementById('chat-input');
            const chatSendBtn = document.getElementById('chat-send-btn');

            // Sidebar toggle logic
            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('hidden');
                    overlay.classList.toggle('hidden');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.add('hidden');
                    overlay.classList.add('hidden');
                });
            }

            window.addEventListener('resize', function() {
                if (window.innerWidth > 768) {
                    sidebar.classList.remove('hidden');
                    if (overlay) {
                        overlay.classList.add('hidden');
                    }
                } else {
                    sidebar.classList.add('hidden');
                }
                setChatPosition();
            });

            // Floating chat logic
            function isMobile() {
                return window.innerWidth <= 768;
            }

            function setChatPosition() {
                if (isMobile()) {
                    floatingChatContainer.classList.remove('desktop');
                    floatingChatContainer.classList.add('mobile');
                    chatBubble.style.left = '0';
                    chatBubble.style.right = 'auto';
                } else {
                    floatingChatContainer.classList.remove('mobile');
                    floatingChatContainer.classList.add('desktop');
                    chatBubble.style.right = '0';
                    chatBubble.style.left = 'auto';
                }
            }

            floatingChatAvatarBtn.addEventListener('click', function() {
                chatBubble.classList.toggle('show');
            });

            function addMessage(message, isUser) {
                const messageElement = document.createElement('p');
                messageElement.textContent = message;
                messageElement.classList.add(isUser ? 'chat-message-user' : 'chat-message-ai');
                chatBubbleContent.appendChild(messageElement);
                chatBubbleContent.scrollTop = chatBubbleContent.scrollHeight;
            }

            async function sendMessage() {
                const userMessage = chatInput.value.trim();
                if (userMessage === '') {
                    return;
                }

                addMessage(userMessage, true);
                chatInput.value = '';

                addMessage('Thinking...', false);

                const API_KEY = 'AIzaSyB_7Uj-0FLFYq1YiE0RL0Jxy8G5vLR_6NU'; // WARNING: This is INSECURE!
                const API_URL =
                    `https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key=${API_KEY}`;


                try {
                    const response = await fetch(API_URL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            contents: [{
                                parts: [{
                                    text: `
                            Kamu adalah Sejenak, seorang chatbot yang berfungsi sebagai pelayan user yang mampir ke website sejenak.
                            Kamu ramah, hangat, dan sangat suportif. Kamu paham tentang psikologi, kesehatan mental, dan berbagai isu yang dihadapi Gen Z.
                            Gunakan bahasa Indonesia yang santai, seperti chat dengan teman sebaya.
                            Hindari jawaban yang terlalu formal, kaku, atau seperti robot. kamu punya pengetahuan detail tentang sistem aplikasi sejenak yaitu : Sejenak adalah aplikasi kesehatan
                             mental yang dirancang untuk membantu individu yang sedang berada di bawah tekanan agar dapat mengelola emosi, stres, dan kecemasan dengan lebih sehat. Melalui fitur
                              jurnal harian, pengguna dapat mengekspresikan perasaan dan melakukan refleksi diri, sementara mood tracker membantu memantau suasana hati sehari-hari agar pola
                               emosional dapat terlihat secara jangka panjang. Aplikasi ini juga menyediakan challenge kesehatan mental yang mendorong kebiasaan positif seperti meditasi singkat atau latihan rasa syukur, serta exercise berupa aktivitas relaksasi dan audio meditasi yang menenangkan. Untuk menciptakan rasa kebersamaan, tersedia circle atau komunitas kecil sebagai ruang berbagi dan saling mendukung, ditambah dengan fitur post, komentar, balasan, dan like yang memungkinkan interaksi sosial yang sehat. Pengguna juga dapat berkomunikasi secara pribadi melalui pesan langsung, mengikuti sesi terapi atau latihan khusus, dan bagi yang membutuhkan layanan profesional, aplikasi ini mendukung proposal layanan serta transaksi untuk konseling premium. Semua fitur ini diatur melalui sistem role dan user management, sehingga peran pengguna—baik sebagai anggota komunitas, admin, maupun konselor—dapat berjalan sesuai fungsinya. Dengan ekosistem ini, Sejenak menjadi ruang aman dan suportif bagi setiap orang untuk beristirahat sejenak, menguatkan diri, dan membangun kesehatan mental yang lebih baik.,
                               untuk menu profile, journal,komunitas,history,post, journal, dashboard dan logout ada di samping kiri dan jika di mobile ada di humberger menu diatas.
                            Contoh gaya bicara: "gimana, udah enakan?", "spill dong ceritanya", "santai aja yaa", "semangat!", dll.,kamu hanya membalas chat dengan singkat ga sampe 1 paragraf
                            Tanggapi pesan ini dengan persona tersebut:

                            ${userMessage}
                        `
                                }]
                            }]
                        })
                    });

                    if (!response.ok) {
                        throw new Error(`API response error: ${response.status} ${response.statusText}`);
                    }

                    const data = await response.json();

                    const messages = chatBubbleContent.querySelectorAll('p');
                    messages[messages.length - 1].remove();

                    if (data.candidates && data.candidates[0] && data.candidates[0].content && data.candidates[
                            0].content.parts && data.candidates[0].content.parts[0]) {
                        const aiResponse = data.candidates[0].content.parts[0].text;
                        addMessage(aiResponse, false);
                    } else {
                        addMessage('Sorry, I couldn\'t generate a response.', false);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    const messages = chatBubbleContent.querySelectorAll('p');
                    messages[messages.length - 1].remove();
                    addMessage('An error occurred. Please try again later.', false);
                }
            }

            chatSendBtn.addEventListener('click', sendMessage);
            chatInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    sendMessage();
                }
            });

            // Initialize chat position
            setChatPosition();
        });
    </script>
    <script>
const chatContainer = document.getElementById('floating-chat-container');
const avatarBtn = document.getElementById('floating-chat-avatar-btn');
const chatBubble = document.getElementById('chat-bubble');

let isDragging = false;
let offsetX = 0;
let offsetY = 0;

function startDrag(x, y) {
    isDragging = true;
    avatarBtn.style.cursor = 'grabbing';
    const rect = chatContainer.getBoundingClientRect();
    offsetX = x - rect.left;
    offsetY = y - rect.top;
}

function doDrag(x, y) {
    if (!isDragging) return;

    let left = x - offsetX;
    let top = y - offsetY;

    const windowWidth = window.innerWidth;
    const windowHeight = window.innerHeight;
    const avatarWidth = avatarBtn.offsetWidth;
    const avatarHeight = avatarBtn.offsetHeight;

    // Batas layar
    left = Math.min(Math.max(0, left), windowWidth - avatarWidth);
    top = Math.min(Math.max(0, top), windowHeight - avatarHeight);

    chatContainer.style.left = left + 'px';
    chatContainer.style.top = top + 'px';

    // --- Posisi bubble ---
    const bubbleWidth = chatBubble.offsetWidth;
    const bubbleHeight = chatBubble.offsetHeight;

    let bubbleLeft, bubbleTop;

    // Kanan / kiri
    if (left + avatarWidth + bubbleWidth + 10 > windowWidth) {
        bubbleLeft = left - bubbleWidth - 10;
    } else {
        bubbleLeft = left + avatarWidth + 10;
    }

    // Atas / bawah
    if (top < 20) {
        bubbleTop = top + avatarHeight + 10; // di bawah avatar
    } else if (top + avatarHeight + bubbleHeight + 20 > windowHeight) {
        bubbleTop = top - bubbleHeight - 10; // di atas avatar
    } else {
        bubbleTop = top;
    }

    chatBubble.style.left = bubbleLeft + 'px';
    chatBubble.style.top = bubbleTop + 'px';
}

function endDrag() {
    isDragging = false;
    avatarBtn.style.cursor = 'grab';
}

// 🖱️ Mouse Events
avatarBtn.addEventListener('mousedown', (e) => startDrag(e.clientX, e.clientY));
document.addEventListener('mousemove', (e) => doDrag(e.clientX, e.clientY));
document.addEventListener('mouseup', endDrag);

// 📱 Touch Events
avatarBtn.addEventListener('touchstart', (e) => {
    const touch = e.touches[0];
    startDrag(touch.clientX, touch.clientY);
}, { passive: true });

document.addEventListener('touchmove', (e) => {
    const touch = e.touches[0];
    doDrag(touch.clientX, touch.clientY);
}, { passive: true });

document.addEventListener('touchend', endDrag);
</script>
    @yield('script')
    @stack('scripts')
</body>

</html>