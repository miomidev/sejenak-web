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
                                @if($trx->status === 'pending')
                                    <button 
                                        class="bayar-lagi-btn text-xs font-bold bg-primary text-white px-3 py-1.5 rounded-playful-sm border-2 border-dark shadow-[2px_2px_0px_#080330] hover:shadow-none hover:translate-x-0.5 hover:translate-y-0.5 transition-all"
                                        data-order-id="{{ $trx->order_id }}"
                                        data-package="{{ $trx->package_name }}"
                                        data-amount="{{ $trx->price }}"
                                        data-tokens="{{ $trx->token_amount }}">
                                        <i class="fas fa-qrcode mr-1"></i> Bayar Sekarang
                                    </button>
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

{{-- ===== QRIS PAYMENT MODAL (reused from token page) ===== --}}
<div id="qris-modal" class="fixed inset-0 z-[999] flex items-center justify-center hidden">
    <div id="qris-backdrop" class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>
    <div class="relative bg-white rounded-[28px] border-2 border-dark shadow-[6px_8px_0px_#080330] w-full max-w-sm mx-4 overflow-hidden z-10">
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
        <div class="bg-yellow-50 border-b border-yellow-200 px-5 py-2 flex items-center justify-between">
            <div class="flex items-center gap-2 text-yellow-700">
                <i class="fas fa-clock text-sm"></i>
                <span class="text-sm font-medium">Bayar sebelum</span>
            </div>
            <div id="countdown-timer" class="text-xl font-bold font-exo2 text-red-600 tabular-nums">60:00</div>
        </div>
        <div class="px-5 py-4">
            <div id="qris-loading" class="flex flex-col items-center justify-center py-8 gap-3">
                <div class="w-12 h-12 border-4 border-primary border-t-transparent rounded-full animate-spin"></div>
                <p class="text-sm text-gray-500 font-medium">Memuat QRIS...</p>
            </div>
            <div id="qris-content" class="hidden flex-col items-center gap-3">
                <p class="text-sm text-gray-600 text-center font-medium">Scan QRIS di bawah ini untuk membayar</p>
                <div class="border-2 border-dark rounded-[16px] p-3 shadow-[3px_3px_0px_#080330] bg-white">
                    <img id="qris-image" src="" alt="QRIS Code" class="w-52 h-52 object-contain">
                </div>
                <div class="w-full bg-gray-50 rounded-playful-sm border border-gray-200 px-3 py-2 text-center">
                    <p class="text-xs text-gray-500">Order ID</p>
                    <p id="modal-order-id" class="text-xs font-mono font-bold text-dark break-all"></p>
                </div>
                <p class="text-xs text-gray-400 text-center">Gunakan aplikasi GoPay, OVO, Dana, atau aplikasi bank apapun yang mendukung QRIS</p>
            </div>
            <div id="qris-fallback" class="hidden flex-col items-center gap-3 py-4">
                <i class="fas fa-qrcode text-5xl text-gray-300"></i>
                <p class="text-sm text-gray-600 text-center">QRIS tidak tersedia. Klik tombol di bawah untuk membuka halaman pembayaran.</p>
                <a id="fallback-payment-link" href="#" target="_blank" class="w-full bg-primary text-white py-2 px-4 rounded-playful-sm font-bold text-sm border-2 border-dark shadow-border-offset text-center hover:bg-green-600 transition-all">
                    <i class="fas fa-external-link-alt mr-2"></i> Buka Halaman Pembayaran
                </a>
            </div>
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
            <div id="qris-expired" class="hidden flex-col items-center gap-3 py-6">
                <div class="w-16 h-16 rounded-full bg-red-100 border-2 border-red-400 flex items-center justify-center">
                    <i class="fas fa-times text-red-400 text-2xl"></i>
                </div>
                <h3 class="text-lg font-bold text-dark">Waktu Habis</h3>
                <p class="text-sm text-gray-600 text-center">Transaksi telah kedaluwarsa. Silakan buat transaksi baru.</p>
                <button id="expired-retry-btn" class="w-full bg-white text-dark py-2 px-4 rounded-playful-sm font-bold text-sm border-2 border-dark shadow-border-offset hover:bg-gray-100 transition-all">
                    <i class="fas fa-redo mr-2"></i> Tutup
                </button>
            </div>
        </div>
        <div id="qris-footer" class="px-5 pb-4 hidden">
            <div class="flex items-center justify-center gap-2 text-gray-400">
                <i class="fas fa-shield-alt text-xs"></i>
                <span class="text-xs">Pembayaran aman melalui MiomiPay</span>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('qris-modal');
    const backdrop = document.getElementById('qris-backdrop');
    const closeBtn = document.getElementById('modal-close-btn');
    const expiredRetryBtn = document.getElementById('expired-retry-btn');
    const bayarLagiBtns = document.querySelectorAll('.bayar-lagi-btn');

    let countdownInterval = null;
    let pollingInterval = null;

    function openModal() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
        stopCountdown();
        stopPolling();
        resetModal();
    }

    function resetModal() {
        showSection('loading');
        document.getElementById('qris-footer').classList.add('hidden');
        document.getElementById('countdown-timer').textContent = '60:00';
        document.getElementById('countdown-timer').classList.remove('animate-pulse');
    }

    function showSection(section) {
        ['loading', 'content', 'fallback', 'success', 'expired'].forEach(s => {
            const el = document.getElementById('qris-' + s);
            if (el) { el.classList.add('hidden'); el.classList.remove('flex'); }
        });
        const target = document.getElementById('qris-' + section);
        if (target) { target.classList.remove('hidden'); target.classList.add('flex'); }
    }

    function startCountdown(durationSeconds) {
        stopCountdown();
        let remaining = durationSeconds;
        const timerEl = document.getElementById('countdown-timer');
        function tick() {
            const m = Math.floor(remaining / 60);
            const s = remaining % 60;
            timerEl.textContent = String(m).padStart(2, '0') + ':' + String(s).padStart(2, '0');
            if (remaining <= 300) timerEl.classList.add('animate-pulse');
            if (remaining <= 0) {
                stopCountdown(); stopPolling();
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
        if (countdownInterval) { clearInterval(countdownInterval); countdownInterval = null; }
    }

    function startPolling(orderId) {
        stopPolling();
        pollingInterval = setInterval(async () => {
            try {
                const res = await fetch('{{ route("checkout.status") }}?order_id=' + encodeURIComponent(orderId));
                if (!res.ok) return;
                const data = await res.json();
                if (data.status === 'success') {
                    stopPolling(); stopCountdown();
                    showSection('success');
                    document.getElementById('success-token-msg').textContent = data.token_amount + ' token berhasil ditambahkan ke akunmu! 🎉';
                    document.getElementById('qris-footer').classList.add('hidden');
                } else if (data.status === 'expired' || data.status === 'failed') {
                    stopPolling(); stopCountdown();
                    showSection('expired');
                    document.getElementById('qris-footer').classList.add('hidden');
                }
            } catch (e) { console.error('Polling error:', e); }
        }, 5000);
    }

    function stopPolling() {
        if (pollingInterval) { clearInterval(pollingInterval); pollingInterval = null; }
    }

    // Bayar Lagi buttons
    bayarLagiBtns.forEach(btn => {
        btn.addEventListener('click', async function () {
            const orderId = this.dataset.orderId;
            const packageName = this.dataset.package;
            const amount = this.dataset.amount;
            const tokens = this.dataset.tokens;

            const originalText = this.innerHTML;
            this.disabled = true;
            this.innerHTML = '<i class="fas fa-spinner fa-spin mr-1"></i> Memuat...';

            resetModal();
            openModal();
            document.getElementById('modal-amount').textContent = 'Rp ' + parseInt(amount).toLocaleString('id-ID');
            document.getElementById('modal-package').textContent = packageName + ' · ' + parseInt(tokens).toLocaleString('id-ID') + ' Token';
            document.getElementById('modal-order-id').textContent = orderId;

            try {
                const res = await fetch('{{ route("checkout.qris") }}?order_id=' + encodeURIComponent(orderId));
                this.disabled = false;
                this.innerHTML = originalText;

                if (!res.ok) {
                    const err = await res.json();
                    closeModal();
                    alert(err.error || 'Transaksi tidak dapat dibuka.');
                    return;
                }

                const data = await res.json();

                // Start countdown with remaining time
                startCountdown(data.remaining_seconds || 3600);

                if (data.qris_url) {
                    document.getElementById('qris-image').src = data.qris_url;
                    showSection('content');
                    document.getElementById('qris-footer').classList.remove('hidden');
                    startPolling(orderId);
                } else if (data.payment_url) {
                    document.getElementById('fallback-payment-link').href = data.payment_url;
                    showSection('fallback');
                    document.getElementById('qris-footer').classList.remove('hidden');
                    startPolling(orderId);
                } else {
                    closeModal();
                    alert('Gagal memuat data pembayaran.');
                }
            } catch (e) {
                this.disabled = false;
                this.innerHTML = originalText;
                closeModal();
                alert('Terjadi kesalahan. Silakan coba lagi.');
            }
        });
    });

    closeBtn.addEventListener('click', closeModal);
    backdrop.addEventListener('click', closeModal);
    expiredRetryBtn.addEventListener('click', closeModal);
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
    });
});
</script>
@endsection
