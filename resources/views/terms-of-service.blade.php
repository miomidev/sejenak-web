@extends('layouts.guest')
@section('title', 'Syarat & Ketentuan - Sejenak')

@section('content')
<div class="flex flex-col items-center h-full w-full overflow-x-hidden no-scrollbar z-10">

    {{-- Header Section --}}
    <section class="w-full py-20 text-center text-white bg-primary">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-black leading-tight mb-4">
            Syarat & Ketentuan
        </h1>
        <p class="text-lg md:text-xl font-medium text-black max-w-2xl mx-auto">
            Harap baca syarat dan ketentuan ini dengan saksama sebelum menggunakan layanan kami.
        </p>
    </section>

    {{-- SEPARATOR 1: SCROLLING KE KIRI --}}
    <div class="separator-scrolling-bg w-full h-14 bg-[url('assets/component/buy_now_banner.svg')] bg-repeat-x bg-[length:auto_120%] bg-[position:0_-4px] relative -top-7 -rotate-2 bg-white border-[6px] border-black">
    </div>

    {{-- Content Section --}}
    <section id="terms-content" class="w-full flex justify-center py-20 px-4 sm:px-8 lg:px-20 bg-gray-50">
        <div class="max-w-4xl w-full text-black text-base md:text-lg leading-relaxed space-y-8">

            <div class="p-4 bg-red-100 border-l-4 border-red-500 text-red-700">
                <h2 class="text-2xl md:text-3xl font-bold mb-2">1. Peringatan Penting: Bukan Layanan Gawat Darurat</h2>
                <p class="font-semibold">
                    Layanan yang disediakan oleh Sejenak BUKAN UNTUK KONDISI GAWAT DARURAT MEDIS ATAU KRISIS KESEHATAN MENTAL. Jika Anda mengalami krisis atau situasi darurat lainnya, segera hubungi layanan darurat lokal (119) atau kunjungi unit gawat darurat terdekat.
                </p>
            </div>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">2. Deskripsi Layanan</h2>
            <p>
                Sejenak adalah platform teknologi yang menyediakan ruang aman digital untuk dukungan kesehatan mental. Layanan kami mencakup akses ke komunitas, konten edukasi, alat bantu mandiri, dan fasilitas untuk terhubung dengan para profesional kesehatan mental independen ("Mitra Profesional"). Sejenak hanyalah fasilitator dan tidak menyediakan layanan medis atau diagnosis klinis secara langsung.
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">3. Akun Pengguna</h2>
            <p>
                Untuk mendaftar, Anda harus berusia minimal 18 tahun. Anda bertanggung jawab penuh untuk menjaga kerahasiaan informasi akun Anda dan setuju untuk memberikan informasi yang akurat selama proses pendaftaran.
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">4. Aturan Perilaku Pengguna</h2>
            <p>
                Anda setuju untuk tidak menggunakan layanan untuk membagikan konten yang melanggar hukum, bersifat melecehkan, mengancam, memfitnah, atau melanggar privasi orang lain. Kami berhak menangguhkan akun Anda jika terjadi pelanggaran.
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">5. Layanan Konsultasi dengan Mitra Profesional</h2>
            <p>
                Hubungan terapeutik hanya terjadi antara Anda dan Mitra Profesional Anda. Sejenak tidak bertanggung jawab atas saran, diagnosis, atau layanan yang mereka berikan. Sesi konsultasi bersifat rahasia sesuai dengan kode etik profesi yang berlaku.
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">6. Pembatasan Tanggung Jawab</h2>
            <p>
                Layanan ini disediakan "sebagaimana adanya". Sejauh yang diizinkan oleh hukum, Sejenak tidak bertanggung jawab atas segala kerugian yang timbul dari penggunaan atau ketidakmampuan Anda dalam menggunakan layanan ini.
            </p>
            
            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">7. Perubahan Ketentuan</h2>
            <p>
                Kami berhak untuk mengubah ketentuan layanan ini kapan saja. Perubahan akan berlaku segera setelah dipublikasikan di halaman ini. Penggunaan platform secara terus-menerus setelah perubahan menandakan persetujuan Anda terhadap ketentuan yang baru.
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
                Punya pertanyaan?
            </h2>
            <p class="text-base md:text-lg text-black font-medium mb-8 max-w-xl mx-auto">
                Silakan hubungi tim kami untuk informasi lebih lanjut mengenai ketentuan layanan kami.
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