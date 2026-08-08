@extends('layouts.app')
@section('content')
<div class="flex flex-col items-center w-full h-full p-4 md:p-0 overflow-y-auto">
    <div class="text-center my-8 md:my-12 relative w-full max-w-2xl">
        <h1 class="text-4xl md:text-5xl font-bold font-exo2 text-dark text-shadow-h1">Daily Challenge</h1>
        <p class="text-lg md:text-xl text-gray-600 mt-2 font-poppins text-shadow-soft">Jumat, 11 September 2025</p>
        <div class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-full md:left-auto md:right-0 md:translate-x-full -z-10">
            <i class="fas fa-feather text-6xl text-purple opacity-20"></i>
        </div>
        <div class="absolute bottom-0 right-0 transform translate-x-1/2 translate-y-1/2 -z-10">
            <i class="fas fa-sun text-8xl text-orange opacity-20"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 w-full max-w-6xl">
        
        <div class="md:col-span-2 space-y-4">
            <h2 class="text-2xl font-bold font-exo2 text-dark mb-4">Daftar Tantangan</h2>
            <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2">
                
                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-book-open text-purple mr-2"></i> Jurnal Pribadi
                        </h3>
                        <span class="bg-primary text-white text-xs font-bold py-1 px-3 rounded-full">Berjalan</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Tuliskan minimal 100 kata tentang perasaan dan pikiranmu hari ini.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-primary h-2.5 rounded-full" style="width: 75%"></div>
                    </div>
                    <button class="w-full bg-primary text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-primary-dark transition-all duration-200 hover:scale-105">
                        Lanjutkan
                    </button>
                </div>

                <div class="bg-gray-100 border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg opacity-70">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-spa text-green-500 mr-2"></i> Meditasi Sejenak
                        </h3>
                        <span class="bg-green-500 text-white text-xs font-bold py-1 px-3 rounded-full">Selesai</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Lakukan meditasi selama 5 menit untuk menenangkan pikiran.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%"></div>
                    </div>
                    <button class="w-full bg-gray-400 text-white p-3 rounded-playful-sm font-bold border-2 border-dark cursor-not-allowed">
                        Sudah Selesai
                    </button>
                </div>

                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-wind text-orange mr-2"></i> Latihan Pernapasan
                        </h3>
                        <span class="bg-gray-400 text-white text-xs font-bold py-1 px-3 rounded-full">Belum Dimulai</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Lakukan teknik pernapasan kotak 4-4-4-4 sebanyak 3 kali.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-orange h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                    <button class="w-full bg-orange text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-orange-dark transition-all duration-200 hover:scale-105">
                        Mulai
                    </button>
                </div>
                
                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-star text-yellow-400 mr-2"></i> Beri Nilai Harimu
                        </h3>
                        <span class="bg-gray-400 text-white text-xs font-bold py-1 px-3 rounded-full">Belum Dimulai</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Berikan rating dari 1 sampai 5 untuk hari yang sudah kamu lewati.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-yellow-400 h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                    <button class="w-full bg-yellow-400 text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-yellow-500 transition-all duration-200 hover:scale-105">
                        Mulai
                    </button>
                </div>

                <div class="bg-gray-100 border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg opacity-70">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-glass-whiskey text-blue-500 mr-2"></i> Minum Air
                        </h3>
                        <span class="bg-green-500 text-white text-xs font-bold py-1 px-3 rounded-full">Selesai</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Pastikan kamu minum setidaknya 8 gelas air hari ini.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-blue-500 h-2.5 rounded-full" style="width: 100%"></div>
                    </div>
                    <button class="w-full bg-gray-400 text-white p-3 rounded-playful-sm font-bold border-2 border-dark cursor-not-allowed">
                        Selesai
                    </button>
                </div>

                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-phone-alt text-orange mr-2"></i> Hubungi Orang Tersayang
                        </h3>
                        <span class="bg-gray-400 text-white text-xs font-bold py-1 px-3 rounded-full">Belum Dimulai</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Kirim pesan atau telepon seseorang yang kamu sayangi.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-orange h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                    <button class="w-full bg-orange text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-orange-dark transition-all duration-200 hover:scale-105">
                        Mulai
                    </button>
                </div>

                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-running text-primary mr-2"></i> Gerak Aktif
                        </h3>
                        <span class="bg-primary text-white text-xs font-bold py-1 px-3 rounded-full">Berjalan</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Lakukan peregangan atau jalan santai selama 15 menit.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-primary h-2.5 rounded-full" style="width: 50%"></div>
                    </div>
                    <button class="w-full bg-primary text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-primary-dark transition-all duration-200 hover:scale-105">
                        Lanjutkan
                    </button>
                </div>

                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-brain text-secondary mr-2"></i> Pelajari Hal Baru
                        </h3>
                        <span class="bg-gray-400 text-white text-xs font-bold py-1 px-3 rounded-full">Belum Dimulai</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Tonton video tutorial atau baca artikel tentang topik yang menarik.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-secondary h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                    <button class="w-full bg-secondary text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-secondary-dark transition-all duration-200 hover:scale-105">
                        Mulai
                    </button>
                </div>

                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-moon text-purple-dark mr-2"></i> Tidur Cepat
                        </h3>
                        <span class="bg-gray-400 text-white text-xs font-bold py-1 px-3 rounded-full">Belum Dimulai</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Usahakan untuk tidur 30 menit lebih awal dari biasanya.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-purple-dark h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                    <button class="w-full bg-purple text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-purple-dark transition-all duration-200 hover:scale-105">
                        Mulai
                    </button>
                </div>

                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-xl font-bold font-exo2 text-dark">
                            <i class="fas fa-hands-praying text-orange mr-2"></i> Ucapkan Syukur
                        </h3>
                        <span class="bg-gray-400 text-white text-xs font-bold py-1 px-3 rounded-full">Belum Dimulai</span>
                    </div>
                    <p class="text-base text-gray-700 font-poppins mb-4">Tuliskan 3 hal yang kamu syukuri dari hari ini.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-orange h-2.5 rounded-full" style="width: 0%"></div>
                    </div>
                    <button class="w-full bg-orange text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-orange-dark transition-all duration-200 hover:scale-105">
                        Mulai
                    </button>
                </div>
            </div>
        </div>

        <div class="space-y-6 mt-6 md:mt-0">
            <div>
                <h2 class="text-2xl font-bold font-exo2 text-dark mb-4">Capaian Harian</h2>
                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col items-center text-center shadow-border-offset-lg">
                    <div class="flex-shrink-0 w-24 h-24 rounded-full bg-primary flex items-center justify-center border-2 border-dark shadow-border-offset-accent mb-4">
                        <i class="fas fa-medal text-5xl text-white"></i>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold font-exo2 text-dark mb-1">Pencapaian Hebat!</h3>
                    <p class="text-base text-gray-700 font-poppins mb-4">Kamu berhasil menyelesaikan semua tantangan hari ini.</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        <div class="bg-green-500 h-2.5 rounded-full" style="width: 100%;"></div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold font-exo2 text-dark mb-4">Riwayat Pencapaian</h2>
                <div class="space-y-4">
                    
                    <div class="bg-white border-2 border-dark rounded-playful-sm p-4 flex items-center shadow-border-offset-sm">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-orange flex items-center justify-center border-2 border-dark mr-4">
                            <i class="fas fa-trophy text-2xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold font-exo2 text-dark">Lencana "Konsisten"</h4>
                            <p class="text-sm text-gray-500">Selesaikan 7 tantangan berturut-turut.</p>
                        </div>
                    </div>
                    
                    <div class="bg-white border-2 border-dark rounded-playful-sm p-4 flex items-center shadow-border-offset-sm">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-purple flex items-center justify-center border-2 border-dark mr-4">
                            <i class="fas fa-lightbulb text-2xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold font-exo2 text-dark">Lencana "Jurnalis Pro"</h4>
                            <p class="text-sm text-gray-500">Tulis 1000 kata dalam jurnal.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection