@extends('layouts.admin')

@section('title', 'Manajemen Pengguna')

@section('content')
<div class="container mx-auto px-6 py-8">
    
    <div class="mb-8">
        <h1 class="text-h2 font-bold text-dark">Manajemen Pengguna</h1>
        <p class="text-gray-600 mt-1">Kelola semua pengguna terdaftar di platform.</p>
    </div>
    
    @if(session('success'))
        <div class="bg-green-100 border-2 border-dark text-green-800 font-semibold px-4 py-3 rounded-playful-sm shadow-border-offset mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 sm:p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <form method="GET" action="{{ route('admin.users') }}" class="mb-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark focus:ring-primary focus:border-primary">
                </div>
                <div>
                    <select name="role" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark focus:ring-primary focus:border-primary bg-white">
                        <option value="">Semua Peran</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>{{ ucfirst($role->name) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-center space-x-2">
                    <button type="submit" class="w-full px-4 py-2 bg-primary text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    <a href="{{ route('admin.users') }}" class="w-full text-center px-4 py-2 bg-gray-200 text-dark font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-300">
                        Reset
                    </a>
                </div>
            </div>
        </form>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y-2 divide-dark">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Peran</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-dark uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-dark uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($users as $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    {{-- Tambahan: Menampilkan Avatar --}}
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-full border-2 border-dark" src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random&color=fff" alt="{{ $user->name }}">
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-dark">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-playful-sm border-2 border-dark capitalize bg-blue-100 text-blue-800">
                                    {{ $user->role->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                @if($user->is_suspended)
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-playful-sm border-2 border-dark bg-red-100 text-red-800">
                                        Suspended
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-playful-sm border-2 border-dark bg-green-100 text-green-800">
                                        Aktif
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                                <a href="{{ route('admin.users.activity', $user->id) }}" class="inline-flex items-center justify-center w-9 h-9 bg-purple-100 text-purple-600 rounded-playful-sm border-2 border-dark hover:bg-purple-200" title="Lihat Aktivitas">
                                    <i class="fas fa-history"></i>
                                </a>
                                <a href="{{ route('admin.users.edit', $user->id) }}" class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 text-blue-600 rounded-playful-sm border-2 border-dark hover:bg-blue-200" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                
                                {{-- Tambahan: Proteksi agar tidak bisa suspend diri sendiri --}}
                                @if(Auth::id() !== $user->id)
                                    @if($user->is_suspended)
                                        <form action="{{ route('admin.users.unsuspend', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Aktifkan kembali pengguna ini?');">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-green-100 text-green-600 rounded-playful-sm border-2 border-dark hover:bg-green-200" title="Unsuspend">
                                                <i class="fas fa-check-circle"></i>
                                            </button>
                                        </form>
                                    @else
                                        <form action="{{ route('admin.users.suspend', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menangguhkan pengguna ini?');">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-red-100 text-red-600 rounded-playful-sm border-2 border-dark hover:bg-red-200" title="Suspend">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                        </form>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <p class="font-semibold">Tidak ada data pengguna ditemukan.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{-- Tambahan: Agar filter tetap aktif saat pindah halaman --}}
            {{ $users->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection