@extends('layouts.admin')

@section('content')
<div class="p-6">
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-bold font-exo2 text-dark">Task Templates</h1>
        <a href="{{ route('admin.task-templates.create') }}" class="bg-primary text-white px-4 py-2 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-primary-dark transition-all">
            <i class="fas fa-plus mr-2"></i> Tambah Template
        </a>
    </div>

    @if(session('success'))
        <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white border-2 border-dark rounded-playful-lg shadow-border-offset-lg overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-100 border-b-2 border-dark">
                <tr>
                    <th class="px-4 py-3 text-left font-exo2 text-dark">Judul</th>
                    <th class="px-4 py-3 text-left font-exo2 text-dark">Kategori</th>
                    <th class="px-4 py-3 text-left font-exo2 text-dark">Tipe</th>
                    <th class="px-4 py-3 text-left font-exo2 text-dark">Mood Trigger</th>
                    <th class="px-4 py-3 text-left font-exo2 text-dark">Poin</th>
                    <th class="px-4 py-3 text-left font-exo2 text-dark">Status</th>
                    <th class="px-4 py-3 text-center font-exo2 text-dark">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($templates as $template)
                    <tr class="border-b border-gray-200 hover:bg-gray-50">
                        <td class="px-4 py-3 font-poppins">{{ $template->title }}</td>
                        <td class="px-4 py-3 font-poppins capitalize">{{ str_replace('_', ' ', $template->category) }}</td>
                        <td class="px-4 py-3 font-poppins">{{ $template->type === 'in_app' ? 'In-App' : 'Off-App' }}</td>
                        <td class="px-4 py-3 font-poppins capitalize">{{ $template->mood_trigger ?? '-' }}</td>
                        <td class="px-4 py-3 font-poppins">{{ $template->points }}</td>
                        <td class="px-4 py-3">
                            @if($template->is_active)
                                <span class="bg-green-100 text-green-800 text-xs font-bold px-2 py-1 rounded-full">Aktif</span>
                            @else
                                <span class="bg-red-100 text-red-800 text-xs font-bold px-2 py-1 rounded-full">Nonaktif</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('admin.task-templates.edit', $template) }}" class="text-blue-500 hover:text-blue-700 mr-2">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.task-templates.delete', $template) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus template ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500 hover:text-red-700">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500 font-poppins">
                            Belum ada task template.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $templates->links() }}
    </div>
</div>
@endsection
