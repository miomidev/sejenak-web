@extends('layouts.admin')

@section('title', 'Edit Pengguna')

@section('content')
<div class="container mx-auto px-6 py-8">
    
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h2 font-bold text-dark">Edit Pengguna</h1>
            <p class="text-gray-600 mt-1">Mengubah detail untuk: <span class="font-semibold">{{ $user->name }}</span></p>
        </div>
        <a href="{{ route('admin.users') }}" class="inline-block px-6 py-3 bg-gray-200 text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Kembali
        </a>
    </div>

    <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">
                <div>
                    <label for="name" class="block text-sm font-bold text-dark mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark" required>
                    @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="email" class="block text-sm font-bold text-dark mb-2">Alamat Email</label>
                    <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark" required>
                    @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="role_id" class="block text-sm font-bold text-dark mb-2">Peran (Role)</label>
                    <select id="role_id" name="role_id" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark bg-white" required>
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                
                <div>
                    <label for="tokens_balance" class="block text-sm font-bold text-dark mb-2">Saldo Token</label>
                    <input type="number" id="tokens_balance" name="tokens_balance" value="{{ old('tokens_balance', $user->tokens_balance) }}" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark" required>
                    @error('tokens_balance') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label for="is_suspended" class="block text-sm font-bold text-dark mb-2">Status Akun</label>
                    <select id="is_suspended" name="is_suspended" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark bg-white" required>
                        <option value="0" {{ old('is_suspended', $user->is_suspended) == 0 ? 'selected' : '' }}>Aktif</option>
                        <option value="1" {{ old('is_suspended', $user->is_suspended) == 1 ? 'selected' : '' }}>Suspended</option>
                    </select>
                    @error('is_suspended') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t-2 border-gray-100 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
                    <i class="fas fa-save mr-2"></i> Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection