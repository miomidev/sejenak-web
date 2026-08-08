@extends('layouts.guest')
@section('title', 'Kebijakan Privasi - Sejenak')

@section('content')
<div class="flex flex-col items-center h-full w-full overflow-x-hidden no-scrollbar z-10">

    {{-- Header Section --}}
    <section class="w-full py-20 text-center text-white bg-primary">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-black leading-tight mb-4">
            Kebijakan Privasi
        </h1>
        <p class="text-lg md:text-xl font-medium text-black max-w-2xl mx-auto">
            Kami berkomitmen untuk melindungi privasi dan keamanan data pribadi Anda.
        </p>
    </section>

    {{-- SEPARATOR 1: SCROLLING KE KIRI --}}
    <div class="separator-scrolling-bg w-full h-14 bg-[url('assets/component/buy_now_banner.svg')] bg-repeat-x bg-[length:auto_120%] bg-[position:0_-4px] relative -top-7 -rotate-2 bg-white border-[6px] border-black">
    </div>

    {{-- Content Section --}}
    <section id="terms-content" class="w-full flex justify-center py-20 px-4 sm:px-8 lg:px-20 bg-gray-50">
        <div class="max-w-4xl w-full text-black text-base md:text-lg leading-relaxed space-y-8">

            <p class="italic">Dengan menggunakan Layanan kami, Anda menyetujui pengumpulan dan penggunaan informasi sesuai dengan kebijakan ini.</p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">1. Informasi yang Kami Kumpulkan</h2>
            <p>Kami mengumpulkan beberapa jenis informasi untuk menyediakan dan meningkatkan Layanan kami, meliputi:</p>
            <ul class="list-disc list-inside space-y-2 pl-4">
                <li><b>Data Pendaftaran:</b> Nama, alamat email, dan kata sandi.</li>
                <li><b>Informasi Sensitif:</b> Entri jurnal, catatan emosi, dan riwayat konsultasi yang Anda hasilkan di dalam aplikasi.</li>
                <li><b>Data Teknis:</b> Informasi perangkat, sistem operasi, dan data penggunaan aplikasi secara anonim.</li>
            </ul>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">2. Bagaimana Kami Menggunakan Informasi Anda</h2>
            <p>
                Kami menggunakan informasi Anda untuk menyediakan layanan, mengelola akun, mempersonalisasi pengalaman, serta memantau dan menganalisis penggunaan layanan untuk peningkatan kualitas. Data untuk analisis bersifat agregat dan anonim.
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">3. Dengan Siapa Kami Membagikan Informasi Anda</h2>
            <p>
                Privasi Anda adalah prioritas. Kami tidak menjual data pribadi Anda. Kami hanya membagikan informasi Anda kepada Mitra Profesional pilihan Anda untuk tujuan konsultasi, atau kepada penyedia layanan pihak ketiga (seperti hosting) yang terikat oleh kewajiban kerahasiaan.
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">4. Keamanan Data</h2>
            <p>
                Kami menerapkan langkah-langkah keamanan teknis yang kuat, termasuk enkripsi data saat transit dan saat disimpan (at-rest) serta kontrol akses yang ketat untuk melindungi data Anda dari akses tidak sah.
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">5. Hak Anda</h2>
            <p>
                Anda memiliki hak untuk mengakses, memperbaiki, atau meminta penghapusan data pribadi Anda. Anda dapat mengelola sebagian informasi Anda melalui pengaturan akun atau dengan menghubungi tim dukungan kami.
            </p>
        </div>
    </section>

    {{-- SEPARATOR 2: SCROLLING KE KANAN --}}
    <div class="separator-scrolling-bg-right w-full h-14 bg-[url('assets/component/buy_now_banner.svg')] bg-repeat-x bg-[length:auto_120%] bg-[position:0_-4px] relative -top-7 rotate-2 bg-white border-[6px] border-black">
    </div>

    {{-- CTA Section --}}
    <section id="cta-section" class="w-full flex-1 flex justify-center py-20 bg-primary">
        <div class="w-full md:w-[70%] text-center p-8">
            <h2 class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-black mb-4">
                Ada pertanyaan lain?
            </h2>
            <p class="text-base md:text-lg text-black font-medium mb-8 max-w-xl mx-auto">
                Jika ada yang ingin ditanyakan mengenai privasi data Anda, jangan ragu untuk menghubungi kami.
            </p>
            <a href="mailto:support@sejenak.miomidev.com" target="_blank" class="nav-btn py-3 px-8 rounded-full text-white font-bold bg-accent border-2 border-black cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-[5px_5px_0_#080330] hover:bg-secondary">
                Hubungi Kami
            </a>
        </div>
    </section>

</div>
@endsection

@section('script')
<script>
    // Script tambahan jika diperlukan
</script>
<style>
    @keyframes background-scrolling-left { from { background-position: 0 0; } to { background-position: -100% 0; } }
    @keyframes background-scrolling-right { from { background-position: -100% 0; } to { background-position: 0 0; } }
    .separator-scrolling-bg { animation: background-scrolling-left 20s linear infinite; will-change: background-position; }
    .separator-scrolling-bg-right { animation: background-scrolling-right 20s linear infinite; will-change: background-position; }
</style>
@endsection