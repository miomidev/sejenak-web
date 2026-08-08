@extends('layouts.app')

@section('title', 'Menunggu Pembayaran')

@section('content')
<div class="flex flex-col items-center justify-center min-h-screen text-center p-6">
    <div class="bg-white border-2 border-dark rounded-playful-lg p-8 md:p-12 shadow-border-offset-lg">
        <div class="text-6xl text-yellow-500 mb-6">
            <i class="fas fa-clock"></i>
        </div>
        <h1 class="text-3xl md:text-4xl font-bold font-exo2 text-dark mb-2">Menunggu Pembayaran</h1>
        <p class="text-lg text-gray-600 font-poppins mb-8">
            Kami masih menunggu konfirmasi pembayaran Anda. Silakan selesaikan pembayaran sebelum batas waktu berakhir.
        </p>
        <a href="{{ route('user.profiles') }}" class="inline-block bg-secondary text-white p-3 px-8 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-secondary-dark transition-all duration-200 hover:scale-105">
            Lihat Status Transaksi
        </a>
    </div>
</div>
@endsection