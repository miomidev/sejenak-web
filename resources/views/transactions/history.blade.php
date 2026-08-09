@extends('layouts.app')

@section('title', 'Riwayat Transaksi')

@section('content')
<div class="flex flex-col w-full h-full overflow-y-auto bg-gray-50/50 pb-10">
    <!-- Header Section -->
    <div class="text-center pt-8 pb-6 px-4">
        <div class="flex items-center justify-center gap-3 mb-2">
            <div class="w-12 h-12 rounded-full bg-primary/10 border-2 border-primary flex items-center justify-center">
                <i class="fas fa-history text-primary text-xl"></i>
            </div>
            <h1 class="text-2xl md:text-3xl font-bold font-exo2 text-dark">Riwayat Transaksi</h1>
        </div>
        <p class="text-sm text-gray-500">Pantau mutasi dan status pembelian token kamu di sini.</p>
    </div>

    <!-- Content -->
    <div class="mx-4 md:mx-auto md:max-w-4xl w-full px-4">
        @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-playful-sm mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
        @endif

        @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-playful-sm mb-4" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
        @endif

        <div class="bg-white border-2 border-dark rounded-playful-lg shadow-border-offset overflow-hidden">
            @if($transactions->count() > 0)
                <div class="flex flex-col divide-y-2 divide-dark/10">
                    @foreach($transactions as $trx)
                    <div class="p-4 md:p-5 flex flex-col md:flex-row md:items-center justify-between gap-4 hover:bg-gray-50 transition-colors">
                        <div class="flex items-start gap-4">
                            <!-- Icon/Status Indicator -->
                            <div class="w-10 h-10 rounded-full flex-shrink-0 flex items-center justify-center border-2 
                                @if($trx->status === 'success') bg-green-100 border-green-500 text-green-500
                                @elseif($trx->status === 'pending') bg-yellow-100 border-yellow-500 text-yellow-500
                                @elseif($trx->status === 'expired') bg-gray-100 border-gray-400 text-gray-500
                                @else bg-red-100 border-red-500 text-red-500 @endif">
                                <i class="fas 
                                    @if($trx->status === 'success') fa-check
                                    @elseif($trx->status === 'pending') fa-clock
                                    @elseif($trx->status === 'expired') fa-times-circle
                                    @else fa-exclamation-triangle @endif"></i>
                            </div>

                            <!-- Details -->
                            <div>
                                <h3 class="font-bold text-dark font-exo2 text-base md:text-lg leading-tight">{{ $trx->package_name }}</h3>
                                <p class="text-xs text-gray-500 mt-0.5">Order ID: <span class="font-mono">{{ $trx->order_id }}</span></p>
                                <p class="text-xs text-gray-400 mt-1"><i class="far fa-calendar-alt mr-1"></i> {{ $trx->created_at->format('d M Y, H:i') }}</p>
                            </div>
                        </div>

                        <div class="flex flex-row md:flex-col items-center md:items-end justify-between md:justify-center mt-2 md:mt-0 gap-3 md:gap-1 pl-14 md:pl-0">
                            <div class="text-left md:text-right">
                                <p class="font-bold text-primary font-exo2 text-lg">Rp {{ number_format($trx->price, 0, ',', '.') }}</p>
                                <p class="text-xs font-semibold text-yellow-500"><i class="fas fa-coins mr-1"></i>+{{ number_format($trx->token_amount, 0, ',', '.') }} Token</p>
                            </div>

                            <div class="flex flex-col items-end gap-2">
                                <!-- Status Badge -->
                                <span class="px-3 py-1 text-xs font-bold rounded-full border 
                                    @if($trx->status === 'success') bg-green-100 text-green-700 border-green-200
                                    @elseif($trx->status === 'pending') bg-yellow-100 text-yellow-700 border-yellow-200
                                    @elseif($trx->status === 'expired') bg-gray-100 text-gray-600 border-gray-200
                                    @else bg-red-100 text-red-700 border-red-200 @endif">
                                    {{ strtoupper($trx->status) }}
                                </span>

                                <!-- Action Button for Pending -->
                                @if($trx->status === 'pending' && $trx->snap_token)
                                    <a href="{{ $trx->snap_token }}" class="text-xs font-bold bg-primary text-white px-3 py-1.5 rounded-playful-sm border-2 border-dark shadow-[2px_2px_0px_#080330] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all">
                                        Bayar Sekarang <i class="fas fa-arrow-right ml-1"></i>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <!-- Empty State -->
                <div class="py-12 px-4 flex flex-col items-center justify-center text-center">
                    <img src="https://cdni.iconscout.com/illustration/premium/thumb/empty-cart-7359557-6024626.png" alt="Belum ada transaksi" class="w-48 mb-4 opacity-80 mix-blend-multiply">
                    <h3 class="text-lg font-bold font-exo2 text-dark mb-2">Belum Ada Transaksi</h3>
                    <p class="text-sm text-gray-500 mb-6 max-w-sm">Kamu belum melakukan pembelian token. Yuk beli token sekarang untuk mulai konseling!</p>
                    <a href="{{ route('user.token') }}" class="bg-primary text-white py-2.5 px-6 rounded-playful-md font-bold text-sm border-2 border-dark shadow-[4px_4px_0px_#080330] hover:shadow-none hover:translate-x-1 hover:translate-y-1 transition-all">
                        <i class="fas fa-shopping-cart mr-2"></i> Beli Token
                    </a>
                </div>
            @endif
        </div>

        <!-- Pagination -->
        @if($transactions->hasPages())
            <div class="mt-6">
                {{ $transactions->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
