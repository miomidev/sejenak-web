<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Oops! Terjadi Kesalahan - Sejenak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #F5F3EB; /* secondary.light */
            color: #1C1532; /* accent.DEFAULT */
            overflow: hidden; /* Mencegah scrolling */
            height: 100vh;
        }

        /* KEYFRAMES UNTUK ANIMASI */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes background-scrolling-left {
            from { background-position: 0 0; }
            to { background-position: -100% 0; }
        }

        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }

        @keyframes rotate-slow {
            0% { transform: rotate(0deg); }
            20% { transform: rotate(-1deg); }
            40% { transform: rotate(1.5deg); }
            60% { transform: rotate(-1.5deg); }
            80% { transform: rotate(1deg); }
            100% { transform: rotate(0deg); }
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
            20%, 40%, 60%, 80% { transform: translateX(5px); }
        }

        /* KELAS ANIMASI */
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-float {
            animation: float 4s ease-in-out infinite;
        }

        .animate-rotate-slow {
            animation: rotate-slow 4s ease-in-out infinite alternate;
            transform-origin: center center;
        }

        .animate-shake {
            animation: shake 0.5s ease-in-out;
        }

        /* GAYA KHUSUS DENGAN WARNA BARU */
        .bg-primary {
            background-color: #97C200; /* primary.DEFAULT */
        }
        
        .bg-primary-light {
            background-color: #B8E356; /* primary.light */
        }
        
        .bg-primary-dark {
            background-color: #7AA000; /* primary.dark */
        }

        .bg-secondary {
            background-color: #DCD489; /* secondary.DEFAULT */
        }
        
        .bg-secondary-light {
            background-color: #F5F3EB; /* secondary.light */
        }
        
        .bg-secondary-dark {
            background-color: #D6D2C3; /* secondary.dark */
        }

        .bg-accent {
            background-color: #1C1532; /* accent.DEFAULT */
        }
        
        .bg-accent-hover {
            background-color: #2B2345; /* accent.hover */
        }

        .text-primary {
            color: #97C200; /* primary.DEFAULT */
        }
        
        .text-accent {
            color: #1C1532; /* accent.DEFAULT */
        }
        
        .text-black {
            color: #080330; /* black */
        }
        
        .text-white {
            color: #FFFFFF; /* white */
        }
        
        .text-success {
            color: #A3D900; /* success */
        }
        
        .text-warning {
            color: #FFCE00; /* warning */
        }

        .border-black {
            border-color: #080330; /* black */
        }
        
        .border-primary {
            border-color: #97C200; /* primary.DEFAULT */
        }

        .rounded-playful {
            border-radius: 20px;
        }

        .rounded-playful-md {
            border-radius: 16px;
        }

        .shadow-border-offset {
            box-shadow: 4px 4px 0 #080330;
        }
        
        .separator-scrolling-bg {
            animation: background-scrolling-left 20s linear infinite;
            will-change: background-position;
        }

        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }

        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        .nav-btn {
            transition: all 0.3s ease;
        }

        .nav-btn:hover {
            transform: translateY(-3px);
            box-shadow: 5px 5px 0 #080330;
        }

        .error-illustration {
            max-width: 300px;
            margin: 0 auto;
        }

        /* Gaya tambahan untuk konsistensi dengan halaman utama */
        .chat-card {
            transition: transform 0.1s ease-out, box-shadow 0.1s ease-out;
        }

        .description-tab {
            position: relative;
            padding-bottom: 8px;
        }

        .description-tab::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 0;
            height: 3px;
            background-color: #97C200; /* primary.DEFAULT */
            transition: width 0.3s ease-in-out;
        }

        .description-tab.active,
        .description-tab:hover {
            color: #97C200; /* primary.DEFAULT */
        }

        .description-tab:hover::after,
        .description-tab.active::after {
            width: 100%;
        }
        
        /* Container utama dengan tinggi viewport dan overflow hidden */
        .main-container {
            height: 100vh;
            overflow: hidden;
        }
    </style>
