@extends('layouts.konselor')

@section('title', 'Dashboard Konselor')

@section('content')
<div class="container mx-auto px-6 py-8">
    
    <div class="mb-8">
        <h1 class="text-h2 font-bold text-dark">Dashboard Konselor</h1>
        <p class="text-gray-600 mt-1">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Klien Aktif</p>
                <p class="text-3xl font-bold text-dark">{{ $stats['active_clients'] ?? 0 }}</p>
            </div>
            <div class="bg-blue-100 text-blue-600 rounded-playful-sm border-2 border-dark p-3">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Sesi Minggu Ini</p>
                <p class="text-3xl font-bold text-dark">{{ $stats['sessions_this_week'] ?? 0 }}</p>
            </div>
            <div class="bg-green-100 text-green-600 rounded-playful-sm border-2 border-dark p-3">
                <i class="fas fa-calendar-check text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Pesan Belum Dibaca</p>
                <p class="text-3xl font-bold text-dark">{{ $stats['new_messages'] ?? 0 }}</p>
            </div>
            <div class="bg-yellow-100 text-yellow-600 rounded-playful-sm border-2 border-dark p-3">
                <i class="fas fa-envelope-open-text text-2xl"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Sesi Selesai</p>
                <p class="text-3xl font-bold text-dark">{{ $stats['completed_sessions'] ?? 0 }}</p>
            </div>
            <div class="bg-purple-100 text-purple-600 rounded-playful-sm border-2 border-dark p-3">
                <i class="fas fa-award text-2xl"></i>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <!-- Sesi Pending -->
            <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
                <h3 class="font-bold text-h4 text-dark mb-4">Permintaan Sesi (Menunggu Konfirmasi)</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="border-b-2 border-dark">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-dark uppercase">Klien</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-dark uppercase">Waktu Diajukan</th>
                                <th class="px-4 py-2 text-center text-xs font-bold text-dark uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($pendingSessions as $session)
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-3 font-semibold text-dark">{{ $session->user->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-gray-600">
                                        {{ \Carbon\Carbon::parse($session->scheduled_at ?? $session->created_at)->format('d M Y, H:i') }}
                                    </td>
                                    <td class="px-4 py-3 flex justify-center space-x-2">
                                        <form action="{{ route('konselor.sessions.accept', $session->id) }}" method="POST" class="inline">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-green-500 text-white rounded text-sm font-bold shadow-border-offset border border-dark hover:bg-green-600">
                                                <i class="fas fa-check"></i> Terima
                                            </button>
                                        </form>
                                        <form action="{{ route('konselor.sessions.reject', $session->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin menolak sesi ini? Token akan dikembalikan ke pengguna.')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded text-sm font-bold shadow-border-offset border border-dark hover:bg-red-600">
                                                <i class="fas fa-times"></i> Tolak
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-6 text-gray-500">
                                        <p>Tidak ada permintaan sesi saat ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Sesi Aktif -->
            <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
                <h3 class="font-bold text-h4 text-dark mb-4">Sesi Sedang Berjalan</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead class="border-b-2 border-dark">
                            <tr>
                                <th class="px-4 py-2 text-left text-xs font-bold text-dark uppercase">Klien</th>
                                <th class="px-4 py-2 text-left text-xs font-bold text-dark uppercase">Mulai</th>
                                <th class="px-4 py-2 text-center text-xs font-bold text-dark uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($ongoingSessions as $session)
                                <tr class="border-b border-gray-200">
                                    <td class="px-4 py-3 font-semibold text-dark">{{ $session->user->name ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ \Carbon\Carbon::parse($session->updated_at)->diffForHumans() }}</td>
                                    <td class="px-4 py-3 flex justify-center space-x-2">
                                        <a href="{{ route('chat') }}" class="px-3 py-1 bg-primary text-white rounded text-sm font-bold shadow-border-offset border border-dark hover:bg-opacity-90">
                                            <i class="fas fa-comment"></i> Chat
                                        </a>
                                        <form action="{{ route('konselor.sessions.end', $session->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin ingin mengakhiri sesi ini? Honor akan ditambahkan ke saldo Anda.')">
                                            @csrf
                                            <button type="submit" class="px-3 py-1 bg-yellow-500 text-white rounded text-sm font-bold shadow-border-offset border border-dark hover:bg-yellow-600">
                                                <i class="fas fa-stop"></i> Akhiri
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="text-center py-6 text-gray-500">
                                        <p>Tidak ada sesi yang sedang berjalan.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
                <h3 class="font-bold text-h4 text-dark mb-4">Akses Cepat</h3>
                <div class="flex flex-col gap-4">
                    <a href="#" class="w-full px-4 py-3 bg-primary text-white font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
                        <i class="fas fa-calendar-alt mr-2"></i> Lihat Kalender Lengkap
                    </a>
                    <a href="{{ route('chat') }}" class="w-full px-4 py-3 bg-white text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-200">
                        <i class="fas fa-comments mr-2"></i> Buka Pesan Klien
                    </a>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
                <h3 class="font-bold text-h4 text-dark mb-4">Aktivitas Terbaru</h3>
                <ul class="space-y-4">
                    @forelse ($recentActivities as $activity)
                         <li class="flex items-start space-x-3">
                            <div class="flex-shrink-0 pt-1">
                                <span class="inline-flex items-center justify-center h-6 w-6 rounded-full bg-blue-100 text-blue-600">
                                    <i class="fas fa-info text-xs"></i>
                                </span>
                            </div>
                            <div class="flex-1">
                                <p class="text-sm text-dark">{{ $activity->description }}</p>
                                <p class="text-xs text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                            </div>
                        </li>
                    @empty
                        <li class="text-center text-sm text-gray-500 py-4">
                            Tidak ada aktivitas terbaru.
                        </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection