@extends('layouts.admin')

@section('title', 'Aktivitas Pengguna')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h2 font-bold text-dark">Aktivitas Pengguna</h1>
            <p class="text-gray-600 mt-1">Menampilkan log aktivitas untuk: <span class="font-semibold">{{ $user->name }}</span></p>
        </div>
        <a href="{{ route('admin.users') }}" class="inline-block px-6 py-3 bg-gray-200 text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <div class="space-y-6">
            @forelse($activities as $activity)
                <div class="flex items-start space-x-4">
                    <div class="flex-shrink-0 w-12 h-12 flex items-center justify-center rounded-playful-sm border-2 border-dark
                        @if($activity['type'] == 'post') bg-blue-100 text-blue-600
                        @elseif($activity['type'] == 'comment') bg-green-100 text-green-600
                        @elseif($activity['type'] == 'mood') bg-yellow-100 text-yellow-600
                        @endif">
                        
                        @if($activity['type'] == 'post') <i class="fas fa-file-alt text-xl"></i>
                        @elseif($activity['type'] == 'comment') <i class="fas fa-comments text-xl"></i>
                        @elseif($activity['type'] == 'mood') <i class="fas fa-smile text-xl"></i>
                        @endif
                    </div>

                    <div class="flex-1">
                        <div class="flex justify-between items-center">
                            <p class="font-bold text-dark capitalize">{{ $activity['type'] }}</p>
                            <p class="text-xs text-gray-500">{{ $activity['created_at']->diffForHumans() }}</p>
                        </div>
                        <p class="text-sm text-gray-700 mt-1 italic">
                            "{{ $activity['content'] }}"
                        </p>
                        @if($activity['url'])
                            <a href="{{ $activity['url'] }}" target="_blank" class="text-xs text-primary font-semibold mt-2 inline-block hover:underline">
                                Lihat Detail <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <i class="fas fa-ghost text-4xl text-gray-300 mb-4"></i>
                    <p class="text-gray-500 font-semibold">Pengguna ini belum memiliki aktivitas.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
@endsection