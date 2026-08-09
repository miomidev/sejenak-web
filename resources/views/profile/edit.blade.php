@extends('layouts.app')

@section('title', 'Edit Profil')

@section('content')
<div id="main-profile-page" class="h-full w-full flex items-start justify-center px-4 py-4 md:py-4 overflow-y-auto">
    <div class="bg-background flex flex-col md:flex-row w-full md:p-4 md:gap-4 gap-3 md:h-full">

        <!-- Container untuk Judul -->
        <div class="click-1 w-full md:w-1/5 bg-white border-2 border-dark rounded-playful-md shadow-border-offset p-4 md:p-6 transition-all duration-300 transform flex flex-col justify-center">
            <h1 class="text-2xl md:text-3xl font-bold text-dark text-center mb-2">Edit Profil</h1>
            <p class="text-center text-sm text-gray-600">Perbarui informasi dan biodata Anda.</p>
        </div>

        <!-- Message Box -->
        <div id="success-message" class="hidden p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 shadow-border-offset" role="alert">
          <span class="font-medium">Profil berhasil diperbarui!</span>
        </div>

        <form id="profile-form" action="{{ route('user.profiles.update') }}" method="POST" enctype="multipart/form-data" class="w-full md:w-4/5 flex flex-col gap-4 md:h-full">
            @csrf
            @method('PATCH')

            <!-- Container Utama: Dua Kolom untuk Avatar & Bio -->
            <div class="flex flex-col md:flex-row gap-4 flex-1 min-h-0">
                <!-- Kolom Kiri: Avatar dan Informasi Dasar -->
                <div class="click-1 bg-white border-2 border-dark rounded-playful-md shadow-border-offset p-4 md:p-6 flex-1 transition-all duration-300 overflow-y-auto">
                    <h2 class="text-xl font-bold text-dark mb-3">Informasi Dasar</h2>

                    <!-- Avatar Section -->
                    <div class="flex flex-col items-center justify-center gap-3 mb-4">
                        <div class="relative w-28 h-28 md:w-32 md:h-32 rounded-full border-2 border-dark overflow-hidden shadow-border-offset transition-transform duration-300 hover:scale-110">
                            <img id="avatar-preview" src="{{ $user->avatar_url ?? 'https://placehold.co/160x160/FFB340/080330?text=Avatar' }}" alt="Avatar Pengguna" class="w-full h-full object-cover">
                            <label for="avatar-input" class="absolute inset-0 bg-black bg-opacity-50 flex items-center justify-center cursor-pointer opacity-0 hover:opacity-100 transition-opacity duration-300">
                                <i class="fas fa-camera text-white text-2xl"></i>
                            </label>
                            <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*">
                        </div>
                        <div class="text-center">
                            <label for="avatar-input" class="text-sm text-dark font-semibold cursor-pointer hover:underline">Unggah Foto Profil</label>
                            <p class="mt-1 text-xs text-gray-500">Ukuran maksimal 2MB. Format: JPG, PNG, GIF.</p>
                        </div>
                    </div>

                    <!-- Nama & Email Fields -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="name" class="block text-sm font-semibold text-gray-700">Nama</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full border-2 border-dark rounded-playful-md p-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div>
                            <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full border-2 border-dark rounded-playful-md p-3 bg-gray-100 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm cursor-not-allowed" value="{{ $user->email }}" disabled>
                            <p class="mt-1 text-xs text-gray-500">Email tidak bisa diubah.</p>
                        </div>
                    </div>
                </div>

                <!-- Kolom Kanan: Bio -->
                <div class="click-1 bg-white border-2 border-dark rounded-playful-md shadow-border-offset p-4 md:p-6 flex-1 transition-all duration-300 flex flex-col">
                    <h2 class="text-xl font-bold text-dark mb-3">Tentang Saya</h2>
                    <label for="bio" class="block text-sm font-semibold text-gray-700 mb-1">Bio</label>
                    <textarea id="bio" name="bio" class="flex-1 block w-full border-2 border-dark rounded-playful-md p-3 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm resize-none" style="min-height: 150px;">{{ old('bio', $user->bio) }}</textarea>
                </div>
            </div>

            <!-- Container untuk Tombol Simpan -->
            <div class="click-1 bg-white border-2 border-dark rounded-playful-md shadow-border-offset p-4 transition-all duration-300 flex-shrink-0">
                <div class="flex justify-end">
                    <button type="submit" class="click-1 w-full md:w-auto px-8 py-3 bg-primary text-dark font-bold rounded-playful-md border-2 border-dark shadow-border-offset hover:bg-primary/80 transition-all duration-200 active:shadow-none active:translate-x-1 active:translate-y-1">
                        <i class="fas fa-save mr-2"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const avatarInput = document.getElementById('avatar-input');
        const avatarPreview = document.getElementById('avatar-preview');
        const profileForm = document.getElementById('profile-form');
        const successMessage = document.getElementById('success-message');

        // Handle avatar preview
        avatarInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarPreview.src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });

        // Handle form submission (client-side)
        profileForm.addEventListener('submit', function(event) {
            console.log('Mengirim data profil...');
            successMessage.classList.remove('hidden');
            setTimeout(() => {
                successMessage.classList.add('hidden');
            }, 3000);
        });
    });
</script>
@endsection
