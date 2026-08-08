@extends('layouts.admin')

@section('title', 'Manajemen Blog')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-h2 font-bold text-dark">Manajemen Blog</h1>
            <p class="text-gray-600 mt-1">Kelola blog untuk memberikan informasi dan tips.</p>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="mt-4 sm:mt-0 inline-block px-6 py-3 bg-primary text-white font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
            <i class="fas fa-plus mr-2"></i> Tambah Blog Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-2 border-dark text-green-800 font-semibold px-4 py-3 rounded-playful-sm shadow-border-offset mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 sm:p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        
        {{-- Filter dan Search --}}
        <div class="flex flex-col sm:flex-row gap-4 mb-6">
            <div class="flex-1">
                <input type="text" id="search-input" placeholder="Cari judul blog..." 
                       class="w-full border-2 border-dark rounded-playful-sm p-2 focus:outline-none focus:ring-2 focus:ring-primary">
            </div>
            <select id="status-filter" class="border-2 border-dark rounded-playful-sm p-2 focus:outline-none focus:ring-2 focus:ring-primary">
                <option value="">Semua Status</option>
                <option value="published">Published</option>
                <option value="draft">Draft</option>
            </select>
        </div>

        {{-- Grid Blog Posts --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($posts as $post)
            <div class="bg-white border-2 border-dark rounded-playful-sm shadow-border-offset overflow-hidden hover:shadow-border-offset-accent transition-all">
                
                {{-- Featured Image --}}
                <div class="h-48 overflow-hidden">
                    @if($post->featured_image)
                        <img src="{{ asset('storage/' . $post->featured_image) }}" alt="{{ $post->title }}" 
                             class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                            <i class="fas fa-image text-gray-400 text-3xl"></i>
                        </div>
                    @endif
                </div>

                {{-- Badge Status --}}
                <div class="absolute top-4 right-4">
                    @if($post->is_published)
                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-bold border-2 border-dark">
                            Published
                        </span>
                    @else
                        <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-bold border-2 border-dark">
                            Draft
                        </span>
                    @endif
                </div>

                {{-- Content --}}
                <div class="p-4">
                    <h3 class="font-bold text-lg text-dark mb-2 line-clamp-2">{{ $post->title }}</h3>
                    
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs px-2 py-1 rounded-full border-2 border-dark" 
                              style="background-color: {{ $post->category->color }}; color: white;">
                            {{ $post->category->name }}
                        </span>
                        <span class="text-xs text-gray-500">{{ $post->reading_time }} min baca</span>
                    </div>

                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">{{ $post->excerpt ?? Str::limit(strip_tags($post->content), 100) }}</p>

                    <div class="flex items-center justify-between text-xs text-gray-500 mb-4">
                        <div class="flex items-center gap-1">
                            <i class="fas fa-user"></i>
                            <span>{{ $post->author->name }}</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <i class="fas fa-eye"></i>
                            <span>{{ $post->view_count }} views</span>
                        </div>
                        <div>
                            {{ $post->published_at?->format('d M Y') ?? 'Belum publish' }}
                        </div>
                    </div>

                    {{-- Action Buttons --}}
                    <div class="flex gap-2">
                        <a href="{{ route('user.blog.show', $post->slug) }}" target="_blank" 
                           class="flex-1 bg-blue-500 text-white text-center py-2 rounded-playful-sm border-2 border-dark hover:bg-blue-600 transition-colors text-sm">
                            <i class="fas fa-eye mr-1"></i> View
                        </a>
                        <a href="{{ route('admin.blog.edit', $post) }}" 
                           class="flex-1 bg-yellow-500 text-white text-center py-2 rounded-playful-sm border-2 border-dark hover:bg-yellow-600 transition-colors text-sm">
                            <i class="fas fa-edit mr-1"></i> Edit
                        </a>
                        <form action="{{ route('admin.blog.destroy', $post) }}" method="POST" class="flex-1">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin ingin menghapus blog ini?')" 
                                    class="w-full bg-red-500 text-white py-2 rounded-playful-sm border-2 border-dark hover:bg-red-600 transition-colors text-sm">
                                <i class="fas fa-trash mr-1"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-3 text-center py-12">
                <i class="fas fa-newspaper text-gray-400 text-6xl mb-4"></i>
                <h3 class="text-xl font-bold text-gray-600 mb-2">Belum ada blog</h3>
                <p class="text-gray-500 mb-4">Mulai buat blog pertama Anda</p>
                <a href="{{ route('admin.blog.create') }}" class="px-6 py-3 bg-primary text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
                    Buat Blog Pertama
                </a>
            </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($posts->hasPages())
        <div class="mt-8">
            {{ $posts->links() }}
        </div>
        @endif
    </div>
</div>
@endsection

@section('script')
<script>
    // Simple search and filter functionality
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search-input');
        const statusFilter = document.getElementById('status-filter');
        const blogCards = document.querySelectorAll('.grid > div');

        function filterBlogs() {
            const searchTerm = searchInput.value.toLowerCase();
            const statusValue = statusFilter.value;

            blogCards.forEach(card => {
                const title = card.querySelector('h3').textContent.toLowerCase();
                const status = card.querySelector('.absolute span').textContent.toLowerCase();
                
                const matchesSearch = title.includes(searchTerm);
                const matchesStatus = statusValue === '' || 
                    (statusValue === 'published' && status === 'published') ||
                    (statusValue === 'draft' && status === 'draft');

                if (matchesSearch && matchesStatus) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        }

        searchInput.addEventListener('input', filterBlogs);
        statusFilter.addEventListener('change', filterBlogs);
    });
</script>
@endsection