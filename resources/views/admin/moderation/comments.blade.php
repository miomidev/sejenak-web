@extends('layouts.admin')

@section('title', 'Moderasi Komentar')

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
                <a href="{{ route('admin.moderation.posts') }}" class="py-3 px-1 border-b-4 border-transparent text-gray-500 hover:text-dark hover:border-gray-300 font-semibold">
                    Postingan
                </a>
                <a href="{{ route('admin.moderation.comments') }}" class="py-3 px-1 border-b-4 border-primary text-primary font-bold">
                    Komentar
                </a>
            </nav>
        </div>
    </div>

    <div class="bg-white p-4 sm:p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y-2 divide-dark">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Komentar</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Pengomentar</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Pada Postingan</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-dark uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($comments as $comment)
                        <tr>
                            <td class="px-6 py-4 max-w-sm">
                                <p class="text-sm text-gray-800 truncate">{{ $comment->content }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-semibold text-dark">{{ $comment->user->name }}</p>
                            </td>
                            <td class="px-6 py-4 max-w-xs">
                                <a href="#" class="text-sm text-blue-600 hover:underline truncate" title="{{ $comment->post->content ?? 'Postingan tidak ditemukan' }}">
                                    {{ Str::limit($comment->post->content ?? 'Postingan tidak ditemukan', 50) }}
                                </a>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <form action="{{ route('admin.comments.delete', $comment->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus komentar ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-3 py-1 bg-red-100 text-red-600 text-sm font-bold rounded-playful-sm border-2 border-dark hover:bg-red-200" title="Hapus">
                                        <i class="fas fa-trash-alt"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                <p class="font-semibold">Tidak ada komentar untuk dimoderasi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection