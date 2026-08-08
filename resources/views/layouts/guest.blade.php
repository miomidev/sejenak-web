<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

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


  <!-- (tambahan opsional) canonical tag -->
  <link rel="canonical" href="https://sejenak.app" />
  
  <!-- (tambahan opsional) robots meta -->
  <meta name="robots" content="index, follow" />
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel="stylesheet">

    <title>Sejenak - @yield('title')</title>
    <link rel="icon" href="/img/icon3.png">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Exo+2:ital,wght@0,100..900;1,100..900&family=Lexend:wght@100..900&display=swap');

        /* Custom scrollbar hiding */
        .no-scrollbar::-webkit-scrollbar {
            width: 0;
            height: 0;
            display: none;
        }

        .no-scrollbar {
            scrollbar-width: none;
        }

        /* Nav button styles */
        .nav-btn {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            list-style: none;
            box-sizing: border-box;
            display: flex;
            flex-direction: row;
            justify-content: center;
            align-items: flex-start;
            padding: 2px 10px 4px;
            /* border: 2px solid #080330; */
            border-radius: 10px;
            flex: none;
            order: 0;
            flex-grow: 0;
            cursor: pointer;
        }

        .nav-btn a {
            transition: color 0.2s ease;
            text-decoration: none;
            color: #080330;
            font-family: 'Exo 2', sans-serif;
            font-style: normal;
            font-weight: 700;
            font-size: 20px;
            line-height: 24px;
            letter-spacing: 0.05em;
        }

        .nav-btn:hover {
            transform: translate(-5px, -5px);
            box-shadow: 5px 5px 0px #080330;
            background-color: #DCD489;
        }

        .nav-btn:hover a {
            color: #F7F7F7;
        }

        /* Mobile menu styles */
        .mobile-menu {
            display: none;
            position: absolute;
            top: 100%;
            left: 0;
            width: 100%;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            z-index: 999;
            border-top: 3px solid #080330;
        }

        .mobile-menu.active {
            display: block;
        }

        .nav-btn-mobile {
            padding: 15px 20px;
            border-bottom: 1px solid #f0f0f0;
            text-align: center;
            transition: background-color 0.2s ease;
        }

        .nav-btn-mobile a {
            text-decoration: none;
            color: #080330;
            font-family: 'Exo 2', sans-serif;
            font-weight: 700;
            font-size: 18px;
            display: block;
            width: 100%;
            transition: color 0.2s ease;
        }

        .nav-btn-mobile:last-child {
            border-bottom: none;
        }

        .nav-btn-mobile:hover {
            background-color: #604CC3;
        }

        .nav-btn-mobile:hover a {
            color: white;
        }

        /* Mobile toggle button */
        .mobile-toggle {
            display: none;
            cursor: pointer;
            font-size: 28px;
            font-weight: bold;
        }

        .desktop-nav {
            display: flex;
            justify-content: center;
            align-content: center;
            gap: 16px;
            /* Added gap for spacing */
        }

        /* Responsive adjustments */
        @media (max-width: 900px) {
            .desktop-nav {
                display: none;
            }

            .mobile-toggle {
                display: block;
            }
        }

        /* Loading animation */
        .loading-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #F7F7F7;
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid #604CC3;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Scrollbar hiding for various browsers */
        *::-webkit-scrollbar {
            display: none;
        }

        * {
            scrollbar-width: none;
            -ms-overflow-style: none;
        }

    </style>
    @yield('style')
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            DEFAULT: '#97C200'
                            , light: '#B8E356'
                            , dark: '#7AA000'
                        , }
                        , secondary: {
                            DEFAULT: '#DCD489'
                            , light: '#F5F3EB'
                            , dark: '#D6D2C3'
                        , }
                        , accent: {
                            DEFAULT: '#1C1532'
                            , hover: '#2B2345'
                        , }
                        , black: '#080330'
                        , white: '#FFFFFF'
                        , gray: {
                            DEFAULT: '#6B7280'
                            , light: '#9CA3AF'
                        , }
                        , success: '#A3D900'
                        , warning: '#FFCE00'
                    , }
                    , fontFamily: {
                        'exo': ['Exo 2', 'sans-serif']
                        , 'lexend': ['Lexend', 'sans-serif']
                    , }
                    , boxShadow: {
                        'border-offset': '3px 4px 0 #080330'
                        , 'border-offset-lg': '5px 7px 0 #080330'
                        , 'border-bot-shadow': '0 7px 0 #080330'
                        , 'border-offset-accent': '3px 4px 0 #8FD14F'
                    , }
                    , borderRadius: {
                        'playful-sm': '12px'
                        , 'playful-md': '18px'
                        , 'playful-lg': '24px'
                    , }
                    , fontSize: {
                        h1: ['2.5rem', {
                            lineHeight: '3rem'
                            , fontWeight: '700'
                        }]
                        , h2: ['2rem', {
                            lineHeight: '2.5rem'
                            , fontWeight: '700'
                        }]
                        , h3: ['1.75rem', {
                            lineHeight: '2.25rem'
                            , fontWeight: '600'
                        }]
                        , h4: ['1.5rem', {
                            lineHeight: '2rem'
                            , fontWeight: '600'
                        }]
                        , h5: ['1.25rem', {
                            lineHeight: '1.75rem'
                            , fontWeight: '500'
                        }]
                        , h6: ['1rem', {
                            lineHeight: '1.5rem'
                            , fontWeight: '500'
                        }]
                    , }
                }
            }
        }

    </script>
    <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="bg-white font-exo flex flex-col items-center justify-center w-screen overflow-x-hidden no-scrollbar">
    {{-- @include('layouts.component.loading') --}}

    <nav class="bg-white h-[70px] w-[90%] flex justify-between gap-4 items-center px-4 relative z-[100]">
        <img src="{{ asset('assets/icon/sejenak_logo_text.svg') }}" alt="Logo" class="h-[70%] aspect-auto min-w-[150px]">

        <ul class="w-[40%] min-w-[300px] desktop-nav">
            <li class="nav-btn"><a href="#second-layer">About</a></li>
            <li class="nav-btn"><a href="#third-layer">Feature</a></li>
            <li class="nav-btn"><a href="#fourth-layer">Pricing</a></li>
            <li class="nav-btn"><a href="{{ route('login') }}">Get started</a></li>
        </ul>

        <div class="mobile-toggle text-3xl font-bold cursor-pointer" id="mobileToggle">≡</div>

        <div class="mobile-menu" id="mobileMenu">
            <ul class="flex flex-col">
                <li class="nav-btn-mobile"><a href="#second-layer">About</a></li>
                <li class="nav-btn-mobile"><a href="#third-layer">Feature</a></li>
                <li class="nav-btn-mobile"><a href="#fourth-layer">Pricing</a></li>
                <li class="nav-btn-mobile"><a href="{{ route('login') }}">Get started</a></li>
            </ul>
        </div>
    </nav>
    <main class="bg-primary container border-[3px] border-black w-[98vw] rounded-[24px]   
        shadow-[0_0_0_10px_white] " id="main">
        <div class="sticky top-4 z-10 h-[100px] flex justify-center ">
            <div class="min-h-[50px] -mx-[3px] w-[calc(100%+5px)] h-[30px] bg-transparent 
                rounded-t-[24px] border-t-[3px] border-x-[3px] border-black 
                shadow-[0_-20px_0_20px_white]"></div>
            </div>
            <div class="container h-full relative top-[-100px] z-1">
                <div class="main-content container  w-full h-[100%]">
                    @yield('content')
                </div>
            </div>
        </main>
        <section id="foot"
            class="w-full bg-white z-12 p-8 flex flex-col md:flex-row justify-evenly gap-8 mt-8 border-t">
            
            <div class="company">
                <h3 class="font-bold text-lg mb-3">Perusahaan</h3>
                <ul class="list-none space-y-2 text-gray-600">
                    <li><a href="/tentang-kami" class="hover:text-black hover:underline">Tentang Kami</a></li>
                    <li><a href="/karir" class="hover:text-black hover:underline">Karir</a></li>
                    <li><a href="/keamanan" class="hover:text-black hover:underline">Keamanan</a></li>
                </ul>
            </div>

            <div class="legal">
                <h3 class="font-bold text-lg mb-3">Legal</h3>
                <ul class="list-none space-y-2 text-gray-600">
                    <li><a href="/syarat-dan-ketentuan" class="hover:text-black hover:underline">Syarat & Ketentuan</a></li>
                    <li><a href="/kebijakan-privasi" class="hover:text-black hover:underline">Kebijakan Privasi</a></li>
                    <li><a href="/kebijakan-pengembalian-dana" class="hover:text-black hover:underline">Kebijakan Pengembalian Dana</a></li>
                </ul>
            </div>

            <div class="resource">
                <h3 class="font-bold text-lg mb-3">Bantuan & Sumber Daya</h3>
                <ul class="list-none space-y-2 text-gray-600">
                    <li><a href="/pusat-bantuan" class="hover:text-black hover:underline">Pusat Bantuan</a></li>
                    <li><a href="/blog" class="hover:text-black hover:underline">Blog</a></li>
                    <li><a href="/komunitas" class="hover:text-black hover:underline">Komunitas</a></li>
                </ul>
            </div>

            <div class="download">
                <h3 class="font-bold text-lg mb-3">Download Aplikasi</h3>
                <ul class="list-none space-y-2 text-gray-600">
                    <li><a href="#" class="hover:text-black hover:underline">iOS & Android</a></li>
                    <li><a href="#" class="hover:text-black hover:underline">Mac & Windows</a></li>
                </ul>
            </div>

            <div id="foot-picture" class="relative w-48 h-48 flex items-center justify-center">
                <img class="w-full" src="{{ asset('assets/component/sejenak_icon_transparent.svg') }}" alt="Logo Aplikasi Sejenak">
            </div>

        </section>

    <script>
        // Mobile menu toggle functionality
        document.getElementById('mobileToggle').addEventListener('click', function() {
            const mobileMenu = document.getElementById('mobileMenu');
            mobileMenu.classList.toggle('active');

            // Change icon based on menu state
            if (mobileMenu.classList.contains('active')) {
                this.textContent = '×';
            } else {
                this.textContent = '≡';
            }
        });

        // Close mobile menu when clicking on a link
        document.querySelectorAll('.nav-btn-mobile a').forEach(link => {
            link.addEventListener('click', function() {
                document.getElementById('mobileMenu').classList.remove('active');
                document.getElementById('mobileToggle').textContent = '≡';
            });
        });

        // Close menu when clicking outside
        document.addEventListener('click', function(event) {
            const mobileMenu = document.getElementById('mobileMenu');
            const mobileToggle = document.getElementById('mobileToggle');

            if (mobileMenu.classList.contains('active') &&
                !mobileMenu.contains(event.target) &&
                !mobileToggle.contains(event.target)) {
                mobileMenu.classList.remove('active');
                mobileToggle.textContent = '≡';
            }
        });

    </script>
    @yield('script')
</body>
</html>
