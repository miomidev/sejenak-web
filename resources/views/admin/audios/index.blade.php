@extends('layouts.admin')

@section('title', 'Manajemen Audio')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <div>
            <h1 class="text-h2 font-bold text-dark">Manajemen Audio</h1>
            <p class="text-gray-600 mt-1">Kelola koleksi audio untuk meditasi dan relaksasi.</p>
        </div>
        <a href="{{ route('admin.audios.create') }}" class="mt-4 sm:mt-0 inline-block px-6 py-3 bg-primary text-white font-bold text-center rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
            <i class="fas fa-plus mr-2"></i> Unggah Audio Baru
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-2 border-dark text-green-800 font-semibold px-4 py-3 rounded-playful-sm shadow-border-offset mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 sm:p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        {{-- Di sini bisa ditambahkan filter jika diperlukan --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($audios as $audio)
                <div class="rounded-playful-sm border-2 border-dark shadow-border-offset flex flex-col">
                    <div class="bg-secondary text-white flex items-center justify-center h-40 rounded-t-playful-sm-inner">
                        <i class="fas fa-music text-5xl"></i>
                    </div>
                    
                    <div class="p-4 flex flex-col flex-grow">
                        <h4 class="font-bold text-dark truncate" title="{{ $audio->title }}">{{ $audio->title }}</h4>
                        <div class="my-2">
                            <span class="px-2 py-1 text-xs font-semibold rounded-full capitalize {{ $audio->is_premium ? 'bg-yellow-100 text-yellow-800' : 'bg-green-100 text-green-800' }}">
                                {{ $audio->is_premium ? 'Premium' : 'Gratis' }}
                            </span>
                             <span class="px-2 py-1 text-xs font-semibold rounded-full capitalize bg-blue-100 text-blue-800">
                                {{ $audio->category }}
                            </span>
                        </div>
                        
                        <audio controls class="w-full my-2">
                            <source src="{{ asset('storage/' . $audio->file_path) }}" type="audio/mpeg">
                            Browser Anda tidak mendukung elemen audio.
                        </audio>

                        <div class="mt-auto pt-4 flex justify-end space-x-2">
                            <a href="{{ route('admin.audios.edit', $audio->id) }}" class="inline-flex items-center justify-center w-9 h-9 bg-blue-100 text-blue-600 rounded-playful-sm border-2 border-dark hover:bg-blue-200" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.audios.delete', $audio->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus audio ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-9 h-9 bg-red-100 text-red-600 rounded-playful-sm border-2 border-dark hover:bg-red-200" title="Hapus">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-1 sm:col-span-2 md:col-span-3 lg:col-span-4 text-center py-16 text-gray-500">
                    <p class="font-semibold">Belum ada audio yang diunggah.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $audios->links() }}
        </div>
    </div>
</div>
@endsection