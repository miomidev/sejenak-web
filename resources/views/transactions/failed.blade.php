@extends('layouts.app')

@section('title', 'Pembayaran Gagal')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen text-center p-6">
    <div class="bg-white border-2 border-dark rounded-playful-lg p-8 md:p-12 shadow-border-offset-lg">
        <div class="text-6xl text-red-500 mb-6">
            <i class="fas fa-times-circle"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold font-exo2 text-dark mb-2">Pembayaran Gagal</h1>
        <p class="text-lg text-gray-600 font-poppins mb-8">
            Maaf, pembayaran Anda tidak dapat diproses. Silakan coba lagi atau gunakan metode pembayaran lain.
        </p>
        <a href="{{ route('user.token') }}" class="inline-block bg-orange text-white p-3 px-8 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-orange-dark transition-all duration-200 hover:scale-105">
            Coba Beli Lagi
        </a>
    </div>
</div>
@endsection