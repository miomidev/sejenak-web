@extends('layouts.admin')

@section('title', 'Manajemen Transaksi')

@section('content')
<div class="container mx-auto px-6 py-8">

    <div class="mb-8">
        <h1 class="text-h2 font-bold text-dark">Manajemen Transaksi</h1>
        <p class="text-gray-600 mt-1">Lacak dan kelola semua transaksi token di platform.</p>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border-2 border-dark text-green-800 font-semibold px-4 py-3 rounded-playful-sm shadow-border-offset mb-6" role="alert">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white p-4 sm:p-6 rounded-playful-sm border-2 border-dark shadow-border-offset">
        <form method="GET" action="{{ route('admin.transactions') }}" class="mb-4">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                <div>
                    <label for="date_from" class="text-xs font-bold text-dark">Dari Tanggal</label>
                    <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" class="mt-1 w-full px-4 py-2 rounded-playful-sm border-2 border-dark">
                </div>
                <div>
                    <label for="date_to" class="text-xs font-bold text-dark">Sampai Tanggal</label>
                    <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" class="mt-1 w-full px-4 py-2 rounded-playful-sm border-2 border-dark">
                </div>
                <div>
                    <label for="type" class="text-xs font-bold text-dark">Tipe</label>
                    <select name="type" id="type" class="mt-1 w-full px-4 py-2 rounded-playful-sm border-2 border-dark bg-white">
                        <option value="">Semua Tipe</option>
                        {{-- Asumsi tipe transaksi --}}
                        <option value="pembelian_token" {{ request('type') == 'pembelian_token' ? 'selected' : '' }}>Pembelian Token</option>
                        <option value="penggunaan_sesi" {{ request('type') == 'penggunaan_sesi' ? 'selected' : '' }}>Penggunaan Sesi</option>
                    </select>
                </div>
                <div class="col-span-1 md:col-span-2 flex items-end space-x-2">
                    <button type="submit" class="w-full px-4 py-2 bg-primary text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-green-600">
                        <i class="fas fa-filter mr-2"></i> Filter
                    </button>
                    {{-- Tombol Export akan mengarahkan ke route export dengan parameter filter yang sama --}}
                    <a href="{{ route('admin.transactions.export', request()->query()) }}" class="w-full text-center px-4 py-2 bg-blue-500 text-white font-bold rounded-playful-sm border-2 border-dark shadow-border-offset hover:bg-blue-600">
                        <i class="fas fa-file-excel mr-2"></i> Export
                    </a>
                </div>
            </div>
        </form>

        <div class="mb-6 mt-8 p-4 bg-purple-100 rounded-playful-sm border-2 border-dark flex justify-between items-center">
            <h3 class="text-h5 font-bold text-purple-800">Total Pemasukan (dari filter)</h3>
            <p class="text-2xl font-bold text-dark">Rp {{ number_format($totalAmount, 0, ',', '.') }}</p>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y-2 divide-dark">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-dark uppercase tracking-wider">Deskripsi</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-dark uppercase tracking-wider">Jumlah</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($transactions as $transaction)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm text-dark">{{ $transaction->created_at->format('d M Y, H:i') }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <p class="text-sm font-semibold text-dark">{{ $transaction->user->name ?? 'N/A' }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 inline-flex text-xs leading-5 font-semibold rounded-full capitalize {{ $transaction->type == 'pembelian_token' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ str_replace('_', ' ', $transaction->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm text-gray-600">{{ $transaction->description }}</p>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <p class="text-sm font-bold text-dark">Rp {{ number_format($transaction->amount, 0, ',', '.') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                <p class="font-semibold">Tidak ada data transaksi yang cocok dengan filter Anda.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $transactions->withQueryString()->links() }}
        </div>
    </div>
</div>
@endsection