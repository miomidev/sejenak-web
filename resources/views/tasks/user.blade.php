@extends('layouts.app')

@section('content')
<div class="flex flex-col items-center w-full h-full p-4 md:p-0 overflow-y-auto">
    <div class="text-center my-8 md:my-12 relative w-full max-w-2xl">
        <h1 class="text-4xl md:text-5xl font-bold font-exo2 text-dark text-shadow-h1">Daily Task</h1>
        <p class="text-lg md:text-xl text-gray-600 mt-2 font-poppins text-shadow-soft">
            {{ \Carbon\Carbon::parse($date)->translatedFormat('l, d F Y') }}
        </p>
        <div class="absolute top-1/2 left-0 transform -translate-y-1/2 -translate-x-full md:left-auto md:right-0 md:translate-x-full -z-10">
            <i class="fas fa-star text-6xl text-purple opacity-20"></i>
        </div>
        <div class="absolute bottom-0 right-0 transform translate-x-1/2 translate-y-1/2 -z-10">
            <i class="fas fa-check-double text-8xl text-orange opacity-20"></i>
        </div>
    </div>

    @if(session('success'))
        <div class="w-full max-w-2xl mb-4 bg-green-100 border-2 border-green-500 rounded-playful-lg p-4 text-green-700 font-poppins">
            <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="w-full max-w-2xl mb-4 bg-red-100 border-2 border-red-500 rounded-playful-lg p-4 text-red-700 font-poppins">
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 md:gap-8 w-full max-w-6xl">
        <div class="md:col-span-2 space-y-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold font-exo2 text-dark">Daftar Task Hari Ini</h2>
                <form action="{{ route('user.daily-tasks.generate') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="bg-primary text-white px-4 py-2 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-primary-dark transition-all duration-200 hover:scale-105 text-sm">
                        <i class="fas fa-sync-alt mr-1"></i> Generate Ulang
                    </button>
                </form>
            </div>

            <div class="space-y-6 max-h-[600px] overflow-y-auto pr-2">
                @forelse($tasks as $task)
                    <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col shadow-border-offset-lg {{ $task['status'] === 'completed' ? 'opacity-70' : '' }}">
                        <div class="flex items-center justify-between mb-4">
                            <h3 class="text-xl font-bold font-exo2 text-dark">
                                @switch($task['category'])
                                    @case('daily_activity')
                                        <i class="fas fa-calendar-check text-primary mr-2"></i>
                                        @break
                                    @case('mental_recovery')
                                        <i class="fas fa-heart text-red-500 mr-2"></i>
                                        @break
                                    @case('brain_refresh')
                                        <i class="fas fa-brain text-purple mr-2"></i>
                                        @break
                                    @case('physical_health')
                                        <i class="fas fa-dumbbell text-green-500 mr-2"></i>
                                        @break
                                    @case('time_management')
                                        <i class="fas fa-clock text-blue-500 mr-2"></i>
                                        @break
                                    @case('self_discipline')
                                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                                        @break
                                    @case('social_interaction')
                                        <i class="fas fa-users text-orange mr-2"></i>
                                        @break
                                    @case('mindfulness')
                                        <i class="fas fa-spa text-green-600 mr-2"></i>
                                        @break
                                    @case('habit_building')
                                        <i class="fas fa-layer-group text-blue-600 mr-2"></i>
                                        @break
                                    @case('self_reflection')
                                        <i class="fas fa-search text-purple mr-2"></i>
                                        @break
                                    @default
                                        <i class="fas fa-star text-yellow-400 mr-2"></i>
                                @endswitch
                                {{ $task['title'] }}
                            </h3>
                            @if($task['status'] === 'completed')
                                <span class="bg-green-500 text-white text-xs font-bold py-1 px-3 rounded-full">Selesai</span>
                            @elseif($task['status'] === 'in_progress')
                                <span class="bg-primary text-white text-xs font-bold py-1 px-3 rounded-full">Berjalan</span>
                            @else
                                <span class="bg-gray-400 text-white text-xs font-bold py-1 px-3 rounded-full">Belum Dimulai</span>
                            @endif
                        </div>
                        <p class="text-base text-gray-700 font-poppins mb-4">{{ $task['description'] }}</p>
                        <div class="flex items-center justify-between mb-2">
                            <span class="text-sm text-gray-500 font-poppins">
                                <i class="fas fa-trophy text-yellow-400 mr-1"></i> {{ $task['points'] }} poin
                            </span>
                            <span class="text-sm text-gray-500 font-poppins capitalize">
                                <i class="fas fa-tag mr-1"></i> {{ str_replace('_', ' ', $task['category']) }}
                            </span>
                        </div>
                        @if($task['status'] !== 'completed')
                            <form action="{{ route('user.daily-tasks.complete', $task['id']) }}" method="POST">
                                @csrf
                                <button type="submit" class="w-full bg-primary text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-primary-dark transition-all duration-200 hover:scale-105">
                                    <i class="fas fa-check mr-2"></i> Selesaikan Task
                                </button>
                            </form>
                        @else
                            <button class="w-full bg-gray-400 text-white p-3 rounded-playful-sm font-bold border-2 border-dark cursor-not-allowed">
                                <i class="fas fa-check-double mr-2"></i> Sudah Selesai
                            </button>
                        @endif
                    </div>
                @empty
                    <div class="bg-white border-2 border-dark rounded-playful-lg p-8 text-center shadow-border-offset-lg">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold font-exo2 text-dark mb-2">Belum Ada Task</h3>
                        <p class="text-gray-500 font-poppins mb-4">Task harianmu akan di-generate otomatis. Klik tombol Generate Ulang untuk membuat task baru.</p>
                    </div>
                @endforelse
            </div>
        </div>

        <div class="space-y-6 mt-6 md:mt-0">
            <div>
                <h2 class="text-2xl font-bold font-exo2 text-dark mb-4">Capaian Hari Ini</h2>
                <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col items-center text-center shadow-border-offset-lg">
                    <div class="flex-shrink-0 w-24 h-24 rounded-full bg-primary flex items-center justify-center border-2 border-dark shadow-border-offset-accent mb-4">
                        <i class="fas fa-medal text-5xl text-white"></i>
                    </div>
                    <h3 class="text-xl md:text-2xl font-bold font-exo2 text-dark mb-1">
                        {{ $stats['today_completed'] }} / {{ $stats['today_total'] }}
                    </h3>
                    <p class="text-base text-gray-700 font-poppins mb-4">Task Selesai</p>
                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                        @php
                            $progress = $stats['today_total'] > 0 
                                ? ($stats['today_completed'] / $stats['today_total']) * 100 
                                : 0;
                        @endphp
                        <div class="bg-green-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ $progress }}%;"></div>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-2xl font-bold font-exo2 text-dark mb-4">Statistik</h2>
                <div class="space-y-4">
                    <div class="bg-white border-2 border-dark rounded-playful-sm p-4 flex items-center shadow-border-offset-sm">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-orange flex items-center justify-center border-2 border-dark mr-4">
                            <i class="fas fa-fire text-2xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold font-exo2 text-dark">{{ $stats['week_completed'] }}</h4>
                            <p class="text-sm text-gray-500">Task Minggu Ini</p>
                        </div>
                    </div>
                    <div class="bg-white border-2 border-dark rounded-playful-sm p-4 flex items-center shadow-border-offset-sm">
                        <div class="flex-shrink-0 w-12 h-12 rounded-full bg-purple flex items-center justify-center border-2 border-dark mr-4">
                            <i class="fas fa-coins text-2xl text-white"></i>
                        </div>
                        <div>
                            <h4 class="font-bold font-exo2 text-dark">{{ $stats['total_points'] }}</h4>
                            <p class="text-sm text-gray-500">Total Poin</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
