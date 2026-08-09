@extends('layouts.app')

@section('title', 'Top Up Token')

@push('scripts')
@endpush


@section('content')
<div class="flex flex-col w-full h-full overflow-y-auto">
    <!-- Header Section -->
    <div class="text-center pt-6 pb-4 px-4">
        <div class="flex items-center justify-center gap-2 mb-1">
            <i class="fas fa-coins text-yellow-500 text-2xl md:text-3xl"></i>
            <h1 class="text-2xl md:text-3xl font-bold font-exo2 text-dark">Pilih Paket Token</h1>
        </div>
        <p class="text-sm text-gray-500">Temukan paket yang paling cocok untuk kebutuhan curhatmu!</p>
    </div>

    <!-- Saldo Saat Ini -->
    <div class="mx-4 md:mx-8 mb-4">
        <div class="bg-primary border-2 border-dark rounded-playful-lg shadow-border-offset px-5 py-3 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <i class="fas fa-coins text-white text-2xl"></i>
                <div>
                    <p class="text-white text-xs font-medium opacity-80">Saldo Token Kamu</p>
                    <p class="text-white text-xl font-bold font-exo2">{{ number_format(auth()->user()->tokens_balance) }} Token</p>
                </div>
            </div>
            <div class="text-white text-right">
                <p class="text-xs opacity-80">Gunakan untuk</p>
                <p class="text-sm font-bold">Sesi Konseling</p>
            </div>
        </div>
    </div>

    <!-- Package Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 gap-3 md:gap-4 px-4 md:px-8 pb-4">

        @foreach ($packages as $pkg)
            <div class="bg-white border-2 border-dark rounded-playful-lg p-4 flex flex-col items-center text-center shadow-border-offset hover:-translate-y-1 hover:shadow-border-offset-lg transition-all duration-200 cursor-pointer group">
                <!-- Icon -->
                <div class="w-12 h-12 rounded-full bg-{{ $pkg['color'] }}/10 border-2 border-{{ $pkg['color'] }} flex items-center justify-center mb-3">
                    <i class="{{ $pkg['icon'] }} text-{{ $pkg['color'] }} text-xl"></i>
                </div>
                
                <!-- Name & Token -->
                <h2 class="text-base font-bold font-exo2 text-dark leading-tight">{{ $pkg['name'] }}</h2>
                <div class="flex items-center gap-1 mt-1 mb-2">
                    <i class="fas fa-coins text-yellow-500 text-xs"></i>
                    <p class="text-sm text-gray-500 font-medium">{{ number_format($pkg['tokens']) }} Token</p>
                </div>
                
                <!-- Price -->
                <p class="text-xl font-bold font-exo2 text-dark mb-3">Rp {{ number_format($pkg['price']) }}</p>
                
                <!-- Per token info -->
                <p class="text-xs text-gray-400 mb-3">≈ Rp {{ number_format($pkg['price'] / $pkg['tokens'], 0) }}/token</p>
                
                <button class="buy-button w-full bg-{{ $pkg['color'] }} text-white py-2 px-3 rounded-playful-sm font-bold text-sm border-2 border-dark shadow-[3px_3px_0px_#080330] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all duration-200 active:shadow-none"
                        data-package="{{ $pkg['name'] }}" 
                        data-tokens="{{ $pkg['tokens'] }}" 
                        data-price="{{ $pkg['price'] }}">
                    <i class="fas fa-shopping-cart mr-1"></i> Beli
                </button>
            </div>
        @endforeach

        {{-- Paket Khusus --}}
        <div class="bg-gradient-to-br from-purple/10 to-purple/5 border-2 border-dark rounded-playful-lg p-4 flex flex-col items-center text-center shadow-border-offset hover:-translate-y-1 hover:shadow-border-offset-lg transition-all duration-200 col-span-2 md:col-span-3">
            <div class="flex flex-col md:flex-row items-center gap-4 w-full">
                <div class="flex items-center gap-3 flex-1">
                    <div class="w-12 h-12 rounded-full bg-purple/20 border-2 border-purple flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-briefcase text-purple text-xl"></i>
                    </div>
                    <div class="text-left">
                        <h2 class="text-base font-bold font-exo2 text-dark">Paket Khusus</h2>
                        <p class="text-xs text-gray-500">Paket kustom untuk komunitas atau perusahaan</p>
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <p class="text-xl font-bold font-exo2 text-dark">Hubungi Kami</p>
                    <button class="bg-purple text-white py-2 px-5 rounded-playful-sm font-bold text-sm border-2 border-dark shadow-[3px_3px_0px_#080330] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all duration-200">
                        <i class="fas fa-envelope mr-1"></i> Kirim Pertanyaan
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Info Section -->
    <div class="mx-4 md:mx-8 mb-6">
        <div class="bg-secondary/30 border border-dark/20 rounded-playful-md p-3 flex items-start gap-3">
            <i class="fas fa-info-circle text-dark mt-0.5 flex-shrink-0"></i>
            <p class="text-xs text-gray-600">Token digunakan untuk sesi konseling dengan konselor profesional. Pembayaran diproses melalui MiomiPay dan aman. Token tidak dapat dikembalikan setelah digunakan.</p>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const buyButtons = document.querySelectorAll('.buy-button');
        
        buyButtons.forEach(button => {
            button.addEventListener('click', async function (e) {
                e.preventDefault();

                const originalButtonText = this.innerHTML;
                const packageName = this.dataset.package;
                const tokenAmount = this.dataset.tokens;
                const price = this.dataset.price;
                
                const data = {
                    package_name: packageName,
                    token_amount: tokenAmount,
                    price: price,
                };

                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Loading...';

                try {
                    const response = await fetch('{{ route("checkout") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });
                    
                    if (!response.ok) {
                        throw new Error(`Server responded with status: ${response.status}`);
                    }

                    const result = await response.json();

                    // MiomiPay: redirect ke payment_url
                    if (result.success && result.payment_url) {
                        window.location.href = result.payment_url;
                    } else if (result.error) {
                        console.error('API Error:', result.error);
                        alert('Terjadi kesalahan saat membuat transaksi: ' + result.error);
                        this.disabled = false;
                        this.innerHTML = originalButtonText;
                    } else {
                        alert('Gagal mendapatkan link pembayaran. Silakan coba lagi.');
                        this.disabled = false;
                        this.innerHTML = originalButtonText;
                    }
                } catch (error) {
                    console.error('Network/Fetch Error:', error);
                    alert('Terjadi kesalahan. Silakan cek Console (F12) untuk detail.');
                    this.disabled = false;
                    this.innerHTML = originalButtonText;
                }
            });
        });
    });
</script>
@endsection
