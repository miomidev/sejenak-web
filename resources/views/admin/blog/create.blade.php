@extends('layouts.admin')

@section('title', 'Tambah Blog Baru')

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="flex justify-between items-center mb-8">
        <div>
            <h1 class="text-h2 font-bold text-dark">Tambah Blog Baru</h1>
            <p class="text-gray-600 mt-1">Buat artikel blog yang menarik untuk dibaca.</p>
        </div>
        <a href="{{ route('admin.blog.index') }}" class="px-6 py-3 bg-gray-200 text-dark font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-gray-300">
            Kembali
        </a>
    </div>

    <form action="{{ route('admin.blog.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="bg-white p-6 rounded-playful-sm border-2 border-dark shadow-border-offset mb-6">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                {{-- Kolom Kiri --}}
                <div class="lg:col-span-2 space-y-6">
                    {{-- Judul --}}
                    <div>
                        <label for="title" class="block text-sm font-bold text-dark mb-2">Judul Blog *</label>
                        <input type="text" id="title" name="title" value="{{ old('title') }}" 
                               class="w-full border-2 border-dark rounded-playful-sm p-3 focus:outline-none focus:ring-2 focus:ring-primary"
                               placeholder="Masukkan judul blog..." required>
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Konten SEDERHANA --}}
                    <div>
                        <label for="content" class="block text-sm font-bold text-dark mb-2">Konten *</label>
                        <textarea id="content" name="content" rows="20" 
                                  class="w-full border-2 border-dark rounded-playful-sm p-3 focus:outline-none focus:ring-2 focus:ring-primary"
                                  placeholder="Tulis konten blog di sini..." required>{{ old('content') }}</textarea>
                        @error('content')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-sm text-gray-500 mt-2">
                            Tips: Gunakan HTML sederhana untuk formatting seperti &lt;strong&gt;teks tebal&lt;/strong&gt;, &lt;em&gt;teks miring&lt;/em&gt;, &lt;ul&gt;&lt;li&gt;list&lt;/li&gt;&lt;/ul&gt;
                        </p>
                    </div>
                </div>

                {{-- Kolom Kanan --}}
                <div class="space-y-6">
                    {{-- Featured Image --}}
                    <div>
                        <label for="featured_image" class="block text-sm font-bold text-dark mb-2">Featured Image</label>
                        <div class="border-2 border-dashed border-dark rounded-playful-sm p-4 text-center">
                            <div id="image-preview" class="mb-3 hidden">
                                <img id="preview" class="max-w-full h-48 object-cover rounded-playful-sm border-2 border-dark mx-auto">
                            </div>
                            <input type="file" id="featured_image" name="featured_image" accept="image/*" 
                                   class="hidden" onchange="previewImage(this)">
                            <button type="button" onclick="document.getElementById('featured_image').click()" 
                                    class="px-4 py-2 bg-gray-200 border-2 border-dark rounded-playful-sm hover:bg-gray-300 transition-colors">
                                Pilih Gambar
                            </button>
                            <p class="text-xs text-gray-500 mt-2">Format: JPG, PNG, GIF (Max: 2MB)</p>
                        </div>
                        @error('featured_image')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label for="category_id" class="block text-sm font-bold text-dark mb-2">Kategori *</label>
                        <select id="category_id" name="category_id" 
                                class="w-full border-2 border-dark rounded-playful-sm p-3 focus:outline-none focus:ring-2 focus:ring-primary" required>
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Tags --}}
                    <div>
                        <label class="block text-sm font-bold text-dark mb-2">Tags</label>
                        <div class="border-2 border-dark rounded-playful-sm p-3 max-h-48 overflow-y-auto">
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center mr-3 mb-2">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                           class="rounded border-2 border-dark text-primary focus:ring-primary"
                                           {{ in_array($tag->id, old('tags', [])) ? 'checked' : '' }}>
                                    <span class="ml-2 text-sm">{{ $tag->name }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    {{-- Excerpt --}}
                    <div>
                        <label for="excerpt" class="block text-sm font-bold text-dark mb-2">Ringkasan</label>
                        <textarea id="excerpt" name="excerpt" rows="4" 
                                  class="w-full border-2 border-dark rounded-playful-sm p-3 focus:outline-none focus:ring-2 focus:ring-primary"
                                  placeholder="Ringkasan singkat tentang artikel...">{{ old('excerpt') }}</textarea>
                        @error('excerpt')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Publish Settings --}}
                    <div>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="is_published" value="1" 
                                   class="rounded border-2 border-dark text-primary focus:ring-primary"
                                   {{ old('is_published') ? 'checked' : '' }}>
                            <span class="ml-2 text-sm font-bold text-dark">Publikasikan Sekarang</span>
                        </label>
                        <p class="text-xs text-gray-500 mt-1">Jika tidak dicentang, artikel akan disimpan sebagai draft.</p>
                    </div>

                    {{-- Submit Button --}}
                    <div class="pt-4">
                        <button type="submit"
                                class="w-full px-6 py-3 bg-primary text-white font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600 transition-colors">
                            Simpan Blog
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@section('script')
<script>
    // Hanya image preview yang kita butuhkan
    function previewImage(input) {
        const preview = document.getElementById('preview');
        const previewContainer = document.getElementById('image-preview');
        
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endsection