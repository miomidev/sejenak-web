@extends('layouts.app')

@section('title', 'Top Up Token')

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

{{-- ===== QRIS PAYMENT MODAL ===== --}}
<div id="qris-modal" class="fixed inset-0 z-[999] flex items-center justify-center hidden">
    {{-- Backdrop --}}
    <div id="qris-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    {{-- Modal Card --}}
    <div class="relative bg-white rounded-[28px] border-2 border-dark shadow-[6px_8px_0px_#080330] w-full max-w-sm mx-4 overflow-hidden z-10">
        
        {{-- Header --}}
        <div class="bg-primary px-5 py-4 flex items-center justify-between border-b-2 border-dark">
            <div>
                <p class="text-white text-xs font-medium opacity-80">Total Pembayaran</p>
                <p id="modal-amount" class="text-white text-2xl font-bold font-exo2">Rp 0</p>
                <p id="modal-package" class="text-white text-xs opacity-80 mt-0.5"></p>
            </div>
            <button id="modal-close-btn" class="w-8 h-8 rounded-full bg-white/20 hover:bg-white/30 flex items-center justify-center text-white transition-all">
                <i class="fas fa-times text-sm"></i>
            </button>
        </div>

        {{-- Timer --}}
        <div class="bg-yellow-50 border-b border-yellow-200 px-5 py-2 flex items-center justify-between">
            <div class="flex items-center gap-2 text-yellow-700">
                <i class="fas fa-clock text-sm"></i>
                <span class="text-sm font-medium">Bayar sebelum</span>
            </div>
            <div id="countdown-timer" class="text-xl font-bold font-exo2 text-red-600 tabular-nums">60:00</div>
        </div>

        {{-- Body --}}
        <div class="px-5 py-4">
            {{-- Loading state --}}
            <div id="qris-loading" class="flex flex-col items-center justify-center py-8 gap-3">
                <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                <p class="text-sm text-gray-500 font-medium">Membuat QRIS...</p>
            </div>

            {{-- QRIS Content --}}
            <div id="qris-content" class="hidden flex-col items-center gap-3">
                <p class="text-sm text-gray-600 text-center font-medium">Scan QRIS di bawah ini untuk membayar</p>
                
                {{-- QR Code --}}
                <div class="border-2 border-dark rounded-[16px] p-3 shadow-[3px_3px_0px_#080330] bg-white">
                    <img id="qris-image" src="" alt="QRIS Code" class="w-52 h-52 object-contain">
                </div>

                <div class="w-full bg-gray-50 rounded-playful-sm border border-gray-200 px-3 py-2 text-center">
                    <p class="text-xs text-gray-500">Order ID</p>
                    <p id="modal-order-id" class="text-xs font-mono font-bold text-dark break-all"></p>
                </div>

                <p class="text-xs text-gray-400 text-center">Gunakan aplikasi GoPay, OVO, Dana, atau aplikasi bank apapun yang mendukung QRIS</p>
            </div>

            {{-- Fallback: no QRIS, show link --}}
            <div id="qris-fallback" class="hidden flex-col items-center gap-3 py-4">
                <i class="fas fa-qrcode text-5xl text-gray-300"></i>
                <p class="text-sm text-gray-600 text-center">QRIS tidak tersedia. Klik tombol di bawah untuk membuka halaman pembayaran.</p>
                <a id="fallback-payment-link" href="#" target="_blank" class="w-full bg-primary text-white py-2 px-4 rounded-playful-sm font-bold text-sm border-2 border-dark shadow-border-offset text-center hover:bg-green-600 transition-all">
                    <i class="fas fa-external-link-alt mr-2"></i> Buka Halaman Pembayaran
                </a>
            </div>

            {{-- Success state --}}
            <div id="qris-success" class="hidden flex-col items-center gap-3 py-6">
                <div class="w-16 h-16 rounded-full bg-green-100 border-2 border-green-500 flex items-center justify-center">
                    <i class="fas fa-check text-green-500 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-dark">Pembayaran Berhasil!</h3>
                <p id="success-token-msg" class="text-sm text-gray-600 text-center"></p>
                <button onclick="window.location.reload()" class="w-full bg-primary text-white py-2 px-4 rounded-playful-sm font-bold text-sm border-2 border-dark shadow-border-offset hover:bg-green-600 transition-all">
                    <i class="fas fa-sync mr-2"></i> Refresh Halaman
                </button>
            </div>

            {{-- Expired state --}}
            <div id="qris-expired" class="hidden flex-col items-center gap-3 py-6">
                <div class="w-16 h-16 rounded-full bg-red-100 border-2 border-red-400 flex items-center justify-center">
                    <i class="fas fa-times text-red-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-dark">Waktu Habis</h3>
                <p class="text-sm text-gray-600 text-center">Transaksi telah kedaluwarsa. Silakan buat transaksi baru.</p>
                <button id="expired-retry-btn" class="w-full bg-white text-dark py-2 px-4 rounded-playful-sm font-bold text-sm border-2 border-dark shadow-border-offset hover:bg-gray-100 transition-all">
                    <i class="fas fa-redo mr-2"></i> Coba Lagi
                </button>
            </div>
        </div>

        {{-- Footer --}}
        <div id="qris-footer" class="px-5 pb-4 hidden">
            <div class="flex items-center justify-center gap-2 text-gray-400">
                <i class="fas fa-shield-alt text-xs"></i>
                <span class="text-xs">Pembayaran aman melalui MiomiPay</span>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const buyButtons = document.querySelectorAll('.buy-button');
        const modal = document.getElementById('qris-modal');
        const backdrop = document.getElementById('qris-backdrop');
        const closeBtn = document.getElementById('modal-close-btn');
        const expiredRetryBtn = document.getElementById('expired-retry-btn');

        let countdownInterval = null;
        let pollingInterval = null;
        let currentOrderId = null;

        // ===== OPEN MODAL =====
        function openModal() {
            modal.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
        }

        // ===== CLOSE MODAL =====
        function closeModal() {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
            stopCountdown();
            stopPolling();
            resetModal();
        }

        // ===== RESET MODAL =====
        function resetModal() {
            showSection('loading');
            document.getElementById('qris-footer').classList.add('hidden');
            document.getElementById('countdown-timer').textContent = '60:00';
            document.getElementById('countdown-timer').classList.remove('text-red-600');
            document.getElementById('countdown-timer').classList.add('text-red-600');
            currentOrderId = null;
        }

        // ===== SHOW SECTION =====
        function showSection(section) {
            ['loading', 'content', 'fallback', 'success', 'expired'].forEach(s => {
                const el = document.getElementById('qris-' + s);
                if (el) {
                    el.classList.add('hidden');
                    el.classList.remove('flex');
                }
            });
            const target = document.getElementById('qris-' + section);
            if (target) {
                target.classList.remove('hidden');
                target.classList.add('flex');
            }
        }

        // ===== COUNTDOWN TIMER =====
        function startCountdown(durationSeconds) {
            stopCountdown();
            let remaining = durationSeconds;
            const timerEl = document.getElementById('countdown-timer');

            function tick() {
                const m = Math.floor(remaining / 60);
                const s = remaining % 60;
                timerEl.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');

                if (remaining <= 300) { // last 5 min: red pulse
                    timerEl.classList.add('animate-pulse');
                }

                if (remaining <= 0) {
                    stopCountdown();
                    stopPolling();
                    showSection('expired');
                    document.getElementById('qris-footer').classList.add('hidden');
                    return;
                }
                remaining--;
            }

            tick();
            countdownInterval = setInterval(tick, 1000);
        }

        function stopCountdown() {
            if (countdownInterval) {
                clearInterval(countdownInterval);
                countdownInterval = null;
            }
        }

        // ===== POLLING =====
        function startPolling(orderId) {
            stopPolling();
            pollingInterval = setInterval(async () => {
                try {
                    const res = await fetch('{{ route("checkout.status") }}?order_id=' + encodeURIComponent(orderId), {
                        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
                    });
                    if (!res.ok) return;
                    const data = await res.json();

                    if (data.status === 'success') {
                        stopPolling();
                        stopCountdown();
                        showSection('success');
                        document.getElementById('success-token-msg').textContent =
                            data.token_amount + ' token berhasil ditambahkan ke akunmu! 🎉';
                        document.getElementById('qris-footer').classList.add('hidden');
                    } else if (data.status === 'expired' || data.status === 'failed') {
                        stopPolling();
                        stopCountdown();
                        showSection('expired');
                        document.getElementById('qris-footer').classList.add('hidden');
                    }
                } catch (e) {
                    console.error('Polling error:', e);
                }
            }, 5000); // poll every 5 seconds
        }

        function stopPolling() {
            if (pollingInterval) {
                clearInterval(pollingInterval);
                pollingInterval = null;
            }
        }

        // ===== BUY BUTTON CLICK =====
        buyButtons.forEach(button => {
            button.addEventListener('click', async function (e) {
                e.preventDefault();

                const originalButtonText = this.innerHTML;
                const packageName = this.dataset.package;
                const tokenAmount = this.dataset.tokens;
                const price = this.dataset.price;

                this.disabled = true;
                this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Loading...';

                // Open modal with loading state
                resetModal();
                openModal();

                // Set header info
                document.getElementById('modal-amount').textContent = 'Rp ' + parseInt(price).toLocaleString('id-ID');
                document.getElementById('modal-package').textContent = packageName + ' · ' + parseInt(tokenAmount).toLocaleString('id-ID') + ' Token';

                try {
                    const response = await fetch('{{ route("checkout") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            package_name: packageName,
                            token_amount: tokenAmount,
                            price: price,
                        })
                    });

                    this.disabled = false;
                    this.innerHTML = originalButtonText;

                    if (!response.ok) {
                        throw new Error('Server error: ' + response.status);
                    }

                    const result = await response.json();

                    if (!result.success) {
                        closeModal();
                        alert('Terjadi kesalahan: ' + (result.error || 'Unknown error'));
                        return;
                    }

                    currentOrderId = result.order_id;
                    document.getElementById('modal-order-id').textContent = result.order_id;

                    // Start countdown: 60 minutes
                    startCountdown(60 * 60);

                    // Show QRIS or fallback
                    if (result.qris_url) {
                        document.getElementById('qris-image').src = result.qris_url;
                        showSection('content');
                        document.getElementById('qris-footer').classList.remove('hidden');
                        startPolling(result.order_id);
                    } else if (result.payment_url) {
                        // No QRIS image, show fallback link
                        document.getElementById('fallback-payment-link').href = result.payment_url;
                        showSection('fallback');
                        document.getElementById('qris-footer').classList.remove('hidden');
                        startPolling(result.order_id);
                    } else {
                        closeModal();
                        alert('Gagal mendapatkan data pembayaran. Silakan coba lagi.');
                    }

                } catch (error) {
                    this.disabled = false;
                    this.innerHTML = originalButtonText;
                    closeModal();
                    console.error('Checkout error:', error);
                    alert('Terjadi kesalahan. Silakan coba lagi.');
                }
            });
        });

        // ===== CLOSE EVENTS =====
        closeBtn.addEventListener('click', closeModal);
        backdrop.addEventListener('click', closeModal);
        expiredRetryBtn.addEventListener('click', closeModal);

        // ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape' && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });
    });
</script>
@endsection
