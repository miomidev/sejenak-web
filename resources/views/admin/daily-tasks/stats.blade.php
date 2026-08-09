@extends('layouts.admin')

@section('content')
<div class="p-6">
    <h1 class="text-2xl font-bold font-exo2 text-dark mb-6">Statistik Daily Tasks</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4 mb-8">
        <div class="bg-white border-2 border-dark rounded-playful-lg p-4 shadow-border-offset-lg">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-primary flex items-center justify-center border-2 border-dark mr-3">
                    <i class="fas fa-list-check text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold font-exo2 text-dark">{{ $stats['total_generated'] }}</p>
                    <p class="text-xs text-gray-500 font-poppins">Total Generated</p>
                </div>
            </div>
        </div>

        <div class="bg-white border-2 border-dark rounded-playful-lg p-4 shadow-border-offset-lg">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-green-500 flex items-center justify-center border-2 border-dark mr-3">
                    <i class="fas fa-check-double text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold font-exo2 text-dark">{{ $stats['total_completed'] }}</p>
                    <p class="text-xs text-gray-500 font-poppins">Total Selesai</p>
                </div>
            </div>
        </div>

        <div class="bg-white border-2 border-dark rounded-playful-lg p-4 shadow-border-offset-lg">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-orange flex items-center justify-center border-2 border-dark mr-3">
                    <i class="fas fa-calendar-day text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold font-exo2 text-dark">{{ $stats['today_generated'] }}</p>
                    <p class="text-xs text-gray-500 font-poppins">Hari Ini Generated</p>
                </div>
            </div>
        </div>

        <div class="bg-white border-2 border-dark rounded-playful-lg p-4 shadow-border-offset-lg">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-purple flex items-center justify-center border-2 border-dark mr-3">
                    <i class="fas fa-calendar-check text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold font-exo2 text-dark">{{ $stats['today_completed'] }}</p>
                    <p class="text-xs text-gray-500 font-poppins">Hari Ini Selesai</p>
                </div>
            </div>
        </div>

        <div class="bg-white border-2 border-dark rounded-playful-lg p-4 shadow-border-offset-lg">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-full bg-yellow-500 flex items-center justify-center border-2 border-dark mr-3">
                    <i class="fas fa-coins text-white text-xl"></i>
                </div>
                <div>
                    <p class="text-2xl font-bold font-exo2 text-dark">{{ number_format($stats['total_points_awarded']) }}</p>
                    <p class="text-xs text-gray-500 font-poppins">Poin Diberikan</p>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white border-2 border-dark rounded-playful-lg p-6 shadow-border-offset-lg">
            <h2 class="text-xl font-bold font-exo2 text-dark mb-4">Task per Kategori</h2>
            <div class="space-y-3">
                @forelse($categoryStats as $stat)
                    <div class="flex items-center justify-between">
                        <span class="font-poppins capitalize">{{ str_replace('_', ' ', $stat->category) }}</span>
                        <span class="font-bold font-exo2 text-dark">{{ $stat->count }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 font-poppins text-center py-4">Belum ada data</p>
                @endforelse
            </div>
        </div>

        <div class="bg-white border-2 border-dark rounded-playful-lg p-6 shadow-border-offset-lg">
            <h2 class="text-xl font-bold font-exo2 text-dark mb-4">Task per Sumber</h2>
            <div class="space-y-3">
                @forelse($sourceStats as $stat)
                    <div class="flex items-center justify-between">
                        <span class="font-poppins capitalize">{{ $stat->source }}</span>
                        <span class="font-bold font-exo2 text-dark">{{ $stat->count }}</span>
                    </div>
                @empty
                    <p class="text-gray-500 font-poppins text-center py-4">Belum ada data</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
