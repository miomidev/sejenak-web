@extends('layouts.guest')
@section('title', 'Kebijakan Pengembalian Dana - Sejenak')

@section('content')
<div class="flex flex-col items-center h-full w-full overflow-x-hidden no-scrollbar z-10">

    {{-- Header Section --}}
    <section class="w-full py-20 text-center text-white bg-primary">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-extrabold text-black leading-tight mb-4">
            Kebijakan Pengembalian Dana
        </h1>
        <p class="text-lg md:text-xl font-medium text-black max-w-2xl mx-auto">
            Berikut adalah kebijakan kami terkait pengembalian dana untuk layanan berbayar di Sejenak.
        </p>
    </section>

    {{-- SEPARATOR 1: SCROLLING KE KIRI --}}
    <div class="separator-scrolling-bg w-full h-14 bg-[url('assets/component/buy_now_banner.svg')] bg-repeat-x bg-[length:auto_120%] bg-[position:0_-4px] relative -top-7 -rotate-2 bg-white border-[6px] border-black">
    </div>

    {{-- Content Section --}}
    <section id="terms-content" class="w-full flex justify-center py-20 px-4 sm:px-8 lg:px-20 bg-gray-50">
        <div class="max-w-4xl w-full text-black text-base md:text-lg leading-relaxed space-y-8">

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">1. Prinsip Umum</h2>
            <p>
                Karena sifat layanan digital yang kami tawarkan, pada umumnya semua pembayaran yang telah dilakukan untuk layanan yang telah atau akan diberikan bersifat <strong>final dan tidak dapat dikembalikan (non-refundable)</strong>, kecuali dinyatakan lain dalam kebijakan ini.
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">2. Sesi Konsultasi Online</h2>
            <p>Aturan pengembalian dana untuk sesi konsultasi adalah sebagai berikut:</p>
            <ul class="list-disc list-inside space-y-2 pl-4">
                <li><b>Layanan Telah Diberikan:</b> Biaya untuk sesi konsultasi yang telah selesai dilaksanakan tidak dapat dikembalikan.</li>
                <li><b>Pembatalan oleh Pengguna:</b> Jika Anda membatalkan lebih dari 24 jam sebelum sesi, Anda berhak mendapat pengembalian dana penuh atau menjadwal ulang. Jika kurang dari 24 jam atau tidak hadir, pembayaran akan hangus.</li>
                <li><b>Pembatalan oleh Mitra Profesional:</b> Jika Mitra Profesional membatalkan, Anda akan menerima pengembalian dana penuh atau opsi penjadwalan ulang.</li>
                <li><b>Masalah Teknis:</b> Jika sesi gagal karena masalah teknis dari platform Sejenak, kami akan menawarkan penjadwalan ulang sesi tanpa biaya.</li>
            </ul>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">3. Paket Langganan</h2>
            <p>
                Pembayaran untuk periode langganan yang sudah berjalan tidak dapat dikembalikan. Anda dapat membatalkan langganan kapan saja, dan pembatalan akan berlaku efektif pada akhir periode penagihan yang sedang berjalan.
            </p>

            <h2 class="text-2xl md:text-3xl font-bold mb-4 border-b-2 border-black pb-2">4. Proses Permintaan</h2>
            <p>
                Untuk kasus-kasus yang memenuhi syarat, silakan hubungi tim dukungan kami melalui email di <strong>dukungan@sejenak.id</strong> dengan menyertakan bukti pembelian dan penjelasan rinci mengenai permintaan Anda.
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
                Butuh Bantuan?
            </h2>
            <p class="text-base md:text-lg text-black font-medium mb-8 max-w-xl mx-auto">
                Tim kami siap membantu jika Anda memiliki pertanyaan seputar pembayaran atau pengembalian dana.
            </p>
            <a href="mailto:support@sejenak.miomidev.com" target="_blank" class="nav-btn py-3 px-8 rounded-full text-white font-bold bg-accent border-2 border-black cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-[5px_5px_0_#080330] hover:bg-secondary">
                Hubungi Dukungan
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