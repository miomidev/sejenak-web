@extends('layouts.admin')

@section('title', 'Pengaturan Token')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
@endpush

@section('content')
<div class="container mx-auto px-6 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <h1 class="text-h2 font-bold text-dark">Pengaturan Token</h1>
            <p class="text-gray-600 mt-1">Kelola harga sesi konseling dan paket token MiomiPay.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg shadow-sm">
            <p class="font-bold">Berhasil</p>
            <p>{{ session('success') }}</p>
        </div>
    @endif
    @if($errors->any())
        <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg shadow-sm">
            <p class="font-bold">Error</p>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Pengaturan Harga Sesi -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6">
                <h3 class="text-xl font-bold text-dark mb-4 border-b pb-2">Harga Sesi Konseling</h3>
                <form action="{{ route('admin.token.settings.session_price') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="session_price" class="block text-sm font-medium text-gray-700 mb-2">Harga Sesi (Token)</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <i class="fas fa-coins text-yellow-500"></i>
                            </div>
                            <input type="number" name="session_price" id="session_price" class="pl-10 w-full rounded-playful-sm border-2 border-dark focus:ring-secondary focus:border-secondary transition-colors py-2" value="{{ $sessionPrice }}" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Jumlah token yang akan dipotong dari saldo user saat mengajukan sesi.</p>
                    </div>
                    <button type="submit" class="w-full bg-secondary hover:bg-opacity-90 text-dark font-bold py-2 px-4 rounded-playful-sm border-2 border-dark shadow-border-offset transition-all active:translate-y-1 active:shadow-none">
                        Simpan Harga Sesi
                    </button>
                </form>
            </div>
        </div>

        <!-- Daftar Paket Token -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-playful-sm border-2 border-dark shadow-border-offset p-6">
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h3 class="text-xl font-bold text-dark">Daftar Paket Token</h3>
                    <button onclick="openAddPackageModal()" class="bg-primary hover:bg-opacity-90 text-dark font-bold py-2 px-4 rounded-playful-sm border-2 border-dark shadow-border-offset-sm transition-all active:translate-y-[2px] active:shadow-none text-sm">
                        <i class="fas fa-plus mr-2"></i> Tambah Paket
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full leading-normal">
                        <thead>
                            <tr>
                                <th class="px-5 py-3 border-b-2 border-dark bg-gray-100 text-left text-xs font-semibold text-dark uppercase tracking-wider">
                                    Icon
                                </th>
                                <th class="px-5 py-3 border-b-2 border-dark bg-gray-100 text-left text-xs font-semibold text-dark uppercase tracking-wider">
                                    Nama Paket
                                </th>
                                <th class="px-5 py-3 border-b-2 border-dark bg-gray-100 text-left text-xs font-semibold text-dark uppercase tracking-wider">
                                    Token
                                </th>
                                <th class="px-5 py-3 border-b-2 border-dark bg-gray-100 text-left text-xs font-semibold text-dark uppercase tracking-wider">
                                    Harga (Rp)
                                </th>
                                <th class="px-5 py-3 border-b-2 border-dark bg-gray-100 text-center text-xs font-semibold text-dark uppercase tracking-wider">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($packages as $package)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                    <span class="inline-flex items-center justify-center h-8 w-8 rounded-full bg-secondary bg-opacity-20 text-secondary">
                                        <i class="material-icons" style="font-size: 18px;">{{ $package->icon }}</i>
                                    </span>
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-medium">
                                    {{ $package->name }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-bold text-yellow-600">
                                    {{ number_format($package->token_amount) }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm font-bold text-green-600">
                                    Rp {{ number_format($package->price) }}
                                </td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    <button onclick="openEditPackageModal({{ $package->id }}, '{{ $package->name }}', {{ $package->token_amount }}, {{ $package->price }}, '{{ $package->icon }}')" class="text-blue-600 hover:text-blue-900 mx-2" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('admin.token.settings.destroy_package', $package->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus paket ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900 mx-2" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                    Belum ada paket token.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Form Paket -->
<div id="packageModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true" onclick="closePackageModal()"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
        <div class="inline-block align-bottom bg-white rounded-playful border-2 border-dark text-left overflow-hidden shadow-border-offset transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
            <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                        <h3 class="text-lg leading-6 font-bold text-dark mb-4" id="modal-title">
                            Tambah Paket Token
                        </h3>
                        <form id="packageForm" action="{{ route('admin.token.settings.store_package') }}" method="POST">
                            @csrf
                            <input type="hidden" name="_method" id="packageMethod" value="POST">
                            
                            <div class="mb-4">
                                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Paket</label>
                                <input type="text" name="name" id="pkg_name" class="w-full rounded-playful-sm border-2 border-dark px-3 py-2" required>
                            </div>
                            
                            <div class="mb-4 flex gap-4">
                                <div class="w-1/2">
                                    <label for="token_amount" class="block text-sm font-medium text-gray-700 mb-1">Jumlah Token</label>
                                    <input type="number" name="token_amount" id="pkg_token" class="w-full rounded-playful-sm border-2 border-dark px-3 py-2" required min="1">
                                </div>
                                <div class="w-1/2">
                                    <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Harga (Rp)</label>
                                    <input type="number" name="price" id="pkg_price" class="w-full rounded-playful-sm border-2 border-dark px-3 py-2" required min="1">
                                </div>
                            </div>

                            <div class="mb-4">
                                <label for="icon" class="block text-sm font-medium text-gray-700 mb-1">Icon (Material Icon Name)</label>
                                <input type="text" name="icon" id="pkg_icon" class="w-full rounded-playful-sm border-2 border-dark px-3 py-2" placeholder="contoh: spa_rounded" required>
                                <p class="text-xs text-gray-500 mt-1">Gunakan nama ikon dari Material Icons. (misal: star_rounded, savings_rounded)</p>
                            </div>
                            
                            <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t-2 border-dark mt-6">
                                <button type="submit" class="w-full inline-flex justify-center rounded-playful-sm border-2 border-dark shadow-border-offset-sm px-4 py-2 bg-secondary text-base font-bold text-dark hover:bg-opacity-90 focus:outline-none sm:ml-3 sm:w-auto sm:text-sm transition-all active:translate-y-[2px] active:shadow-none">
                                    Simpan
                                </button>
                                <button type="button" onclick="closePackageModal()" class="mt-3 w-full inline-flex justify-center rounded-playful-sm border-2 border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                                    Batal
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openAddPackageModal() {
        document.getElementById('modal-title').innerText = 'Tambah Paket Token';
        document.getElementById('packageForm').action = "{{ route('admin.token.settings.store_package') }}";
        document.getElementById('packageMethod').value = 'POST';
        
        document.getElementById('pkg_name').value = '';
        document.getElementById('pkg_token').value = '';
        document.getElementById('pkg_price').value = '';
        document.getElementById('pkg_icon').value = 'spa_rounded';
        
        document.getElementById('packageModal').classList.remove('hidden');
    }

    function openEditPackageModal(id, name, token, price, icon) {
        document.getElementById('modal-title').innerText = 'Edit Paket Token';
        document.getElementById('packageForm').action = "/admin/token-settings/package/" + id;
        document.getElementById('packageMethod').value = 'PUT';
        
        document.getElementById('pkg_name').value = name;
        document.getElementById('pkg_token').value = token;
        document.getElementById('pkg_price').value = price;
        document.getElementById('pkg_icon').value = icon;
        
        document.getElementById('packageModal').classList.remove('hidden');
    }

    function closePackageModal() {
        document.getElementById('packageModal').classList.add('hidden');
    }
</script>

<!-- Tambahkan Google Material Icons jika belum ada -->
@push('styles')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
@endpush
@endsection
