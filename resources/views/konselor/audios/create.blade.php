@extends('layouts.konselor')

@section('title', 'Unggah Audio Baru')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h2 font-bold text-dark">Unggah Audio Baru</h1>
            <p class="text-gray-600 mt-1">Tambahkan audio baru ke dalam koleksi.</p>
        </div>
        <a href="{{ route('konselor.audios') }}" class="inline-block px-6 py-3 bg-gray-200 text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-300">
            <i class="fas fa-arrow-left mr-2"></i> Batal
        </a>
    </div>

    <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <form action="{{ route('konselor.audios.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-bold text-dark mb-2">Judul Audio</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark" required>
                        @error('title') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-6">
                        <label for="category" class="block text-sm font-bold text-dark mb-2">Kategori</label>
                        <select name="category" id="category" class="w-full px-4 py-2 rounded-playful-sm border-2 border-dark bg-white" required>
                            <option value="" disabled selected>Pilih kategori...</option>
                            @foreach($categories as $category)
                                <option value="{{ $category }}" {{ old('category') == $category ? 'selected' : '' }}>{{ ucfirst(str_replace('-', ' ', $category)) }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    
                    <div>
                        <label class="block text-sm font-bold text-dark mb-2">Status Audio</label>
                        <div class="flex items-center space-x-4">
                            <label class="flex items-center"><input type="radio" name="is_premium" value="0" class="mr-2" checked> Gratis</label>
                            <label class="flex items-center"><input type="radio" name="is_premium" value="1" class="mr-2"> Premium</label>
                        </div>
                        @error('is_premium') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div>
                    <label for="file_path" class="block text-sm font-bold text-dark mb-2">File Audio (MP3, WAV, OGG)</label>
                    <div class="mt-1 flex justify-center px-6 pt-5 pb-6 border-2 border-dark border-dashed rounded-playful-md">
                        <div class="space-y-1 text-center">
                            <i id="upload-icon" class="fas fa-cloud-upload-alt text-4xl text-gray-400 transition-colors"></i>
                            <div class="flex text-sm text-gray-600">
                                <label for="file_path" class="relative cursor-pointer bg-white rounded-md font-medium text-primary hover:text-green-700">
                                    <span id="upload-text">Unggah file</span>
                                    <input id="file_path" name="file_path" type="file" class="sr-only" required>
                                </label>
                                <p class="pl-1">atau seret dan lepas</p>
                            </div>
                            <p class="text-xs text-gray-500">Maksimal 10MB</p>
                            
                            {{-- Tambahan: Area untuk menampilkan nama file --}}
                            <p id="file-info" class="text-sm font-semibold text-green-600 pt-2"></p>
                        </div>
                    </div>
                    @error('file_path') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mt-8 pt-6 border-t-2 border-gray-100 flex justify-end">
                <button type="submit" class="px-8 py-3 bg-primary text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
                    <i class="fas fa-save mr-2"></i> Simpan Audio
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('file_path');
        const fileInfo = document.getElementById('file-info');
        const uploadText = document.getElementById('upload-text');
        const uploadIcon = document.getElementById('upload-icon');

        fileInput.addEventListener('change', function(event) {
            // Cek apakah ada file yang dipilih
            if (event.target.files.length > 0) {
                // Ambil nama file
                const fileName = event.target.files[0].name;

                // Tampilkan nama file di area yang disediakan
                fileInfo.textContent = 'File terpilih: ' + fileName;
                
                // Ubah teks tombol dan warna ikon sebagai feedback
                uploadText.textContent = 'Ganti file';
                uploadIcon.classList.remove('text-gray-400');
                uploadIcon.classList.add('text-primary');
            }
        });
    });
</script>
@endpush