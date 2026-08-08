    @extends('layouts.guest')
    @section('title', 'Safe Space for Everybody')

    @section('content')
    <div class="bg-whiteflex flex-col items-center h-full w-full overflow-x-hidden no-scrollbar z-10">
        <section class="w-[100%] py-20 flex flex-col md:flex-row items-center justify-arround gap-8 bg-primary">
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
            <div class="md:w-1/3 flex flex-col items-center md:items-start text-center md:text-left">
                <h1 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-black leading-loose mb-4">
                    Luangkan waktu refleksi cukup
                    <span class="text-white bg-accent py-2 border-black shadow-border-offset rounded-playful-md px-6 rotate-1 inline-block">
                        Sejenak
                    </span> saja
                </h1>
                <b class="text-base md:text-lg text-black mb-6">
                    Perjalanan menuju kesejahteraan emosional dimulai di sini.
                </b>
                <div class="flex flex-row gap-4">
                    <a href="{{ route('login') }}" class="nav-btn py-3 px-8 rounded-playful-md text-dark font-bold bg-secondary border-2 border-black
                        transition-all duration-300 hover:-translate-y-1 hover:shadow-[5px_5px_0_#080330] hover:bg-secondary">
                        Mulai Sekarang
                    </a>
                    <a href="#" class="nav-btn py-3 px-8 rounded-playful-md text-white hover:text-black font-bold bg-accent border-2 border-black
                    transition-all duration-300 hover:-translate-y-1 hover:shadow-[5px_5px_0_#080330] hover:bg-secondary">
                        Lebih lanjut
                    </a>
                </div>
            </div>
        </section>



        <section id="second-layer" class="bg-white flex flex-col lg:flex-row gap-8 justify-center items-center py-20 px-8 lg:px-60 w-full">
            <div id="second-left" class="w-[100%] lg:w-1/2 flex justify-start p-3    lg:justify-start">
                <ul>
                    <h2 class="text-4xl font-bold text-primary mb-6">Sejenak</h2>
                    <li id="p-1" class="description-tab font-bold text-lg cursor-pointer relative pb-2 transition-all duration-300">Apa itu sejenak?</li>
                    <li id="p-2" class="description-tab font-bold text-lg cursor-pointer relative pb-2 transition-all duration-300">Mengapa memilih sejenak?</li>
                    <li id="p-3" class="description-tab font-bold text-lg cursor-pointer relative pb-2 transition-all duration-300">Misi kami</li>
                    <li id="p-4" class="description-tab font-bold text-lg cursor-pointer relative pb-2 transition-all duration-300">Privasi dan keamanan</li>
                </ul>
            </div>
            <div id="second-right" class="w-full lg:w-1/2 flex justify-center px-4">
                <p id="describe" class="font-bold text-lg text-gray-700 leading-relaxed">Sejenak adalah platform yang dirancang untuk membantu kamu mengekspresikan
                    perasaan dengan cara yang aman dan nyaman. Kami memahami bahwa terkadang sulit untuk
                    mengungkapkan apa yang ada di hati, jadi kami menciptakan ruang di mana kamu bisa merenung,
                    bersantai, dan terhubung dengan orang lain.
                </p>
            </div>
        </section>
        <section id="features" class="bg-white w-full bg-[url('assets/component/bg-third.svg')] flex justify-center">
            <div class="w-full md:w-[50%] p-2 md:p-12 text-center
                grid grid-cols-1 md:grid-cols-2 justify-items-center gap-2 md:gap-6 ">
                <div class="chat-card max-w-sm bg-[#F7F7F7] border-2 border-black rounded-playful-md
                    hover:shadow-border-bot-shadow hover:-translate-y-1
                    p-6 m-4 cursor-pointer transition-transform duration-200">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('assets/icon/sparkle.svg') }}" alt="Sparkle Icon" class="w-8 h-8 mr-3">
                        <h3 class="text-xl font-bold text-black">AI Chat</h3>
                    </div>
                    <div class="inner-features h-[80%] max-w-sm text-base text-black leading-relaxed border-2 border-black rounded-playful-md p-4">
                        <p> Curhatkan apa pun ke chatbot, dan biarkan ia menyulapnya menjadi catatan harian yang personal.</p>
                    </div>
                </div>
                <div class="chat-card max-w-sm bg-[#F7F7F7] border-2 border-black rounded-playful-md
                    hover:shadow-border-bot-shadow hover:-translate-y-1
                    p-6 m-4 cursor-pointer transition-transform duration-200">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('assets/icon/sparkle.svg') }}" alt="Sparkle Icon" class="w-8 h-8 mr-3">
                        <h3 class="text-xl font-bold text-black">Meditation Guidance</h3>
                    </div>
                    <div class="inner-features h-[80%] max-w-sm text-base text-black leading-relaxed border-2 border-black rounded-playful-md p-4">
                        <p> Atur waktu meditasi dengan suara white noise yang menenangkan untuk membantu relaksasi.</p>
                    </div>
                </div>
                <div class="chat-card max-w-sm bg-[#F7F7F7] border-2 border-black rounded-playful-md
                    hover:shadow-border-bot-shadow hover:-translate-y-1
                    p-6 m-4 cursor-pointer transition-transform duration-200">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('assets/icon/sparkle.svg') }}" alt="Sparkle Icon" class="w-8 h-8 mr-3">
                        <h3 class="text-xl font-bold text-black">Komunitas Suportif</h3>
                    </div>
                    <div class="inner-features h-[80%] max-w-sm text-base text-black leading-relaxed border-2 border-black rounded-playful-md p-4">
                        <p> Terhubung dengan pengguna lain dalam platform sosial kami, di mana semua orang bisa saling mendukung.</p>
                    </div>
                </div>
                <div class="chat-card max-w-sm bg-[#F7F7F7] border-2 border-black rounded-playful-md
                    hover:shadow-border-bot-shadow hover:-translate-y-1
                    p-6 m-4 cursor-pointer transition-transform duration-200">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('assets/icon/sparkle.svg') }}" alt="Sparkle Icon" class="w-8 h-8 mr-3">
                        <h3 class="text-xl font-bold text-black">Privacy First</h3>
                    </div>
                    <div class="inner-features h-[80%] max-w-sm text-base text-black leading-relaxed border-2 border-black rounded-playful-md p-4">
                        <p>Semua data yang kamu masukkan bersifat pribadi dan dienkripsi end-to-end, demi keamanan dan privasi maksimal.</p>
                    </div>
                </div>
            </div>
        </section>
        {{-- SEPARATOR 1: SCROLLING KE KIRI --}}
        {{-- <div class="separator-scrolling-bg-right w-full h-14 bg-[url('assets/component/buy_now_banner.svg')] bg-repeat-x bg-[length:auto_120%] bg-[position:0_-4px] relative  bg-white border-[6px] border-black">
        </div>
        <section id="pricing" class="bg-white w-full flex justify-center py-12 text-center ">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 px-4 md:px-0 lg:px-20 w-[80%]">
                <div class="animate-rotate-slow card w-full md:w-1/2 p-6 flex flex-col items-center justify-between rounded-xl transform transition-transform duration-300 hover:scale-105 hover:-translate-y-2" style="background-image: url('{{ asset('assets/component/price_container1.svg') }}'); background-size: contain; background-repeat: no-repeat; background-position: center; min-height: 450px;">

                </div>

                <div class="animate-rotate-slow card p-6 bg-no-repeat bg-contain rounded-xl transform transition-transform hover:scale-105 hover:translate-y-[-10px] flex justify-end aspect-[5/3] overflow-hidden">
                    <img src="{{ asset('assets/component/price_container2.svg') }}" alt="">
                    <div class="absolute top-2 right-0 w-20">
                        <img class="absolute animate-rotate" src="{{ asset('assets/component/star_bg.svg') }}" alt="">
                        <img class="absolute -left-1 -top-1 animate-rotate" src="{{ asset('assets/component/star_fg.svg') }}" alt="">
                    </div>
                </div>
            </div>
        </section>

        <div class="separator-scrolling-bg w-full h-14 bg-[url('assets/component/buy_now_banner.svg')] bg-repeat-x bg-[length:auto_120%] bg-[position:0_-4px] relative   bg-white border-[6px] border-black">
        </div> --}}

        <section id="cta-section" class="w-full h-full flex justify-center align-middle py-20 bg-primary bg-dot-pattern">
            <div class="w-full md:w-[40%] text-center flex-col flex align-middle justify-center md:text-left p-8">
                <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white mb-4">
                    Siap untuk memulai?
                </h2>
                <p class="text-base md:text-lg text-white font-medium mb-8 max-w-xl mx-auto md:mx-0">
                    Daftar sekarang dan mulailah perjalananmu menuju kesejahteraan emosional.
                </p>
                <form id="go-login" action="{{ route('login') }}" method="POST" class="flex flex-col md:flex-row items-center justify-center md:justify-start gap-4">
                    @csrf
                    <input id="signup-start" type="email" placeholder="Email" class="w-full md:w-auto p-3 rounded-playful-md border-2 border-black bg-white focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all duration-200">
                    <input id="button-signup" type="submit" class="button-z py-3 px-8 rounded-playful-md text-white font-bold bg-accent border-2 border-black cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-[5px_5px_0_#080330] hover:bg-secondary">
                </form>
            </div>
        </section>
    </div>
    @endsection

    @section('script')
    <script>
        function changeDescribe() {
            const tabs = [{
                id: 'p-1'
                , content: "Sejenak adalah platform yang dirancang untuk membantu kamu mengekspresikan perasaan dengan cara yang aman dan nyaman. Kami memahami bahwa terkadang sulit untuk mengungkapkan apa yang ada di hati, jadi kami menciptakan ruang di mana kamu bisa merenung, bersantai, dan terhubung dengan orang lain."
            }, {
                id: 'p-2'
                , content: "Sejenak dirancang untuk siapa saja yang mencari ruang untuk merenung dan mengekspresikan diri tanpa rasa takut. Di sini, kamu dapat menemukan dukungan, baik dari diri sendiri melalui refleksi di jurnal, maupun dari orang lain melalui komunitas. Platform ini menggabungkan teknologi AI yang cerdas, meditasi yang menenangkan, dan komunitas yang saling mendukung, semua dalam satu tempat dengan keamanan yang terjamin."
            }, {
                id: 'p-3'
                , content: "Kami percaya bahwa setiap orang membutuhkan ruang untuk mengekspresikan diri dengan bebas dan aman. Sejenak hadir untuk mendukung siapa saja yang merasa sulit mengungkapkan perasaan, memberikan mereka ruang untuk merenung, merefleksikan diri, dan menemukan keseimbangan emosional. Dengan teknologi yang kami kembangkan, kami berkomitmen untuk membantu setiap pengguna merasa lebih terhubung dengan diri mereka sendiri dan mendapatkan dukungan yang mereka butuhkan."
            }, {
                id: 'p-4'
                , content: "Kami sangat peduli dengan privasi pengguna. Di Sejenak, setiap data yang kamu masukkan, mulai dari jurnal harian hingga riwayat suasana hati, dienkripsi end-to-end. Ini berarti hanya kamu yang dapat mengaksesnya, memberikan rasa aman dan privasi maksimal. Untuk fitur komunitas sosial, meskipun bersifat publik, kami tetap memastikan bahwa kamu memiliki kendali penuh atas apa yang kamu bagikan."
            }];

            document.querySelectorAll('#second-left ul li').forEach(li => {
                li.classList.add('description-tab');
            });

            const describeParagraph = document.getElementById("describe");

            const initialTab = document.getElementById('p-1');
            if (initialTab) {
                initialTab.classList.add('active');
                describeParagraph.innerHTML = tabs[0].content;
            }

            tabs.forEach(tab => {
                const element = document.getElementById(tab.id);
                if (element) {
                    element.addEventListener('click', function() {
                        document.querySelectorAll('.description-tab').forEach(t => {
                            t.classList.remove('active');
                            t.classList.remove('text-primary');
                        });
                        this.classList.add('active');
                        this.classList.add('text-primary');
                        describeParagraph.innerHTML = tab.content;
                    });
                }
            });

            document.querySelectorAll('.description-tab').forEach(tab => {
                tab.addEventListener('mouseover', function() {
                    if (!this.classList.contains('active')) {
                        this.classList.add('text-primary');
                    }
                });
                tab.addEventListener('mouseout', function() {
                    if (!this.classList.contains('active')) {
                        this.classList.remove('text-primary');
                    }
                });
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            changeDescribe();
        });

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

        @keyframes full-rotation {
            0% {
                transform: rotate(0deg);
            }

            50% {
                transform: rotate(180deg);
            }

            100% {
                transform: rotate(360deg);
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
            0% {
                transform: rotate(0deg);
            }

            20% {
                transform: rotate(-1deg);
            }

            40% {
                transform: rotate(1.5deg);
            }

            60% {
                transform: rotate(-1.5deg);
            }

            80% {
                transform: rotate(1deg);
            }

            100% {
                transform: rotate(0deg);
            }
        }

        .animate-rotate {
            animation: full-rotation 3s linear infinite;
            transform-origin: center center;
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
            /* Memastikan rotasi dari tengah */
        }

        /* GAYA LAINNYA */
        .chat-card {
            transition: transform 0.1s ease-out, box-shadow 0.1s ease-out;
        }

        .chat-card.active {
            transform: translate(2px, 2px);
            box-shadow: 1px 1px 0px #080330;
        }

        .rounded-playful {
            border-radius: 20px;
        }

        .shadow-chat-card-initial {
            box-shadow: 4px 4px 0px #080330;
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
            background-color: #8FD14F;
            transition: width 0.3s ease-in-out;
        }

        .description-tab.active,
        .description-tab:hover {
            color: #8FD14F;
        }

        .description-tab:hover::after,
        .description-tab.active::after {
            width: 100%;
        }

        .inner-features:active {
            transform: translateY(4px);
            box-shadow: 0 -2px 0 #080330;
        }

        #cta-section .button-z {
            border-radius: 9999px;
        }

        .custom-bg-features {
            background-image: url("data:image/svg+xml,%3Csvg width='4' height='4' viewBox='0 0 4 4' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='%239333ea' fill-opacity='0.4'%3E%3Cpath d='M1 3h1v1H1V3zm2-2h1v1H3V1z'/%3E%3C/g%3E%3C/svg%3E"),
            url('{{ asset('assets/component/bg-third.png') }}');
            background-size: 30px 30px, cover;
            background-repeat: repeat, no-repeat;
            background-position: 0 0, center center;
        }

    </style>
    @endsection
