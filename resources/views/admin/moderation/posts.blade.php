@extends('layouts.admin')

@section('title', 'Moderasi Postingan')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="mb-6">
        <h1 class="text-h2 font-bold text-dark">Moderasi Komunitas</h1>
        <p class="text-gray-600 mt-1">Kelola dan pantau konten yang dibuat oleh pengguna.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-2 border-dark text-green-800 font-semibold px-4 py-3 rounded-playful-sm shadow-border-offset mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-6">
        <div class="border-b-2 border-dark">
            <nav class="-mb-0.5 flex space-x-6">
                <a href="{{ route('admin.moderation.posts') }}" class="py-3 px-1 border-b-4 border-primary text-primary font-bold">
                    Postingan
                </a>
                <a href="{{ route('admin.moderation.comments') }}" class="py-3 px-1 border-b-4 border-transparent text-gray-500 hover:text-dark hover:border-gray-300 font-semibold">
                    Komentar
                </a>
            </nav>
        </div>
    </div>

    <div class="bg-white p-2 sm:p-4 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <div class="space-y-4">
            @forelse($posts as $post)
                <div class="p-4 rounded-playful-sm border-2 border-gray-200 hover:border-dark transition-colors duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <img class="h-10 w-10 rounded-full object-cover" src="https://ui-avatars.com/api/?name={{ urlencode($post->user->name) }}&background=random" alt="Avatar">
                            <div class="ml-3">
                                <p class="font-bold text-dark">{{ $post->user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $post->created_at->diffForHumans() }}</p>
                            </div>
                        </div>
                        @if($post->is_pinned)
                            <span class="px-3 py-1 text-xs font-bold bg-yellow-100 text-yellow-800 rounded-playful-sm border-2 border-dark"><i class="fas fa-thumbtack mr-1"></i> Disematkan</span>
                        @endif
                    </div>

                    <div class="mt-4 text-gray-800 whitespace-pre-wrap">{{ $post->content }}</div>
                    @if($post->image)
                        <div class="mt-3">
                            <img src="{{ asset('storage/' . $post->image) }}" class="max-h-80 rounded-playful-sm border-2 border-dark">
                        </div>
                    @endif

                    <div class="mt-4 flex items-center justify-between">
                        <div class="flex space-x-4 text-gray-500">
                            <span><i class="fas fa-heart mr-1"></i> {{ $post->likes->count() }} Suka</span>
                            <span><i class="fas fa-comment mr-1"></i> {{ $post->comments->count() }} Komentar</span>
                        </div>
                        <div class="flex space-x-2">
                            @if($post->is_pinned)
                                <form action="{{ route('admin.posts.unpin', $post->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-gray-200 text-dark text-sm font-bold rounded-playful-sm border-2 border-dark hover:bg-gray-300" title="Lepas Sematan">
                                        <i class="fas fa-thumbtack"></i>
                                    </button>
                                </form>
                            @else
                                <form action="{{ route('admin.posts.pin', $post->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="px-3 py-1 bg-yellow-100 text-yellow-800 text-sm font-bold rounded-playful-sm border-2 border-dark hover:bg-yellow-200" title="Sematkan">
                                        <i class="fas fa-thumbtack"></i>
                                    </button>
                                </form>
                            @endif
                            
                            <form action="{{ route('admin.posts.delete', $post->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus postingan ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 text-sm font-bold rounded-playful-sm border-2 border-dark hover:bg-red-200" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 text-gray-500">
                    <p class="font-semibold">Tidak ada postingan untuk dimoderasi.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection