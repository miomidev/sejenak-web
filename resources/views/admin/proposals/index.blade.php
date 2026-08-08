@extends('layouts.admin')

@section('title', 'Manajemen Proposal')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="mb-8">
        <h1 class="text-h2 font-bold text-dark">Manajemen Proposal Konselor</h1>
        <p class="text-gray-600 mt-1">Review dan kelola pengajuan untuk menjadi konselor.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-2 border-dark text-green-800 font-semibold px-4 py-3 rounded-playful-sm shadow-border-offset mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 sm:p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y-2 divide-dark">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Pemohon</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Tanggal Diajukan</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-dark uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-dark uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($proposals as $proposal)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-semibold text-dark">{{ $proposal->user->name ?? 'Pengguna tidak ditemukan' }}</div>
                                <div class="text-sm text-gray-500">{{ $proposal->user->email ?? 'N/A' }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                {{ $proposal->created_at->format('d F Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-playful-sm border-2 border-dark capitalize
                                    @if($proposal->status == 'approved') bg-green-100 text-green-800
                                    @elseif($proposal->status == 'rejected') bg-red-100 text-red-800
                                    @else bg-yellow-100 text-yellow-800 @endif">
                                    {{ $proposal->status }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.proposals.review', $proposal->id) }}" class="inline-block px-4 py-2 bg-primary text-white font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
                                    <i class="fas fa-search mr-2"></i> Review
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <i class="fas fa-ghost text-4xl text-gray-300 mb-4"></i>
                                <p class="font-semibold">Tidak ada proposal yang ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $proposals->links() }}
        </div>
    </div>
</div>
@endsection