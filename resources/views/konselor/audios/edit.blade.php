@extends('layouts.admin')

@section('title', 'Edit Audio')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h2 font-bold text-dark">Edit Audio</h1>
            <p class="text-gray-600 mt-1">Mengubah detail untuk: <span class="font-semibold">{{ $audio->title }}</span></p>
        </div>
        <a href="{{ route('admin.audios') }}" class="inline-block px-6 py-3 bg-gray-200 text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Batal
        </a>
    </div>

    <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <form action="{{ route('admin.audios.update', $audio->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-bold text-dark mb-2">Judul Audio</label>
                        <input type="text" name="title" id="title" value="{{ old('title', $audio->title) }}" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark" required>
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="category" class="block text-sm font-bold text-dark mb-2">Kategori</label>
                        <select name="category" id="category" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark bg-white" required>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category', $audio->category) == $category ? 'selected' : '' }}>{{ ucfirst(str_replace('-', ' ', $category)) }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-dark mb-2">Status Audio</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center"><input type="radio" name="is_premium" value="0" class="mr-2" {{ old('is_premium', $audio->is_premium) == 0 ? 'checked' : '' }}> Gratis</label>
                            <label class="flex items-center"><input type="radio" name="is_premium" value="1" class="mr-2" {{ old('is_premium', $audio->is_premium) == 1 ? 'checked' : '' }}> Premium</label>
                        </div>
                        @error('is_premium') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="file_path" class="block text-sm font-bold text-dark mb-2">Ganti File Audio (Opsional)</label>
                    <div class="mt-2 p-4 border-2 border-dark rounded-playful-sm">
                        <p class="text-sm font-semibold text-dark">File Saat Ini:</p>
                        <audio controls class="w-full mt-2">
                            <source src="{{ asset('storage/' . $audio->file_path) }}" type="audio/mpeg">
                        </audio>
                    </div>
                    <div class="mt-4">
                         <input id="file_path" name="file_path" type="file" class="w-full text-sm text-dark file:mr-4 file:py-2 file:px-4 file:rounded-playful-sm file:border-2 file:border-dark file:font-bold file:bg-gray-100 file:text-dark hover:file:bg-gray-200">
                         <small class="text-gray-500">Kosongkan jika tidak ingin mengganti file audio.</small>
                    </div>
                    @error('file_path') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
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