</head>
<body class="flex flex-col">
    <!-- Error Content -->
    <div class="main-container flex flex-col items-center justify-center w-full overflow-x-hidden no-scrollbar z-10 bg-secondary-light">

        <!-- Background elements -->
        <div class="absolute top-0 left-0 w-full h-full z-0">
            <div class="absolute top-10 left-10 w-20 h-20 rounded-full bg-primary-light opacity-30 animate-float"></div>
            <div class="absolute top-40 right-20 w-16 h-16 rounded-full bg-primary opacity-40 animate-float" style="animation-delay: 0.5s;"></div>
            <div class="absolute bottom-20 left-1/4 w-24 h-24 rounded-full bg-secondary opacity-20 animate-float" style="animation-delay: 1s;"></div>
        </div>

        {{-- Header Section --}}
        <section class="w-full py-12 text-center text-white relative z-10 px-4">
            
            <h1 class="text-6xl md:text-8xl lg:text-9xl font-extrabold text-black leading-tight mb-4 animate-rotate-slow">
                <span class="text-white bg-primary py-2 border-black shadow-border-offset rounded-playful-md px-6 rotate-3 inline-block" id="error-code">
                    404
                </span>
            </h1>
            
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-black mb-4" id="error-message">
                Halaman tidak ditemukan
            </h2>
            
            <p class="text-base md:text-lg font-medium text-black max-w-xl mx-auto mb-8">
                Sepertinya halaman yang Anda cari tidak ada. Mari kembali ke jalan yang benar.
            </p>
            
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="/" class="nav-btn inline-block py-3 px-8 rounded-full text-black font-bold bg-secondary border-2 border-black cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-[5px_5px_0_#080330] hover:bg-secondary-dark text-center">
                    <i class="fas fa-home mr-2"></i>Kembali ke Beranda
                </a>
                
                <button onclick="history.back()" class="nav-btn inline-block py-3 px-8 rounded-full text-black font-bold bg-secondary border-2 border-black cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-[5px_5px_0_#080330] hover:bg-secondary-dark text-center">
                    <i class="fas fa-arrow-left mr-2"></i>Kembali Sebelumnya
                </button>
            </div>
        </section>

        

    <script>
        // Fungsi untuk mendapatkan parameter dari URL
        function getQueryParam(name) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(name);
        }

        // Mengatur kode error dan pesan berdasarkan parameter URL
        document.addEventListener('DOMContentLoaded', function() {
            const errorCode = getQueryParam('code') || '404';
            let errorMessage = getQueryParam('message') || 'Halaman tidak ditemukan';
            
            // Decode URI component untuk menangani spasi dan karakter khusus
            errorMessage = decodeURIComponent(errorMessage);
            
            // Pemetaan pesan error berdasarkan kode
            const errorMessages = {
                '404': 'Halaman tidak ditemukan',
                '403': 'Akses ditolak',
                '500': 'Terjadi kesalahan pada server',
                '503': 'Layanan tidak tersedia'
            };
            
            // Jika message tidak disediakan, gunakan pesan default berdasarkan kode
            if (!getQueryParam('message') && errorMessages[errorCode]) {
                errorMessage = errorMessages[errorCode];
            }
            
            document.getElementById('error-code').textContent = errorCode;
            document.getElementById('error-message').textContent = errorMessage;
            
            // Animasi ilustrasi error
            const illustration = document.querySelector('.error-illustration');
            
            // Ulangi animasi shake setiap 5 detik
            setInterval(() => {
                illustration.classList.add('animate-shake');
                setTimeout(() => {
                    illustration.classList.remove('animate-shake');
                }, 500);
            }, 5000);
            
            // Mencegah scrolling dengan keyboard
            window.addEventListener('keydown', function(e) {
                if ([32, 37, 38, 39, 40].indexOf(e.keyCode) > -1) {
                    e.preventDefault();
                }
            }, false);
        });
        
        // Mencegah scrolling dengan mouse wheel dan touch
        document.addEventListener('wheel', function(e) {
            e.preventDefault();
        }, { passive: false });
        
        document.addEventListener('touchmove', function(e) {
            e.preventDefault();
        }, { passive: false });
    </script>
</body>
</html>