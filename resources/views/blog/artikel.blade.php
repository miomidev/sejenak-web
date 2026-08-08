@extends('layouts.app')

@section('title', $post->title)

@section('content')
<div class="w-full h-full grid grid-cols-1 md:grid-cols-3 gap-8 px-8 py-4">
    <main class="md:col-span-2 overflow-y-auto pr-4">
        <div class="w-full bg-white rounded-playful-lg border-2 border-dark shadow-border-offset p-6 md:p-8 flex flex-col gap-6">

            {{-- 1. HEADER ARTIKEL --}}
            <header>
                <p class="text-sm font-semibold mb-2" style="color: {{ $post->category->color }};">
                    {{ strtoupper($post->category->name) }}
                </p>
                <h1 class="text-h2 md:text-h1 font-bold text-dark font-lexend mb-4 leading-tight">
                    {{ $post->title }}
                </h1>
                
                {{-- Info Penulis dan Tanggal --}}
                <div class="flex items-center gap-3 text-sm text-gray-500 border-t-2 border-b-2 border-dark py-3">
                    <div class="w-10 h-10 flex items-center justify-center rounded-full border-2 border-dark shadow-border-offset bg-blue-300 font-bold text-white">
                        {{ substr($post->author->name, 0, 2) }}
                    </div>
                    <div>
                        <span>Oleh <strong class="text-dark">{{ $post->author->name }}</strong></span>
                        <span class="mx-1">•</span>
                        <span>{{ $post->published_at->translatedFormat('d F Y') }}</span>
                        <span class="mx-1">•</span>
                        <span>{{ $post->reading_time }} min baca</span>
                        <span class="mx-1">•</span>
                        <span>{{ $post->view_count }} views</span>
                    </div>
                </div>
            </header>

            {{-- 2. GAMBAR UTAMA (FEATURED IMAGE) --}}
            <figure>
                @if($post->featured_image)
                    <img src="{{ Storage::url($post->featured_image) }}" alt="{{ $post->title }}" 
                         class="w-full h-auto object-cover rounded-playful-lg border-2 border-dark shadow-border-offset">
                @else
                    <div class="w-full h-64 bg-gray-200 rounded-playful-lg border-2 border-dark shadow-border-offset flex items-center justify-center">
                        <i class="fas fa-newspaper text-gray-400 text-5xl"></i>
                    </div>
                @endif
            </figure>

            {{-- 3. ISI KONTEN ARTIKEL --}}
            <article class="prose max-w-none text-gray-800 leading-relaxed">
                {!! $post->content !!}
            </article>

            {{-- 4. FOOTER ARTIKEL (TAGS & SHARE) --}}
            <footer class="border-t-2 border-dark pt-4 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-bold text-dark">Tags:</span>
                    @foreach($post->tags as $tag)
                    <a href="{{ route('user.blog') }}?tag={{ $tag->slug }}" 
                       class="text-sm bg-gray-200 text-dark px-2 py-1 rounded-playful-sm hover:bg-primary hover:text-white transition-colors">
                        #{{ $tag->name }}
                    </a>
                    @endforeach
                </div>
                <div class="flex items-center gap-2">
                    <span class="font-bold text-dark">Bagikan:</span>
                    {{-- Social Share Buttons --}}
                    <a href="https://twitter.com/intent/tweet?text={{ urlencode($post->title) }}&url={{ urlencode(url()->current()) }}" 
                       target="_blank" class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full hover:bg-primary hover:text-white transition-colors">
                        <i class="fab fa-twitter"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" 
                       target="_blank" class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full hover:bg-primary hover:text-white transition-colors">
                        <i class="fab fa-facebook-f"></i>
                    </a>
                    <a href="https://api.whatsapp.com/send?text={{ urlencode($post->title . ' ' . url()->current()) }}" 
                       target="_blank" class="w-8 h-8 flex items-center justify-center bg-gray-200 rounded-full hover:bg-primary hover:text-white transition-colors">
                        <i class="fab fa-whatsapp"></i>
                    </a>
                </div>
            </footer>

        </div>

        {{-- Artikel Terkait --}}
        @if($relatedPosts->count() > 0)
        <div class="mt-8 bg-white rounded-playful-lg border-2 border-dark shadow-border-offset p-6">
            <h3 class="text-xl font-bold text-dark mb-4">Artikel Terkait</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach($relatedPosts as $related)
                <article class="flex gap-4 items-start">
                    @if($related->featured_image)
                        <img src="{{ Storage::url($related->featured_image) }}" alt="{{ $related->title }}" 
                             class="w-20 h-20 object-cover rounded-playful-sm border-2 border-dark">
                    @else
                        <div class="w-20 h-20 bg-gray-200 rounded-playful-sm border-2 border-dark flex items-center justify-center">
                            <i class="fas fa-newspaper text-gray-400"></i>
                        </div>
                    @endif
                    <div>
                        <a href="{{ route('user.blog.show', $related->slug) }}" class="hover:text-primary transition-colors">
                            <h4 class="font-bold text-dark line-clamp-2">{{ $related->title }}</h4>
                        </a>
                        <p class="text-xs text-gray-500 mt-1">{{ $related->published_at->format('d M Y') }}</p>
                    </div>
                </article>
                @endforeach
            </div>
        </div>
        @endif
    </main>
    
    {{-- KOLOM KANAN (LEBAR 1/3) - SIDEBAR --}}
    <aside class="md:col-span-1 flex flex-col gap-8">
        {{-- Artikel Populer --}}
        <div class="bg-white p-6 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="font-bold text-dark text-lg mb-4">Artikel Populer</h3>
            <ul class="space-y-4 text-dark">
                @foreach($popularPosts as $popular)
                <li>
                    <a href="{{ route('user.blog.show', $popular->slug) }}" class="hover:text-primary transition-colors duration-200 flex items-start gap-2">
                        <span class="text-primary mt-1">-</span>
                        <span class="line-clamp-2">{{ $popular->title }}</span>
                    </a>
                    <div class="text-xs text-gray-500 ml-4 mt-1">
                        {{ $popular->view_count }} views
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
        
        {{-- Tentang Sejenak --}}
        <div class="bg-primary p-6 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="font-bold text-white text-lg mb-2">Tentang Sejenak</h3>
            <p class="text-sm text-gray-800">Sejenak adalah platform untuk membantumu menemukan ketenangan dan bertumbuh menjadi versi terbaik dirimu.</p>
        </div>

        {{-- Kategori --}}
        <div class="bg-white p-6 rounded-playful-lg border-2 border-dark shadow-border-offset">
            <h3 class="font-bold text-dark text-lg mb-4">Kategori</h3>
            <ul class="space-y-2">
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('user.blog') }}?category={{ $category->id }}" 
                       class="flex justify-between items-center hover:text-primary transition-colors duration-200">
                        <span class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full border-2 border-dark" style="background-color: {{ $category->color }}"></span>
                            {{ $category->name }}
                        </span>
                        <span class="bg-gray-200 px-2 py-1 rounded-full text-xs border-2 border-dark">
                            {{ $category->posts_count }}
                        </span>
                    </a>
                </li>
                @endforeach
            </ul>
        </div>
    </aside>
</div>
@endsection