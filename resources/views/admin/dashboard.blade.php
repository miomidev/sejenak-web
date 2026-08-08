@extends('layouts.admin')

@section('title', 'Dashboard Admin')

{{-- Menambahkan Font Awesome untuk ikon --}}
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('content')
<div class="container mx-auto px-6 py-8">
    
    <div class="mb-8">
        <h1 class="text-h2 font-bold text-dark">Dashboard</h1>
        <p class="text-gray-600 mt-1">Selamat datang kembali, {{ Auth::user()->name }}!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        
        <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Pengguna</p>
                <p class="text-3xl font-bold text-dark">{{ number_format($stats['total_users']) }}</p>
            </div>
            <div class="bg-blue-100 text-blue-600 rounded-playful-sm border-2 border-dark p-3">
                <i class="fas fa-users text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Konselor</p>
                <p class="text-3xl font-bold text-dark">{{ number_format($stats['total_counselors']) }}</p>
            </div>
            <div class="bg-green-100 text-green-600 rounded-playful-sm border-2 border-dark p-3">
                <i class="fas fa-user-tie text-2xl"></i>
            </div>
        </div>

        <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Total Audio</p>
                <p class="text-3xl font-bold text-dark">{{ number_format($stats['total_audios']) }}</p>
            </div>
            <div class="bg-yellow-100 text-yellow-600 rounded-playful-sm border-2 border-dark p-3">
                <i class="fas fa-music text-2xl"></i>
            </div>
        </div>
        
        <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6 flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-gray-500">Proposal Pending</p>
                <p class="text-3xl font-bold text-dark">{{ number_format($stats['pending_proposals']) }}</p>
            </div>
            <div class="bg-red-100 text-red-600 rounded-playful-sm border-2 border-dark p-3">
                <i class="fas fa-file-alt text-2xl"></i>
            </div>
        </div>

    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-8">
            
            <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
                <h3 class="font-bold text-h4 text-dark mb-4">Statistik Mood Mingguan</h3>
                <div class="space-y-4">
                    @forelse($moodStats as $mood => $count)
                        <div class="flex items-center">
                            <span class="w-20 capitalize text-dark font-semibold">{{ $mood }}</span>
                            <div class="flex-1 bg-gray-200 rounded-playful-sm h-5 border-2 border-dark">
                                @php
                                    $totalMoods = $moodStats->sum();
                                    $percentage = ($totalMoods > 0) ? ($count / $totalMoods) * 100 : 0;
                                @endphp
                                <div class="bg-primary h-full rounded-playful-sm-inner text-white text-xs flex items-center justify-center font-bold" style="width: {{ $percentage }}%;">
                                    {{ number_format($percentage, 0) }}%
                                </div>
                            </div>
                            <span class="w-12 text-right text-dark font-bold">{{ $count }}</span>
                        </div>
                    @empty
                        <p class="text-gray-500 text-center py-4">Belum ada data mood untuk minggu ini.</p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
                <h3 class="font-bold text-h4 text-dark mb-4">Transaksi Terbaru</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y-2 divide-dark">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Pengguna</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Jumlah</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($recentTransactions as $transaction)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-dark">{{ $transaction->user->name ?? 'N/A' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $transaction->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">Tidak ada transaksi terbaru.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <div class="lg:col-span-1 space-y-8">
            <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
                <h3 class="font-bold text-h4 text-dark mb-4">Pengguna Baru</h3>
                <ul class="divide-y divide-gray-200">
                    @forelse($recentUsers as $user)
                        <li class="py-3 flex items-center space-x-4">
                            <div class="flex-shrink-0">
                                <img class="h-10 w-10 rounded-full border-2 border-dark" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff" alt="">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-dark truncate">{{ $user->name }}</p>
                                <p class="text-sm text-gray-500 truncate">{{ $user->email }}</p>
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-playful-sm text-xs font-bold bg-blue-100 text-blue-800 border-2 border-dark capitalize">
                                {{ $user->role->name ?? 'User' }}
                            </span>
                        </li>
                    @empty
                        <li class="py-4 text-center text-gray-500">Tidak ada pengguna baru.</li>
                    @endforelse
                </ul>
            </div>

            <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
                <h3 class="font-bold text-h4 text-dark mb-4">Proposal Konselor Menunggu</h3>
                <ul class="divide-y divide-gray-200">
                    @forelse($recentProposals as $proposal)
                    <li class="py-3 flex items-center justify-between">
                        <div>
                            <p class="text-sm font-semibold text-dark">{{ $proposal->user->name ?? 'N/A' }}</p>
                            <p class="text-sm text-gray-500">Mengajukan pada {{ $proposal->created_at->format('d M Y') }}</p>
                        </div>
                        <a href="{{ route('admin.proposals.review', $proposal->id) }}" class="text-sm font-bold text-primary underline hover:text-green-700">Review</a>
                    </li>
                    @empty
                        <li class="py-4 text-center text-gray-500">Tidak ada proposal yang menunggu.</li>
                    @endforelse
                </ul>
            </div>

        </div>

    </div>

</div>
@endsection