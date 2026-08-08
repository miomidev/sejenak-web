<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejenak - @yield('title')</title>

    {{-- Script & Styles --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    {{-- Fonts & Custom CSS --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Lexend:wght@100..900&display=swap');

        body {
            font-family: 'Lexend', sans-serif;
        }

        /* Scrollbar styling for a better look in admin panel */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #555;
        }
    </style>

    {{-- Tailwind Config --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8FD14F',
                        secondary: '#604CC3',
                        dark: '#080330',
                        light: '#ffffff',
                        white: '#f7f7f7',
                        stroke: '#000000',
                        purple: '#876582',
                        orange: '#FF6600',
                        black: '#080330',
                    },
                    fontFamily: {
                        lexend: ['Lexend', 'sans-serif'],
                        exo2: ['exo-2', 'sans-serif']
                    },
                    boxShadow: {
                        'border-offset': '3px 4px 0 #080330',
                        'border-offset-lg': '5px 7px 0 #080330',
                    },
                    borderRadius: {
                        'playful-sm': '12px',
                        'playful-md': '18px',
                        'playful-lg': '24px',
                        'playful-sm-inner': '9px',
                    },
                    fontSize: {
                         h1: ['2.5rem', { lineHeight: '3rem', fontWeight: '700' }],
                         h2: ['2rem', { lineHeight: '2.5rem', fontWeight: '700' }],
                         h3: ['1.75rem', { lineHeight: '2.25rem', fontWeight: '600' }],
                         h4: ['1.5rem', { lineHeight: '2rem', fontWeight: '600' }],
                         h5: ['1.25rem', { lineHeight: '1.75rem', fontWeight: '500' }],
                         h6: ['1rem', { lineHeight: '1.5rem', fontWeight: '500' }],
                    },
                },
            },
        };
    </script>
    
    {{-- Additional styles per page --}}
    @stack('styles')
</head>

<body class="bg-gray-100 flex min-h-screen">

    <div id="overlay" class="fixed inset-0 bg-black bg-opacity-60 z-30 hidden md:hidden"></div>

    <aside id="sidebar" class="bg-dark text-white w-64 min-h-screen flex-shrink-0 p-4 flex flex-col fixed md:static transform -translate-x-full md:translate-x-0 transition-transform duration-300 z-40">
        <div class="flex items-center justify-center pb-4 border-b border-gray-700 mb-6">
            <img src="{{ asset('assets/icon/sejenak-header.svg') }}" class="w-10 h-10 mr-2 filter invert">
            <span class="text-xl font-bold">Admin Sejenak</span>
        </div>

        <nav class="flex-grow">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center px-4 py-3 rounded-playful-sm ... {{ request()->routeIs('admin.dashboard') ? 'bg-secondary' : '' }}">
                <i class="fas fa-tachometer-alt w-6 text-center"></i>
                <span class="ml-4 font-semibold">Dashboard</span>
            </a>
            <a href="{{ route('admin.users') }}" class="flex items-center mt-3 px-4 py-3 rounded-playful-sm transition-colors duration-200 hover:bg-secondary {{ request()->routeIs('admin.users*') ? 'bg-secondary' : '' }}">
                <i class="fas fa-users w-6 text-center"></i>
                <span class="ml-4 font-semibold">Pengguna</span>
            </a>
            <a href="{{ route('admin.proposals') }}" class="flex items-center mt-3 px-4 py-3 rounded-playful-sm transition-colors duration-200 hover:bg-secondary {{ request()->routeIs('admin.proposals*') ? 'bg-secondary' : '' }}">
                <i class="fas fa-file-alt w-6 text-center"></i>
                <span class="ml-4 font-semibold">Proposal Konselor</span>
            </a>
            <div>
                <button type"button" id="moderation-menu-button" class="flex items-center justify-between w-full mt-3 px-4 py-3 rounded-playful-sm transition-colors duration-200 hover:bg-secondary {{ request()->routeIs('admin.moderation.*') ? 'bg-secondary' : '' }}">
                    <span class="flex items-center">
                        <i class="fas fa-shield-alt w-6 text-center"></i>
                        <span class="ml-4 font-semibold">Moderasi</span>
                    </span>
                    <i id="moderation-chevron" class="fas fa-chevron-down text-xs transition-transform"></i>
                </button>

                <div id="moderation-submenu" class="hidden mt-2 space-y-2 pl-8">
                    <a href="{{ route('admin.moderation.posts') }}" class="block px-4 py-2 text-sm font-semibold rounded-playful-sm hover:bg-secondary {{ request()->routeIs('admin.moderation.posts') ? 'bg-secondary' : '' }}">
                        Postingan
                    </a>
                    <a href="{{ route('admin.moderation.comments') }}" class="block px-4 py-2 text-sm font-semibold rounded-playful-sm hover:bg-secondary {{ request()->routeIs('admin.moderation.comments') ? 'bg-secondary' : '' }}">
                        Komentar
                    </a>
                </div>
            </div>
            <a href="{{ route('admin.transactions') }}" class="flex items-center mt-3 px-4 py-3 rounded-playful-sm transition-colors duration-200 hover:bg-secondary {{ request()->routeIs('admin.transactions*') ? 'bg-secondary' : '' }}">
                <i class="fas fa-cart-plus w-6 text-center"></i>
                <span class="ml-4 font-semibold">Transaksi</span>
            </a>
            <a href="{{ route('admin.audios') }}" class="flex items-center mt-3 px-4 py-3 rounded-playful-sm transition-colors duration-200 hover:bg-secondary {{ request()->routeIs('admin.audios*') ? 'bg-secondary' : '' }}">
                <i class="fas fa-music w-6 text-center"></i>
                <span class="ml-4 font-semibold">Audio</span>
            </a>
            <a href="{{ route('admin.blog.index') }}" class="flex items-center mt-3 px-4 py-3 rounded-playful-sm transition-colors duration-200 hover:bg-secondary {{ request()->routeIs('admin.blog*') ? 'bg-secondary' : '' }}">
                <i class="fas fa-newspaper w-6 text-center"></i>
                <span class="ml-4 font-semibold">Blog</span>
            </a>
            <a href="#" class="flex items-center mt-3 px-4 py-3 rounded-playful-sm transition-colors duration-200 hover:bg-secondary">
                <i class="fas fa-chart-line w-6 text-center"></i>
                <span class="ml-4 font-semibold">Laporan</span>
            </a>
        </nav>

        <div class="pt-4 border-t border-gray-700">
            <div class="flex items-center mb-4">
                <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=8FD14F&color=080330" alt="Admin Avatar">
                <div class="ml-3">
                    <p class="font-bold text-sm">{{ Auth::user()->name }}</p>
                    <p class="text-xs text-gray-400">{{ Auth::user()->role->name ?? 'Admin' }}</p>
                </div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center text-center px-4 py-2 rounded-playful-sm bg-red-500 border-2 border-dark shadow-border-offset hover:bg-red-600 transition-colors duration-200">
                    <i class="fas fa-sign-out-alt mr-2"></i>
                    <span class="font-bold">Logout</span>
                </button>
            </form>
        </div>
    </aside>

    <div class="flex-1 flex flex-col">
        <header class="bg-white p-4 flex items-center justify-between md:hidden border-b-2 border-dark shadow-sm">
            <button id="menu-toggle" class="text-dark focus:outline-none">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <h1 class="text-xl font-bold text-dark">
                Admin Panel
            </h1>
            <div class="w-8"></div> </header>

        <main class="flex-1 overflow-y-auto bg-white">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const menuToggle = document.getElementById('menu-toggle');
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('overlay');
            const moderationButton = document.getElementById('moderation-menu-button');
            const moderationSubmenu = document.getElementById('moderation-submenu');
            const moderationChevron = document.getElementById('moderation-chevron');

            if (moderationButton) {
                // Jika halaman moderasi sedang aktif, tampilkan submenu secara default
                if (moderationSubmenu.querySelector('a.bg-secondary')) {
                    moderationSubmenu.classList.remove('hidden');
                    moderationChevron.classList.add('rotate-180');
                }

                moderationButton.addEventListener('click', () => {
                    moderationSubmenu.classList.toggle('hidden');
                    moderationChevron.classList.toggle('rotate-180');
                });
            }

            if (menuToggle) {
                menuToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');
                });
            }

            if (overlay) {
                overlay.addEventListener('click', function() {
                    sidebar.classList.add('-translate-x-full');
                    overlay.classList.add('hidden');
                });
            }
        });
    </script>
    
    {{-- Additional scripts per page --}}
    @stack('scripts')
</body>
</html>