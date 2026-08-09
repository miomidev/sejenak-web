@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="mb-6">
        <a href="{{ route('admin.task-templates') }}" class="text-primary hover:underline font-poppins">
            <i class="fas fa-arrow-left mr-1"></i> Kembali
        </a>
        <h1 class="text-2xl font-bold font-exo2 text-dark mt-2">Tambah Task Template</h1>
    </div>

    <div class="bg-white border-2 border-dark rounded-playful-lg shadow-border-offset-lg p-6 max-w-2xl">
        <form action="{{ route('admin.task-templates.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold font-exo2 text-dark mb-2">Judul</label>
                <input type="text" name="title" value="{{ old('title') }}" 
                    class="w-full border-2 border-dark rounded-playful-sm px-4 py-2 font-poppins focus:outline-none focus:border-primary"
                    required>
                @error('title')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-bold font-exo2 text-dark mb-2">Deskripsi</label>
                <textarea name="description" rows="3"
                    class="w-full border-2 border-dark rounded-playful-sm px-4 py-2 font-poppins focus:outline-none focus:border-primary">{{ old('description') }}</textarea>
                @error('description')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-bold font-exo2 text-dark mb-2">Kategori</label>
                    <select name="category" class="w-full border-2 border-dark rounded-playful-sm px-4 py-2 font-poppins focus:outline-none focus:border-primary" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat }}" {{ old('category') === $cat ? 'selected' : '' }}>
                                {{ str_replace('_', ' ', ucfirst($cat)) }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold font-exo2 text-dark mb-2">Tipe</label>
                    <select name="type" class="w-full border-2 border-dark rounded-playful-sm px-4 py-2 font-poppins focus:outline-none focus:border-primary" required>
                        <option value="in_app" {{ old('type') === 'in_app' ? 'selected' : '' }}>In-App</option>
                        <option value="off_app" {{ old('type') === 'off_app' ? 'selected' : '' }}>Off-App</option>
                    </select>
                    @error('type')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-bold font-exo2 text-dark mb-2">Mood Trigger (Opsional)</label>
                    <select name="mood_trigger" class="w-full border-2 border-dark rounded-playful-sm px-4 py-2 font-poppins focus:outline-none focus:border-primary">
                        <option value="">Semua Mood</option>
                        <option value="happy" {{ old('mood_trigger') === 'happy' ? 'selected' : '' }}>Happy</option>
                        <option value="sad" {{ old('mood_trigger') === 'sad' ? 'selected' : '' }}>Sad</option>
                        <option value="anxious" {{ old('mood_trigger') === 'anxious' ? 'selected' : '' }}>Anxious</option>
                        <option value="stressed" {{ old('mood_trigger') === 'stressed' ? 'selected' : '' }}>Stressed</option>
                        <option value="calm" {{ old('mood_trigger') === 'calm' ? 'selected' : '' }}>Calm</option>
                        <option value="angry" {{ old('mood_trigger') === 'angry' ? 'selected' : '' }}>Angry</option>
                        <option value="tired" {{ old('mood_trigger') === 'tired' ? 'selected' : '' }}>Tired</option>
                        <option value="energetic" {{ old('mood_trigger') === 'energetic' ? 'selected' : '' }}>Energetic</option>
                        <option value="relaxed" {{ old('mood_trigger') === 'relaxed' ? 'selected' : '' }}>Relaxed</option>
                    </select>
                    @error('mood_trigger')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label class="block text-sm font-bold font-exo2 text-dark mb-2">Poin</label>
                    <input type="number" name="points" value="{{ old('points', 10) }}" min="1" max="100"
                        class="w-full border-2 border-dark rounded-playful-sm px-4 py-2 font-poppins focus:outline-none focus:border-primary"
                        required>
                    @error('points')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mb-6">
                <label class="flex items-center">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}
                        class="rounded border-dark text-primary focus:ring-primary">
                    <span class="ml-2 text-sm font-poppins">Aktif</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-primary text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-primary-dark transition-all">
                <i class="fas fa-save mr-2"></i> Simpan Template
            </button>
        </form>
    </div>
</div>
@endsection
