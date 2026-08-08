<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sejenak - @yield('title')</title>

    {{-- Script & Styles (Sama seperti layout admin untuk konsistensi) --}}
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">
    
    {{-- Fonts & Custom CSS --}}
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Lexend:wght@100..900&display=swap');
        body { font-family: 'Lexend', sans-serif; }
    </style>

    {{-- Tailwind Config (Sama seperti layout admin untuk konsistensi) --}}
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#8FD14F', secondary: '#604CC3', dark: '#080330',
                        light: '#ffffff', white: '#f7f7f7', stroke: '#000000',
                        purple: '#876582', orange: '#FF6600', black: '#080330',
                    },
                    fontFamily: { lexend: ['Lexend', 'sans-serif'], exo2: ['exo-2', 'sans-serif'] },
                    boxShadow: { 'border-offset': '3px 4px 0 #080330', 'border-offset-lg': '5px 7px 0 #080330' },
                    borderRadius: { 'playful-sm': '12px', 'playful-md': '18px', 'playful-lg': '24px', 'playful-sm-inner': '9px' },
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
    
    @stack('styles')
</head>

<body class="bg-gray-100 min-h-screen">
    <div class="flex flex-col min-h-screen">
        <header class="bg-white border-b-2 border-dark shadow-sm sticky top-0 z-30">
            <div class="container mx-auto px-6 py-3">
                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <img src="{{ asset('assets/icon/logo.svg') }}" class="w-8 h-8 mr-2">
                        <span class="text-xl font-bold text-dark hidden sm:block">Panel Konselor</span>
                    </div>

                    <nav class="hidden md:flex items-center space-x-6">
                        <a href="{{ route('konselor.dashboard') }}" class="font-semibold text-dark hover:text-primary transition-colors">Dashboard</a>
                        <a href="#" class="font-semibold text-dark hover:text-primary transition-colors">Jadwal Sesi</a>
                        <a href="#" class="font-semibold text-dark hover:text-primary transition-colors">Klien Saya</a>
                        <a href="{{ route('konselor.audios') }}" class="font-semibold text-dark hover:text-primary transition-colors">Audio</a>
                        <a href="#" class="font-semibold text-dark hover:text-primary transition-colors">Pesan</a>
                    </nav>

                    <div class="flex items-center space-x-4">
                        <div class="relative">
                            <button id="profile-button" class="flex items-center focus:outline-none">
                                <img class="h-9 w-9 rounded-full object-cover border-2 border-dark" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=8FD14F&color=080330" alt="Avatar">
                            </button>
                            <div id="profile-menu" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-playful-sm border-2 border-dark shadow-border-offset py-1 z-40">
                                <a href="{{ route('user.profiles') }}" class="block px-4 py-2 text-sm text-dark hover:bg-gray-100">Profil Saya</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                                </form>
                            </div>
                        </div>
                        <button id="mobile-menu-button" class="md:hidden text-dark focus:outline-none">
                            <i class="fas fa-bars text-2xl"></i>
                        </button>
                    </div>
                </div>

                <div id="mobile-menu" class="hidden md:hidden mt-4">
                    <a href="{{ route('konselor.dashboard') }}" class="block py-2 px-4 text-sm font-semibold text-dark hover:bg-gray-100 rounded-playful-sm">Dashboard</a>
                    <a href="#" class="block py-2 px-4 text-sm font-semibold text-dark hover:bg-gray-100 rounded-playful-sm">Jadwal Sesi</a>
                    <a href="#" class="block py-2 px-4 text-sm font-semibold text-dark hover:bg-gray-100 rounded-playful-sm">Klien Saya</a>
                    <a href="{{ route('konselor.audios') }}" class="block py-2 px-4 text-sm font-semibold text-dark hover:bg-gray-100 rounded-playful-sm">Audio</a>
                    <a href="#" class="block py-2 px-4 text-sm font-semibold text-dark hover:bg-gray-100 rounded-playful-sm">Pesan</a>
                </div>
            </div>
        </header>

        <main class="flex-1 bg-white">
            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profileButton = document.getElementById('profile-button');
            const profileMenu = document.getElementById('profile-menu');
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');

            if (profileButton) {
                profileButton.addEventListener('click', () => {
                    profileMenu.classList.toggle('hidden');
                });
            }

            if (mobileMenuButton) {
                mobileMenuButton.addEventListener('click', () => {
                    mobileMenu.classList.toggle('hidden');
                });
            }

            // Close dropdown when clicking outside
            document.addEventListener('click', function(event) {
                if (profileButton && !profileButton.contains(event.target) && !profileMenu.contains(event.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
        });
    </script>
    @stack('scripts')
</body>
</html>