@extends('layouts.guest')
@section('title', 'Safe Space for Everybody')

@section('content')
<div class="bg-white flex flex-col items-center h-full w-full overflow-x-hidden no-scrollbar z-10">
    <!-- Hero Section -->
    <section class="w-full py-12 lg:py-20 bg-primary px-4 md:px-8 border-b-3 border-black">
        <div class="max-w-7xl mx-auto flex flex-col lg:flex-row items-center justify-between gap-12">
            <!-- Left Illustration Container (Original Style) -->
            <div class="md:w-1/2 flex flex-row justify-center align-middle items-end gap-6 relative">
                <img class="h-full" src="{{ asset('assets/component/vas.svg') }}" alt="">
                <img src="{{ asset('assets/component/container.svg') }}" alt="" class="w-[150px] md:w-[250px]">
                <img id="lady_icon" src="{{ asset('assets/component/lady_icon.svg') }}" alt="" class="absolute 
                w-[150px] md:w-[250px]
           transition duration-300 ease-in-out 
           hover:translate-y-[-5px] 
           hover:shadow-xl 
           cursor-pointer"> <img class="h-full flex justify-end" src="{{ asset('assets/component/table.svg') }}" alt="">
            </div>
            
            <!-- Right Text & Action Container -->
            <div class="w-full lg:w-1/2 flex flex-col items-center lg:items-start text-center lg:text-left">
                <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-accent text-white font-extrabold text-xs tracking-wider uppercase border-2 border-black mb-4 shadow-[3px_3px_0_#080330]">
                    ✨ Safe Space For Everybody
                </span>
                <h1 class="text-3xl md:text-5xl lg:text-6xl font-extrabold text-black leading-tight tracking-tight mb-6">
                    Luangkan waktu refleksi cukup
                    <span class="text-black bg-secondary py-1 px-4 border-3 border-black shadow-[4px_4px_0_#080330] rounded-playful-md -rotate-1 inline-block my-1">
                        Sejenak
                    </span> saja
                </h1>
                <p class="text-base md:text-xl text-black/90 font-semibold mb-8 max-w-lg leading-relaxed">
                    Perjalanan menuju kesejahteraan emosional dimulai di sini.
                </p>
                <div class="flex flex-wrap justify-center lg:justify-start gap-4">
                    <a href="{{ route('login') }}" class="py-3.5 px-8 rounded-playful-md text-black font-extrabold bg-secondary border-3 border-black shadow-[5px_5px_0_#080330] hover:-translate-y-1 hover:shadow-[7px_7px_0_#080330] transition-all duration-200 cursor-pointer text-center">
                        Mulai Sekarang
                    </a>
                    <a href="#second-layer" class="py-3.5 px-8 rounded-playful-md text-white font-extrabold bg-accent border-3 border-black shadow-[5px_5px_0_#080330] hover:-translate-y-1 hover:shadow-[7px_7px_0_#080330] hover:bg-accent/90 transition-all duration-200 cursor-pointer text-center">
                        Lebih Lanjut
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section ("Second Layer") -->
    <section id="second-layer" class="w-full bg-white py-16 lg:py-24 px-4 md:px-8">
        <div class="max-w-6xl mx-auto flex flex-col lg:flex-row gap-8 items-stretch">
            <!-- Left Tabs Sidebar Card Container -->
            <div id="second-left" class="w-full lg:w-5/12 bg-white border-3 border-black rounded-playful-lg shadow-[6px_6px_0_#080330] p-6 lg:p-8 flex flex-col justify-center">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b-3 border-black">
                    <span class="w-10 h-10 rounded-full bg-primary border-2 border-black flex items-center justify-center text-lg font-bold shadow-[2px_2px_0_#080330]">💡</span>
                    <h2 class="text-2xl lg:text-3xl font-extrabold text-black">Mengenai Sejenak</h2>
                </div>
                
                <div class="flex flex-col gap-3">
                    <div id="p-1" class="description-tab p-4 rounded-playful-md border-2 border-black font-extrabold text-base md:text-lg cursor-pointer transition-all duration-200 bg-white hover:bg-secondary/40 shadow-[3px_3px_0_#080330] flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-primary border border-black"></span>
                        Apa itu Sejenak?
                    </div>
                    <div id="p-2" class="description-tab p-4 rounded-playful-md border-2 border-black font-extrabold text-base md:text-lg cursor-pointer transition-all duration-200 bg-white hover:bg-secondary/40 shadow-[3px_3px_0_#080330] flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-secondary border border-black"></span>
                        Mengapa memilih Sejenak?
                    </div>
                    <div id="p-3" class="description-tab p-4 rounded-playful-md border-2 border-black font-extrabold text-base md:text-lg cursor-pointer transition-all duration-200 bg-white hover:bg-secondary/40 shadow-[3px_3px_0_#080330] flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-accent border border-black"></span>
                        Misi Kami
                    </div>
                    <div id="p-4" class="description-tab p-4 rounded-playful-md border-2 border-black font-extrabold text-base md:text-lg cursor-pointer transition-all duration-200 bg-white hover:bg-secondary/40 shadow-[3px_3px_0_#080330] flex items-center gap-3">
                        <span class="w-3 h-3 rounded-full bg-success border border-black"></span>
                        Privasi & Keamanan
                    </div>
                </div>
            </div>

            <!-- Right Content Container Card -->
            <div id="second-right" class="w-full lg:w-7/12 bg-secondary/30 border-3 border-black rounded-playful-lg shadow-[6px_6px_0_#080330] p-6 lg:p-10 flex flex-col justify-between relative overflow-hidden">
                <div>
                    <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-white border-2 border-black text-xs font-extrabold text-black mb-6 shadow-[2px_2px_0_#080330]">
                        <span>📌</span> INFORMATION DETAIL
                    </div>
                    <p id="describe" class="font-semibold text-lg lg:text-xl text-black/90 leading-relaxed min-h-[160px] flex items-center">
                        Sejenak adalah platform yang dirancang untuk membantu kamu mengekspresikan
                        perasaan dengan cara yang aman dan nyaman. Kami memahami bahwa terkadang sulit untuk
                        mengungkapkan apa yang ada di hati, jadi kami menciptakan ruang di mana kamu bisa merenung,
                        bersantai, dan terhubung dengan orang lain.
                    </p>
                </div>
                <div class="mt-6 pt-4 border-t-2 border-black/20 text-xs font-extrabold text-black/60 flex justify-between items-center">
                    <span>Ruang Aman & Menenangkan</span>
                    <span>Sejenak Ecosystem</span>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section ("Third Layer") -->
    <section id="third-layer" class="w-full bg-primary/20 py-20 px-4 md:px-8 border-y-3 border-black">
        <div class="max-w-7xl mx-auto">
            <div class="text-center mb-14 flex flex-col items-center">
                <span class="inline-block px-4 py-1.5 rounded-full bg-primary text-black font-extrabold text-xs tracking-wider uppercase border-2 border-black mb-3 shadow-[3px_3px_0_#080330]">
                    ⚡ FITUR UNGGULAN
                </span>
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-black">
                    Segala Yang Kamu Butuhkan
                </h2>
                <p class="text-base md:text-lg text-black/80 font-semibold mt-3 max-w-xl">
                    Didesain khusus untuk membantumu mereda, merenung, dan tumbuh setiap hari.
                </p>
            </div>

            <!-- Features Card Grid Container -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 w-full">
                <!-- Feature Card 1 -->
                <div class="chat-card bg-white border-3 border-black rounded-playful-lg p-6 shadow-[5px_5px_0_#080330] flex flex-col justify-between hover:-translate-y-2 hover:shadow-[9px_9px_0_#080330] transition-all duration-300 group cursor-pointer h-full">
                    <div>
                        <div class="w-14 h-14 rounded-playful-md bg-secondary border-2 border-black flex items-center justify-center mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-[3px_3px_0_#080330]">
                            <img src="{{ asset('assets/icon/chat.svg') }}" alt="AI Chat Icon" class="w-7 h-7">
                        </div>
                        <h3 class="text-xl font-extrabold text-black mb-2">AI Chat</h3>
                        <p class="text-black/80 font-medium text-sm leading-relaxed">
                            Curhatkan apa pun ke chatbot, dan biarkan ia menyulapnya menjadi catatan harian yang personal.
                        </p>
                    </div>
                    <div class="mt-6 pt-3 border-t-2 border-black/10 text-xs font-extrabold text-primary-dark">
                        Refleksi Pintar &rarr;
                    </div>
                </div>

                <!-- Feature Card 2 -->
                <div class="chat-card bg-white border-3 border-black rounded-playful-lg p-6 shadow-[5px_5px_0_#080330] flex flex-col justify-between hover:-translate-y-2 hover:shadow-[9px_9px_0_#080330] transition-all duration-300 group cursor-pointer h-full">
                    <div>
                        <div class="w-14 h-14 rounded-playful-md bg-primary border-2 border-black flex items-center justify-center mb-5 group-hover:-rotate-6 transition-transform duration-300 shadow-[3px_3px_0_#080330]">
                            <img src="{{ asset('assets/icon/meditation.svg') }}" alt="Meditation Icon" class="w-7 h-7">
                        </div>
                        <h3 class="text-xl font-extrabold text-black mb-2">Meditation Guidance</h3>
                        <p class="text-black/80 font-medium text-sm leading-relaxed">
                            Atur waktu meditasi dengan suara white noise yang menenangkan untuk membantu relaksasi.
                        </p>
                    </div>
                    <div class="mt-6 pt-3 border-t-2 border-black/10 text-xs font-extrabold text-primary-dark">
                        Relaksasi Diri &rarr;
                    </div>
                </div>

                <!-- Feature Card 3 -->
                <div class="chat-card bg-white border-3 border-black rounded-playful-lg p-6 shadow-[5px_5px_0_#080330] flex flex-col justify-between hover:-translate-y-2 hover:shadow-[9px_9px_0_#080330] transition-all duration-300 group cursor-pointer h-full">
                    <div>
                        <div class="w-14 h-14 rounded-playful-md bg-secondary border-2 border-black flex items-center justify-center mb-5 group-hover:rotate-6 transition-transform duration-300 shadow-[3px_3px_0_#080330]">
                            <img src="{{ asset('assets/icon/comunity.svg') }}" alt="Community Icon" class="w-7 h-7">
                        </div>
                        <h3 class="text-xl font-extrabold text-black mb-2">Komunitas Suportif</h3>
                        <p class="text-black/80 font-medium text-sm leading-relaxed">
                            Terhubung dengan pengguna lain dalam platform sosial kami, di mana semua orang bisa saling mendukung.
                        </p>
                    </div>
                    <div class="mt-6 pt-3 border-t-2 border-black/10 text-xs font-extrabold text-primary-dark">
                        Ruang Berbagi &rarr;
                    </div>
                </div>

                <!-- Feature Card 4 -->
                <div class="chat-card bg-white border-3 border-black rounded-playful-lg p-6 shadow-[5px_5px_0_#080330] flex flex-col justify-between hover:-translate-y-2 hover:shadow-[9px_9px_0_#080330] transition-all duration-300 group cursor-pointer h-full">
                    <div>
                        <div class="w-14 h-14 rounded-playful-md bg-primary border-2 border-black flex items-center justify-center mb-5 group-hover:-rotate-6 transition-transform duration-300 shadow-[3px_3px_0_#080330]">
                            <img src="{{ asset('assets/icon/journal.svg') }}" alt="Privacy Icon" class="w-7 h-7">
                        </div>
                        <h3 class="text-xl font-extrabold text-black mb-2">Privacy First</h3>
                        <p class="text-black/80 font-medium text-sm leading-relaxed">
                            Semua data yang kamu masukkan bersifat pribadi dan dienkripsi end-to-end, demi keamanan dan privasi maksimal.
                        </p>
                    </div>
                    <div class="mt-6 pt-3 border-t-2 border-black/10 text-xs font-extrabold text-primary-dark">
                        Aman & Terenkripsi &rarr;
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Pricing Section ("Fourth Layer") -->
    <section id="fourth-layer" class="w-full bg-white py-20 px-4 md:px-8">
        <div class="max-w-5xl mx-auto flex flex-col items-center">
            <div class="text-center mb-12">
                <span class="inline-block px-4 py-1.5 rounded-full bg-secondary text-black font-extrabold text-xs tracking-wider uppercase border-2 border-black mb-3 shadow-[3px_3px_0_#080330]">
                    💎 PILIHAN AKSES
                </span>
                <h2 class="text-3xl md:text-4xl font-extrabold text-black">
                    Pilih Paket Sesuai Kebutuhanmu
                </h2>
            </div>

            <!-- Pricing Grid Containers -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 w-full">
                <!-- Free Plan Card Container -->
                <div class="bg-white border-3 border-black rounded-playful-lg p-8 shadow-[6px_6px_0_#080330] flex flex-col justify-between hover:-translate-y-1 transition-transform duration-200">
                    <div>
                        <span class="px-3 py-1 rounded-full bg-gray-200 text-black font-extrabold text-xs border border-black uppercase tracking-wider inline-block mb-4">
                            Basic
                        </span>
                        <h3 class="text-2xl font-extrabold text-black">Akses Gratis</h3>
                        <p class="text-black/70 font-semibold text-sm mt-1">Untuk kamu yang ingin mencoba mereda sejenak.</p>
                        <div class="my-6">
                            <span class="text-4xl font-extrabold text-black">Rp0</span>
                            <span class="text-black/60 font-semibold text-sm"> / selamanya</span>
                        </div>
                        <ul class="space-y-3 font-semibold text-black/90 text-sm mb-8">
                            <li class="flex items-center gap-2">✓ Jurnal Refleksi Harian</li>
                            <li class="flex items-center gap-2">✓ Komunitas Publik</li>
                            <li class="flex items-center gap-2">✓ Suara Meditasi Dasar</li>
                        </ul>
                    </div>
                    <a href="{{ route('login') }}" class="w-full py-3.5 rounded-playful-md text-black font-extrabold bg-gray-100 border-2 border-black shadow-[3px_3px_0_#080330] hover:bg-gray-200 transition-all text-center block">
                        Coba Gratis
                    </a>
                </div>

                <!-- Pro Plan Card Container -->
                <div class="bg-secondary/40 border-3 border-black rounded-playful-lg p-8 shadow-[6px_6px_0_#080330] flex flex-col justify-between hover:-translate-y-1 transition-transform duration-200 relative overflow-hidden">
                    <div class="absolute -right-12 top-6 bg-accent text-white font-extrabold text-xs py-1 px-12 rotate-45 border-y-2 border-black uppercase shadow-sm">
                        Terfavorit
                    </div>
                    <div>
                        <span class="px-3 py-1 rounded-full bg-primary text-black font-extrabold text-xs border border-black uppercase tracking-wider inline-block mb-4 shadow-[2px_2px_0_#080330]">
                            Full Access
                        </span>
                        <h3 class="text-2xl font-extrabold text-black">Sejenak Premium</h3>
                        <p class="text-black/70 font-semibold text-sm mt-1">Akses penuh seluruh fitur refleksi AI & meditasi.</p>
                        <div class="my-6">
                            <span class="text-4xl font-extrabold text-black">Unlimited</span>
                        </div>
                        <ul class="space-y-3 font-semibold text-black/90 text-sm mb-8">
                            <li class="flex items-center gap-2">✓ Semua Fitur Gratis</li>
                            <li class="flex items-center gap-2">✓ Chatbot AI Tanpa Batas</li>
                            <li class="flex items-center gap-2">✓ Audio Meditasi Lengkap</li>
                            <li class="flex items-center gap-2">✓ Enkripsi Privasi Maksimal</li>
                        </ul>
                    </div>
                    <a href="{{ route('login') }}" class="w-full py-3.5 rounded-playful-md text-black font-extrabold bg-primary border-2 border-black shadow-[4px_4px_0_#080330] hover:-translate-y-0.5 hover:shadow-[5px_5px_0_#080330] transition-all text-center block">
                        Mulai Sekarang
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Call To Action Container Section -->
    <section id="cta-section" class="w-full py-20 px-4 md:px-8 bg-primary border-t-3 border-black">
        <div class="max-w-4xl mx-auto bg-white border-4 border-black rounded-playful-lg p-8 md:p-14 shadow-[8px_8px_0_#080330] text-center flex flex-col items-center justify-center relative overflow-hidden">
            <span class="px-4 py-1.5 rounded-full bg-secondary text-black font-extrabold text-xs tracking-wider uppercase border-2 border-black mb-4 shadow-[3px_3px_0_#080330]">
                🚀 GABUNG SEKARANG
            </span>
            <h2 class="text-3xl md:text-5xl font-extrabold text-black mb-4">
                Siap untuk Memulai?
            </h2>
            <p class="text-base md:text-lg text-black/80 font-semibold mb-8 max-w-xl mx-auto">
                Daftar sekarang dan mulailah perjalananmu menuju kesejahteraan emosional yang lebih baik.
            </p>
            <form id="go-login" action="{{ route('login') }}" method="GET" class="flex flex-col sm:flex-row items-center justify-center gap-3 w-full max-w-md">
                <input id="signup-start" type="email" placeholder="Masukkan Email Anda" class="w-full p-3.5 px-5 rounded-playful-md border-3 border-black bg-white focus:outline-none focus:ring-2 focus:ring-black font-bold text-black placeholder:text-gray-400 shadow-[3px_3px_0_#080330]">
                <button type="submit" class="w-full sm:w-auto py-3.5 px-8 rounded-playful-md text-white font-extrabold bg-accent border-3 border-black shadow-[4px_4px_0_#080330] hover:-translate-y-1 hover:shadow-[6px_6px_0_#080330] hover:bg-accent/90 transition-all duration-200 whitespace-nowrap">
                    Daftar
                </button>
            </form>
        </div>
    </section>
</div>
@endsection

@section('script')
<script>
    function changeDescribe() {
        const tabs = [{
            id: 'p-1',
            content: "Sejenak adalah platform yang dirancang untuk membantu kamu mengekspresikan perasaan dengan cara yang aman dan nyaman. Kami memahami bahwa terkadang sulit untuk mengungkapkan apa yang ada di hati, jadi kami menciptakan ruang di mana kamu bisa merenung, bersantai, dan terhubung dengan orang lain."
        }, {
            id: 'p-2',
            content: "Sejenak dirancang untuk siapa saja yang mencari ruang untuk merenung dan mengekspresikan diri tanpa rasa takut. Di sini, kamu dapat menemukan dukungan, baik dari diri sendiri melalui refleksi di jurnal, maupun dari orang lain melalui komunitas. Platform ini menggabungkan teknologi AI yang cerdas, meditasi yang menenangkan, dan komunitas yang saling mendukung, semua dalam satu tempat dengan keamanan yang terjamin."
        }, {
            id: 'p-3',
            content: "Kami percaya bahwa setiap orang membutuhkan ruang untuk mengekspresikan diri dengan bebas dan aman. Sejenak hadir untuk mendukung siapa saja yang merasa sulit mengungkapkan perasaan, memberikan mereka ruang untuk merenung, merefleksikan diri, dan menemukan keseimbangan emosional. Dengan teknologi yang kami kembangkan, kami berkomitmen untuk membantu setiap pengguna merasa lebih terhubung dengan diri mereka sendiri dan mendapatkan dukungan yang mereka butuhkan."
        }, {
            id: 'p-4',
            content: "Kami sangat peduli dengan privasi pengguna. Di Sejenak, setiap data yang kamu masukkan, mulai dari jurnal harian hingga riwayat suasana hati, dienkripsi end-to-end. Ini berarti hanya kamu yang dapat mengaksesnya, memberikan rasa aman dan privasi maksimal. Untuk fitur komunitas sosial, meskipun bersifat publik, kami tetap memastikan bahwa kamu memiliki kendali penuh atas apa yang kamu bagikan."
        }];

        const describeParagraph = document.getElementById("describe");

        function setTabActive(activeId) {
            tabs.forEach(tab => {
                const element = document.getElementById(tab.id);
                if (element) {
                    if (tab.id === activeId) {
                        element.classList.add('bg-primary', 'shadow-[5px_5px_0_#080330]', '-translate-y-0.5');
                        element.classList.remove('bg-white', 'shadow-[3px_3px_0_#080330]');
                        describeParagraph.innerHTML = tab.content;
                    } else {
                        element.classList.remove('bg-primary', 'shadow-[5px_5px_0_#080330]', '-translate-y-0.5');
                        element.classList.add('bg-white', 'shadow-[3px_3px_0_#080330]');
                    }
                }
            });
        }

        // Set default active tab
        setTabActive('p-1');

        tabs.forEach(tab => {
            const element = document.getElementById(tab.id);
            if (element) {
                element.addEventListener('click', function() {
                    setTabActive(tab.id);
                });
            }
        });
    }

    document.addEventListener("DOMContentLoaded", function() {
        changeDescribe();
    });
</script>

<style>
    .chat-card {
        will-change: transform, box-shadow;
    }
</style>
@endsection
