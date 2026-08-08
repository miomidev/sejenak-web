@extends('layouts.app')

@section('title', 'Profil Pengguna')

@section('content')
<div class="flex flex-col md:flex-row items-start md:items-stretch justify-start p-6 pt-6 md:p-4 w-full h-auto md:h-full gap-6 overflow-scroll">
    <div class="w-full md:w-1/3 flex flex-col gap-6">
        <div class="hover-1 h-3/4 flex flex-col items-center justify-start p-4 bg-white rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h2 class="text-h4 md:text-h3 font-bold text-dark mb-4 text-center">Profil Saya</h2>
            <div class="w-32 h-32 md:w-40 md:h-40 rounded-full overflow-hidden border-4 border-primary shadow-lg mb-4">
                @if (Auth::user()->avatar_url)
                <img src="{{ Auth::user()->avatar_url }}" alt="Foto Profil" class="object-cover w-full h-full">
                @else
                <div class="w-full h-full bg-gray-200 flex items-center justify-center text-dark text-4xl font-bold">
                    <span>{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                @endif
            </div>
            <h4 class="text-h5 md:text-h4 font-bold text-dark text-center">{{ Auth::user()->name }}</h4>
            <p class="text-xs md:text-sm text-gray-500 font-medium text-center">{{ Auth::user()->email }}</p>
            <p class="text-xs md:text-sm text-purple font-medium text-center mb-4">
                {{ Auth::user()->role->name }}
            </p>
            <div class="w-full text-center">
                <h5 class="text-sm font-semibold text-dark mb-2">Bio</h5>
                <p class="text-sm text-gray-600 italic">"{{ Auth::user()->bio ?? 'Bio belum diisi.' }}"</p>
            </div>
        </div>

        <div class="hover-1 h-1/4 bg-white p-4 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <div class="flex items-center justify-between">
                <h5 class="text-sm md:text-base font-bold text-dark">Status Langganan</h5>
                <i class="fas fa-crown text-orange-500"></i>
            </div>
            <p class="text-sm text-gray-600 mt-2">Anda adalah pengguna **Gratis**. <a href="#" class="text-primary underline font-semibold">Tingkatkan sekarang</a> untuk fitur eksklusif.</p>
        </div>
    </div>
        <div class="w-full md:w-1/3 flex flex-col gap-6">
            <div class="hover-1 h-1/2 bg-white p-4 rounded-playful-lg border-2 border-dark shadow-border-offset">
                <h3 class="text-h5 font-bold text-dark mb-4">Statistik Saya</h3>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col items-start md:flex-row md:justify-between md:items-center py-2 border-b border-gray-200 last:border-b-0">
                        <span class="text-dark font-semibold mb-1 md:mb-0"><i class="fas fa-coins text-primary mr-2"></i> Saldo Token</span>
                        <span class="font-bold text-dark w-full text-right md:w-auto">{{ number_format(Auth::user()->tokens_balance) }}</span>
                    </div>

                    <a href="{{ route('user.token') }}" class="click-1 w-full px-4 py-2 bg-primary text-white font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600 transition-all duration-200">
                        <i class="fas fa-cart-plus mr-2"></i> Beli Token
                    </a>

                    <div class="flex flex-col items-start md:flex-row md:justify-between md:items-center py-2 border-b border-gray-200 last:border-b-0">
                        <span class="text-dark font-semibold mb-1 md:mb-0"><i class="fas fa-book-open text-orange mr-2"></i> Jumlah Jurnal</span>
                        <span class="font-bold text-dark w-full text-right md:w-auto">{{ Auth::user()->journals()->count() }}</span>
                    </div>

                    <div class="flex flex-col items-start md:flex-row md:justify-between md:items-center py-2 last:border-b-0">
                        <span class="text-dark font-semibold mb-1 md:mb-0"><i class="fas fa-list-alt text-blue-400 mr-2"></i> Jumlah Postingan</span>
                        <span class="font-bold text-dark w-full text-right md:w-auto">{{ Auth::user()->posts()->count() }}</span>
                    </div>
                </div>
            </div>

            <div class="hover-1 h-1/2 bg-white p-4 rounded-playful-lg border-2 border-dark shadow-border-offset">
                <h3 class="text-h5 font-bold text-dark mb-4">Pencapaian Saya</h3>
                <div class="flex flex-col gap-4">
                    <div class="flex flex-col items-start md:flex-row md:justify-between md:items-center py-2 border-b border-gray-200 last:border-b-0">
                        <span class="text-dark font-semibold mb-1 md:mb-0"><i class="fas fa-medal mr-2 text-yellow-500"></i> Tantangan Selesai</span>
                        <span class="font-bold text-dark w-full text-right md:w-auto">5/10</span>
                    </div>
                    <div class="flex flex-col items-start md:flex-row md:justify-between md:items-center py-2 border-b border-gray-200 last:border-b-0">
                        <span class="text-dark font-semibold mb-1 md:mb-0"><i class="fas fa-calendar-check mr-2 text-primary"></i> Hari Berturut-turut</span>
                        <span class="font-bold text-dark w-full text-right md:w-auto">15 Hari</span>
                    </div>
                    <div class="flex flex-col items-start md:flex-row md:justify-between md:items-center py-2 last:border-b-0">
                        <span class="text-dark font-semibold mb-1 md:mb-0"><i class="fas fa-star mr-2 text-blue-500"></i> Poin Reputasi</span>
                        <span class="font-bold text-dark w-full text-right md:w-auto">1200 Poin</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="w-full md:w-1/3 flex flex-col gap-6">
            <div class="hover-1 h-2/3 bg-white p-4 rounded-playful-lg border-2 border-dark shadow-border-offset">
                <h3 class="text-h5 font-bold text-dark mb-4">Pengaturan Akun</h3>
                <div class="flex flex-col gap-4">
                    @unless(Auth::check() && in_array(Auth::user()->role->name, ['super_admin', 'admin', 'konselor']))
                    <a href="#" class="click-1 w-full px-4 py-2 bg-white text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-200 transition-all duration-200">
                        <i class="fas fa-user-tie mr-2 text-blue-500"></i> Ajukan Akun Profesional
                    </a>
                    @endunless
                    <a href="#" class="click-1 w-full px-4 py-2 bg-white text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-200 transition-all duration-200">
                        <i class="fas fa-envelope mr-2 text-orange-500"></i> Ganti Email
                    </a>
                    <a href="#" class="click-1 w-full px-4 py-2 bg-white text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-200 transition-all duration-200">
                        <i class="fas fa-key mr-2 text-gray-500"></i> Ganti Kata Sandi
                    </a>
                    <a href="#" class="click-1 w-full px-4 py-2 bg-red-500 text-white font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-red-600 transition-all duration-200">
                        <i class="fas fa-trash-alt mr-2"></i> Hapus Akun
                    </a>
                </div>
            </div>

            <div class="hover-1 md:h-1/3 h-auto bg-white p-4 rounded-playful-lg border-2 border-dark shadow-border-offset">
                <h3 class="text-h5 font-bold text-dark mb-4">Akses Cepat</h3>
                <div class="flex flex-col gap-4">
                    @if(Auth::check() && in_array(Auth::user()->role->name, ['super_admin', 'admin']))
                    <a href="{{ route('admin.dashboard') }}" class="click-1 w-full px-4 py-2 bg-secondary text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-yellow-300 transition-all duration-200">
                        <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Admin
                    </a>
                    @endif
                    @if(Auth::check() && Auth::user()->role->name == 'konselor')
                    <a href="{{ route('konselor.dashboard') }}" class="click-1 w-full px-4 py-2 bg-orange text-white font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-orange-600 transition-all duration-200">
                        <i class="fas fa-clipboard-list mr-2"></i> Dashboard Konselor
                    </a>
                    @endif
                    <a href="{{ route('user.profiles.edit', Auth::user()->name) }}" class="click-1 w-full px-4 py-2 bg-primary text-white font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600 transition-all duration-200">
                        <i class="fas fa-edit mr-2"></i> Edit Profil
                    </a>
                    <a href="#" class="click-1 w-full px-4 py-2 bg-white text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-200 transition-all duration-200">
                        <i class="fas fa-cog mr-2"></i> Pengaturan Akun
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endsection
