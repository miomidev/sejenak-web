@extends('layouts.guest')
@section('title', 'Meet Our Developers')

@section('content')
<div class="flex flex-col items-center h-full w-full overflow-x-hidden no-scrollbar z-10 bg-primary">

    {{-- Header Section --}}
    <section class="w-full py-20 text-center text-white">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-black leading-tight mb-4 animate-fade-in-up">
            Tim di balik <span class="text-white bg-accent py-2 border-black shadow-border-offset rounded-playful-md px-6 rotate-3 inline-block">Sejenak</span>
        </h1>
        <p class="text-lg md:text-xl font-medium text-black max-w-2xl mx-auto animate-fade-in">
            Kami adalah sekelompok pengembang yang bersemangat untuk menciptakan ruang aman bagi refleksi dan kesejahteraan emosional.
        </p>
    </section>

    {{-- SEPARATOR 1: SCROLLING KE KIRI --}}
    <div class="separator-scrolling-bg w-full h-14 bg-[url('assets/component/buy_now_banner.svg')] bg-repeat-x bg-[length:auto_120%] bg-[position:0_-4px] relative -top-7 -rotate-2 bg-white border-[6px] border-black">
    </div>

    {{-- Developer Cards Section --}}
    <section id="developers" class="w-full flex flex-col items-center justify-center py-20 px-4 sm:px-8 bg-gray-50">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-12 max-w-6xl w-full">
            
            {{-- Developer 1 Card --}}
            <div class="developer-card p-6 bg-white border-2 border-black rounded-playful-md shadow-card-hover transform transition-transform duration-300 hover:scale-105 hover:rotate-2">
                <img src="{{ asset('assets/component/dev1.svg') }}" alt="Developer 1" class="w-32 h-32 mx-auto mb-4 rounded-full border-2 border-black object-cover shadow-border-offset">
                <h3 class="text-2xl font-bold text-black mb-1">Developer 1</h3>
                <p class="text-sm font-semibold text-gray-600 mb-4">Founder & Lead Engineer</p>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Berfokus pada pengembangan backend dan infrastruktur, memastikan platform berjalan dengan lancar dan aman.
                </p>
            </div>

            {{-- Developer 2 Card --}}
            <div class="developer-card p-6 bg-white border-2 border-black rounded-playful-md shadow-card-hover transform transition-transform duration-300 hover:scale-105 hover:-rotate-2">
                <img src="{{ asset('assets/component/dev2.svg') }}" alt="Developer 2" class="w-32 h-32 mx-auto mb-4 rounded-full border-2 border-black object-cover shadow-border-offset">
                <h3 class="text-2xl font-bold text-black mb-1">Developer 2</h3>
                <p class="text-sm font-semibold text-gray-600 mb-4">AI & Frontend Specialist</p>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Menciptakan antarmuka yang intuitif dan mengintegrasikan model AI untuk pengalaman yang lebih baik.
                </p>
            </div>

            {{-- Developer 3 Card --}}
            <div class="developer-card p-6 bg-white border-2 border-black rounded-playful-md shadow-card-hover transform transition-transform duration-300 hover:scale-105 hover:rotate-2">
                <img src="{{ asset('assets/component/dev3.svg') }}" alt="Developer 3" class="w-32 h-32 mx-auto mb-4 rounded-full border-2 border-black object-cover shadow-border-offset">
                <h3 class="text-2xl font-bold text-black mb-1">Developer 3</h3>
                <p class="text-sm font-semibold text-gray-600 mb-4">UI/UX Designer</p>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Bertanggung jawab untuk merancang tampilan yang ramah pengguna dan estetika visual yang menenangkan.
                </p>
            </div>

        </div>
    </section>

    {{-- SEPARATOR 2: SCROLLING KE KANAN --}}
    <div class="separator-scrolling-bg-right w-full h-14 bg-[url('assets/component/buy_now_banner.svg')] bg-repeat-x bg-[length:auto_120%] bg-[position:0_-4px] relative -top-7 rotate-2 bg-white border-[6px] border-black">
    </div>

    {{-- CTA Section --}}
    <section id="cta-section" class="w-full flex-1 flex justify-center py-20 bg-primary">
        <div class="w-full md:w-[70%] text-center p-8">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-black mb-4">
                Bergabunglah dengan Misi Kami!
            </h2>
            <p class="text-base md:text-lg text-black font-medium mb-8 max-w-xl mx-auto">
                Tertarik untuk berkontribusi? Hubungi kami untuk kesempatan kolaborasi.
            </p>
            <a href="#" class="nav-btn py-3 px-8 rounded-full text-white font-bold bg-accent border-2 border-black cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-[5px_5px_0_#080330] hover:bg-secondary">
                Hubungi Kami
            </a>
        </div>
    </section>

</div>
@endsection

@section('script')
<script>
    // Pastikan script yang diperlukan ada
</script>

<style>
    /* KEYFRAMES UNTUK SCROLLING BACKGROUND */
    @keyframes background-scrolling-left {
        from {
            background-position: 0 0;
        }
        to {
            background-position: -100% 0;
        }
    }

    @keyframes background-scrolling-right {
        from {
            background-position: -100% 0;
        }
        to {
            background-position: 0 0;
        }
    }

    /* KEYFRAMES UNTUK ANIMASI GOYANG ROTASI */
    @keyframes rotate-slow {
      0% { transform: rotate(0deg); }
      20% { transform: rotate(-1deg); }
      40% { transform: rotate(1.5deg); }
      60% { transform: rotate(-1.5deg); }
      80% { transform: rotate(1deg); }
      100% { transform: rotate(0deg); }
    }

    /* KELAS CSS YANG MENGGUNAKAN KEYFRAMES */
    .separator-scrolling-bg {
        animation: background-scrolling-left 20s linear infinite;
        will-change: background-position;
    }

    .separator-scrolling-bg-right {
        animation: background-scrolling-right 20s linear infinite;
        will-change: background-position;
    }

    .animate-rotate-slow {
        animation: rotate-slow 4s ease-in-out infinite alternate;
        transform-origin: center center;
    }

    /* GAYA LAINNYA */
    .rounded-playful {
        border-radius: 20px;
    }

    .shadow-border-offset {
        box-shadow: 4px 4px 0 #080330;
    }
    
    .shadow-card-hover {
        box-shadow: 8px 8px 0 #080330;
    }

    .developer-card:hover .shadow-card-hover {
        box-shadow: 12px 12px 0 #080330;
    }
</style>
@endsection