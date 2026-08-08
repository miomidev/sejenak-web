@extends('layouts.app')

@section('title', 'Blog')

@section('content')

<div class="w-full h-full grid grid-cols-1 md:grid-cols-3 gap-8 px-8 py-4">
    <main class="md:col-span-2 overflow-y-auto pr-4">
        <div class="w-full bg-white rounded-playful-lg border-2 border-dark shadow-border-offset p-6 flex flex-col gap-8">
            
            {{-- Bagian Header & Search --}}
            <div class="text-center">
                <h1 class="text-h2 md:text-h1 font-bold text-dark font-lexend">Sejenak Blog</h1>
                <p class="text-gray-600 mt-2 max-w-2xl mx-auto">Temukan artikel, tips, dan wawasan seputar kesehatan mental, meditasi, dan pengembangan diri.</p>
                <div class="relative max-w-md mx-auto mt-6">
                    <form action="{{ route('user.blog') }}" method="GET">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="Cari Artikel..." 
                               class="w-full border-2 border-dark rounded-playful-sm p-2 focus:outline-none focus:ring-2 focus:ring-primary">
                        <button type="submit" class="absolute top-1/2 right-3 -translate-y-1/2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.76l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </form>
                </div>
            </div>

            {{-- Garis pemisah visual --}}
            <hr class="border-dark border-t-2">

            {{-- Wrapper untuk daftar artikel --}}
            <div class="space-y-8">
                @forelse($posts as $post)
                <article class="flex flex-col md:flex-row gap-6 items-start">
                    <a href="{{ route('user.blog.show', $post->slug) }}" class="block w-full md:w-1/3 shrink-0">
                        @if($post->featured_image)
                            <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" 
                                 class="w-full h-40 object-cover rounded-playful-lg border-2 border-dark shadow-border-offset">
                        @else
                            <div class="w-full h-40 bg-gray-200 rounded-playful-lg border-2 border-dark shadow-border-offset flex items-center justify-center">
                                <i class="fas fa-newspaper text-gray-400 text-3xl"></i>
                            </div>
                        @endif
                    </a>
                    <div class="flex-1">
                        <p class="text-sm font-semibold mb-1" style="color: {{ $post->category->color }};">
                            {{ strtoupper($post->category->name) }}
                        </p>
                        <a href="{{ route('user.blog.show', $post->slug) }}">
                            <h2 class="text-xl font-bold text-dark mb-2 hover:text-primary-dark transition-colors">
                                {{ $post->title }}
                            </h2>
                        </a>
                        <p class="text-xs text-gray-500 mb-3">
                            Oleh {{ $post->author->name }} • {{ $post->published_at->translatedFormat('d F Y') }} • {{ $post->reading_time }} min baca
                        </p>
                        <p class="text-gray-700 text-sm leading-relaxed mb-4 hidden sm:block">
                            {{ $post->excerpt ?? Str::limit(strip_tags($post->content), 200) }}
                        </p>
                        <div class="flex items-center justify-between">
                            <a href="{{ route('user.blog.show', $post->slug) }}" class="font-bold text-primary hover:underline text-sm">
                                Baca Selengkapnya →
                            </a>
                            <div class="flex items-center gap-1 text-xs text-gray-500">
                                <i class="fas fa-eye"></i>
                                <span>{{ $post->view_count }}</span>
                            </div>
                        </div>
                    </div>
                </article>
                @empty
                <div class="text-center py-12">
                    <i class="fas fa-newspaper text-gray-400 text-6xl mb-4"></i>
                    <h3 class="text-xl font-bold text-gray-600 mb-2">Belum ada artikel</h3>
                    <p class="text-gray-500">Silakan kembali lagi nanti untuk membaca artikel terbaru.</p>
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
    </main>
    
    {{-- KOLOM KANAN (LEBAR 1/3) - SIDEBAR --}}
    <aside class="md:col-span-1 flex flex-col gap-8">
        {{-- Tentang Sejenak --}}
        <div class="bg-primary p-6 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="font-bold text-white text-lg mb-2">Tentang Sejenak</h3>
            <p class="text-sm text-gray-800">Sejenak adalah platform untuk membantumu menemukan ketenangan dan bertumbuh menjadi versi terbaik dirimu.</p>
        </div>
        
        {{-- Artikel Populer --}}
        <div class="bg-white p-6 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="font-bold text-dark text-lg mb-4">Artikel Populer</h3>
            <ul class="space-y-4 text-dark">
                @foreach($popularPosts as $popular)
                <li>
                    <a href="{{ route('user.blog.show', $popular->slug) }}" class="hover:text-primary transition-colors duration-200 flex items-start gap-2">
                        <span class="text-primary mt-1">-</span>
                        <span>{{ $popular->title }}</span>
                    </a>
                    <div class="text-xs text-gray-500 ml-4 mt-1">
                        {{ $popular->view_count }} views • {{ $popular->published_at->format('d M') }}
                    </div>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Kategori --}}
        <div class="bg-white p-6 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="font-bold text-dark text-lg mb-4">Kategori</h3>
            <ul class="space-y-2">
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('user.blog') }}?category={{ $category->id }}" 
                    class="flex justify-between items-center hover:text-primary transition-colors duration-200 
                            {{ request('category') == $category->id ? 'text-primary font-bold' : '' }}">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full border-2 border-dark" style="background-color: {{ $category->color }}"></span>
                            {{ $category->name }}
                        </span>
                        <span class="bg-gray-200 px-2 py-1 rounded-full text-xs border-2 border-dark">
                            {{ $category->published_posts_count }}
                        </span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </aside>
</div>
@endsection