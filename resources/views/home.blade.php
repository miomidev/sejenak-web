    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">

        <!-- SEO Meta Tags -->
        <meta name="description" content="Sejenak adalah platform yang membantu Anda berefleksi dan terhubung dengan orang lain untuk kesejahteraan emosional. Mulailah perjalanan Anda menuju kesehatan mental di sini.">
        <meta name="keywords" content="kesehatan mental, kesejahteraan emosional, refleksi, koneksi, Sejenak, platform perawatan diri, kesejahteraan, kesehatan mental, terapi">
        <meta name="robots" content="index, follow">

        <!-- Open Graph Tags for better social sharing -->
        <meta property="og:title" content="Sejenak - Space For Everybody">
        <meta property="og:description" content="Sejenak adalah platform yang membantu Anda berefleksi dan terhubung dengan orang lain untuk kesejahteraan emosional. Mulailah perjalanan Anda menuju kesehatan mental di sini.">
        <meta property="og:image" content="/img/icon3.png">
        <meta property="og:url" content="https://www.sejenak.miomidev.com">

        <title>Sejenak - Spacx`e For Everybody</title>
        <link rel="icon" href="/img/icon3.png">
        <style>
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
                transition: 0.2s linear;
                list-style: none;
                font-style: none;
                box-sizing: border-box;

                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: flex-start;
                padding: 2px 10px 4px;

                border: 2px solid var(--black)00;
                box-shadow: 3px 5px 0px var(--black)00;
                border-radius: 10px;
                flex: none;
                order: 0;
                flex-grow: 0;
                transition: 0.5s all linear;
                -webkit-transition: 0.5s all linear;
                -moz-transition: 0.5s all linear;
                -ms-transition: 0.5s all linear;
                -o-transition: 0.5s all linear;
            }

            .nav-btn a {
                transition: 0.1s linear;
                text-decoration: none;
                color: var(--dark);
                font-family: 'Exo 2';
                font-style: normal;
                font-weight: 700;
                font-size: 20px;
                line-height: 24px;
                letter-spacing: 0.05em;
            }

            .nav-btn:hover {
                list-style: none;
                font-style: none;
                box-sizing: border-box;

                display: flex;
                flex-direction: row;
                justify-content: center;
                align-items: flex-start;
                background: var(--secondary);
                box-shadow: 3px 5px 0px var(--black);
                transform: translate(-5px, -5px);
            }

            .nav-btn:hover a {
                text-decoration: none;
                color: var(--white);
                font-family: 'Exo 2';
                font-style: normal;
                font-weight: 700;
                font-size: 20px;
                line-height: 24px;
                letter-spacing: 0.05em;
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
            }

            .nav-btn-mobile a {
                text-decoration: none;
                color: #080330;
                font-family: 'Exo 2';
                font-weight: 700;
                font-size: 18px;
                display: block;
                width: 100%;
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
            }

            /* Responsive adjustments */
            @media (max-width: 900px) {
                .desktop-nav {
                    display: none;
                }

                .mobile-toggle {
                    display: block;
                }

                .nav-btn {
                    padding: 2px 2px 4px;
                    background-color: white;
                }

                .nav-btn a {
                    font-size: 0.8rem;
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

            /* Untuk Chrome, Edge, Safari */
            *::-webkit-scrollbar {
                display: none;
            }

            /* Untuk Firefox */
            * {
                scrollbar-width: none;
                /* sembunyikan scrollbar */
                -ms-overflow-style: none;
                /* untuk IE dan Edge lama */
            }

        </style>
        <script>
            tailwind.config = {
                theme: {
                    extend: {
                        colors: {
                            purple: '#876582'
                            , dark: '#080330'
                            , white: '#F7F7F7'
                            , stroke: '#000000'
                            , orange: '#FF6600'
                            , black: '#080330'
                            , light: '#fff'
                            , primary: '#8FD14F'
                            , secondary: '#604CC3'
                            , accent: '#FF6600'
                        , }
                        , fontFamily: {
                            'exo': ['Exo 2', 'sans-serif']
                            , 'lexend': ['Lexend', 'sans-serif']
                        , }
                        ,
                        boxShadow: {
                        'border-offset': '3px 4px 0 #080330'
                        , 'border-offset-lg': '5px 7px 0 #080330'
                        , 'border-offset-accent': '3px 4px 0 #8FD14F'
                    , }
                    }
                }
            }

        </script>
        <script src="https://cdn.tailwindcss.com"></script>
        <link href="https://fonts.googleapis.com/css2?family=Exo+2:wght@400;700&display=swap" rel="stylesheet">

        
    </head>

    <body class="bg-white font-exo flex flex-col items-center justify-center w-screen overflow-x-hidden no-scrollbar">
        {{-- @include('layouts.component.loading') --}}

        <!-- Navigation -->
        <nav class="bg-white h-[70px] w-[90%] flex justify-between gap-4 items-center px-4 relative z-[100]">
            <!-- Logo -->
            <img src="{{ asset('assets/icon/sejenak_logo_text.svg') }}" alt="Logo" class="h-[70%] aspect-auto min-w-[150px]">

            <!-- Desktop Navigation -->
            <ul class=" w-[40%] min-w-[300px] desktop-nav">
                <li class="nav-btn shadow-border-offset"><a href="#second-layer">About</a></li>
                <li class="nav-btn"><a href="#third-layer">Feature</a></li>
                <li class="nav-btn"><a href="#fourth-layer">Pricing</a></li>
                <li class="nav-btn"><a href="{{ route('login') }}">Get started</a></li>
            </ul>

            <!-- Mobile Toggle Button -->
            <div class="mobile-toggle text-3xl font-bold cursor-pointer" id="mobileToggle">≡</div>

            <!-- Mobile Navigation -->
            <div class="mobile-menu" id="mobileMenu">
                <ul class="flex flex-col">
                    <li class="nav-btn-mobile"><a href="#second-layer">About</a></li>
                    <li class="nav-btn-mobile"><a href="#third-layer">Feature</a></li>
                    <li class="nav-btn-mobile"><a href="#fourth-layer">Pricing</a></li>
                    <li class="nav-btn-mobile"><a href="{{ route('login') }}">Get started</a></li>
                </ul>
            </div>
        </nav>

        

        <section id="foot"
            class="w-full bg-white z-12 p-8 flex flex-col md:flex-row justify-evenly gap-5 mt-8">
            <div class="company">
                <li class="font-bold list-none">Company</li>
                <ul class="list-none">
                    <li><a href="">About us</a></li>
                    <li><a href="">Careers</a></li>
                    <li><a href="">Security</a></li>
                    <li><a href="">Status</a></li>
                    <li><a href="">Term & Privacy</a></li>
                </ul>
            </div>
            <div class="download">
                <li class="font-bold list-none">Download</li>
                <ul class="list-none">
                    <li><a href="">IOS & Android</a></li>
                    <li><a href="">Mac & Windows</a></li>
                </ul>
            </div>
            <div class="resource">
                <li class="font-bold list-none">Resource</li>
                <ul class="list-none">
                    <li><a href="">Help & center</a></li>
                    <li><a href="">Pricing</a></li>
                    <li><a href="">Blog</a></li>
                    <li><a href="">Community</a></li>
                    <li><a href="">Affiliates</a></li>
                </ul>
            </div>
            <div class="help-us">
                <li class="font-bold list-none">Help Us</li>
                <ul class="list-none">
                    <li><a href="">Donate</a></li>
                </ul>
            </div>
            <div id="foot-picture" class="relative w-64 h-48 bg-gray-200 rounded-md">
                </div>
        </section>

        <script>
            // Hide loading screen when page is fully loaded
            window.addEventListener('load', function() {
                document.getElementById('loading').style.display = 'none';
            });

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
    </body>
    </html>
