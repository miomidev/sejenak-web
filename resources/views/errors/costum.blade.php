{{-- resources/views/errors/custom.blade.php --}}
@extends('layouts.guest')
@section('title', 'Oops! Error')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen w-full overflow-x-hidden no-scrollbar z-10 bg-primary">

    {{-- Background elements --}}
    <div class="absolute top-0 left-0 w-full h-full z-0">
        <div class="absolute top-10 left-10 w-20 h-20 rounded-full bg-secondary opacity-30 animate-float"></div>
        <div class="absolute top-40 right-20 w-16 h-16 rounded-full bg-accent opacity-40 animate-float" style="animation-delay: 0.5s;"></div>
        <div class="absolute bottom-20 left-1/4 w-24 h-24 rounded-full bg-secondary opacity-20 animate-float" style="animation-delay: 1s;"></div>
    </div>

    {{-- Header Section --}}
    <section class="w-full py-12 text-center text-white relative z-10">
        <div class="error-illustration mb-8 animate-shake">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="#0EA5E9">
                <path d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z"/>
            </svg>
        </div>
        
        <h1 class="text-6xl md:text-8xl lg:text-9xl font-extrabold text-black leading-tight mb-4 animate-rotate-slow">
            <span class="text-white bg-accent py-2 border-black shadow-border-offset rounded-playful-md px-6 rotate-3 inline-block">
                {{ $errorCode = $exception->getStatusCode() }}
            </span>
        </h1>
        
        <h2 class="text-3xl md:text-4xl lg:text-5xl font-bold text-black mb-4">
            @php
                switch ($errorCode) {
                    case 404:
                        echo 'Halaman tidak ditemukan';
                        break;
                    case 403:
                        echo 'Akses ditolak';
                        break;
                    case 500:
                        echo 'Terjadi kesalahan pada server';
                        break;
                    default:
                        echo $exception->getMessage() ?: 'Terjadi kesalahan';
                }
            @endphp
        </h2>
        
        <p class="text-base md:text-lg font-medium text-black max-w-xl mx-auto mb-8">
            Sepertinya ada yang salah, mari kembali ke jalan yang benar.
        </p>
        
        <a href="{{ url('/') }}" class="nav-btn inline-block py-3 px-8 rounded-full text-white font-bold bg-accent border-2 border-black cursor-pointer transition-all duration-300 hover:-translate-y-1 hover:shadow-[5px_5px_0_#080330] hover:bg-secondary">
            Kembali ke Beranda
        </a>
    </section>

    {{-- SEPARATOR 1: SCROLLING KE KIRI --}}
    <div class="separator-scrolling-bg w-full h-14 bg-[url('data:image/svg+xml;utf8,<svg xmlns=\"http://www.w3.org/2000/svg\" width=\"100\" height=\"50\" viewBox=\"0 0 100 50\"><rect x=\"0\" y=\"0\" width=\"100\" height=\"50\" fill=\"%230EA5E9\" /><circle cx=\"20\" cy=\"25\" r=\"8\" fill=\"%23F0F9FF\" /><circle cx=\"50\" cy=\"25\" r=\"8\" fill=\"%23F0F9FF\" /><circle cx=\"80\" cy=\"25\" r=\"8\" fill=\"%23F0F9FF\" /></svg>')] bg-repeat-x bg-[length:auto_120%] bg-[position:0_-4px] relative -top-7 -rotate-2 bg-white border-[6px] border-black">
    </div>
</div>
@endsection

@section('script')
<script>
    // Tambahkan animasi shake pada ilustrasi error
    document.addEventListener('DOMContentLoaded', function() {
        const illustration = document.querySelector('.error-illustration');
        illustration.classList.add('animate-shake');
        
        setTimeout(() => {
            illustration.classList.remove('animate-shake');
        }, 500);
    });
</script>
@endsection