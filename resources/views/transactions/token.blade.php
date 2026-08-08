@extends('layouts.app')

@section('title', 'Top Up Token')

@push('scripts')
    <script type="text/javascript"
      src="{{ config('midtrans.snap_url') }}"
      data-client-key="{{ config('midtrans.client_key') }}"></script>
@endpush


@section('content')
<div class="flex flex-col items-center w-full h-full p-4 pb-24 md:p-0 overflow-y-auto m-0">
    <div class="text-center my-8 md:my-12">
        <h1 class="text-4xl md:text-5xl font-bold font-exo2 text-dark text-shadow-h1">Pilih Paket Token</h1>
        <p class="text-lg md:text-xl text-gray-600 mt-2 font-poppins text-shadow-soft">Temukan paket yang paling cocok untuk kebutuhan curhatmu!</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 md:gap-8 w-full max-w-6xl px-4 pb-8">

        @foreach ($packages as $pkg)
            <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col items-center text-center shadow-border-offset-lg hover:shadow-border-offset-accent transition-shadow duration-300">
                <div class="text-4xl text-{{ $pkg['color'] }} mb-4"><i class="{{ $pkg['icon'] }}"></i></div>
                <h2 class="text-2xl font-bold font-exo2 text-dark">{{ $pkg['name'] }}</h2>
                <p class="text-lg text-gray-500 font-poppins mb-2">{{ number_format($pkg['tokens']) }} Token</p>
                <p class="text-3xl font-bold font-exo2 text-dark mb-6">Rp {{ number_format($pkg['price']) }}</p>
                
                <button class="buy-button w-full bg-{{ $pkg['color'] }} text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-{{ $pkg['color'] }}-dark transition-all duration-200 hover:scale-105"
                        data-package="{{ $pkg['name'] }}" 
                        data-tokens="{{ $pkg['tokens'] }}" 
                        data-price="{{ $pkg['price'] }}">
                    Beli Sekarang
                </button>
            </div>
        @endforeach

        {{-- Paket Khusus (diletakkan di luar loop karena perilakunya beda) --}}
        <div class="bg-white border-2 border-dark rounded-playful-lg p-6 flex flex-col items-center text-center shadow-border-offset-lg hover:shadow-border-offset-accent transition-shadow duration-300 col-span-1 md:col-span-2 lg:col-span-3">
            <div class="text-4xl text-purple mb-4"><i class="fas fa-briefcase"></i></div>
            <h2 class="text-2xl font-bold font-exo2 text-dark">Paket Khusus</h2>
            <p class="text-lg text-gray-500 font-poppins mb-2">Paket kustom untuk komunitas atau perusahaan</p>
            <p class="text-4xl font-bold font-exo2 text-dark mb-6">Hubungi Kami</p>
            <button class="w-full bg-purple text-white p-3 rounded-playful-sm font-bold border-2 border-dark shadow-[4px_4px_0px_#080330] hover:bg-purple-dark transition-all duration-200 hover:scale-105">Kirim Pertanyaan</button>
        </div>
    </div>
</div>

<script type="text/javascript">
    document.addEventListener('DOMContentLoaded', function () {
        const buyButtons = document.querySelectorAll('.buy-button');
        
        buyButtons.forEach(button => {
            button.addEventListener('click', async function (e) {
                e.preventDefault();

                const originalButtonText = this.innerHTML; // Simpan teks asli tombol
                const packageName = this.dataset.package;
                const tokenAmount = this.dataset.tokens;
                const price = this.dataset.price;
                
                const data = {
                    package_name: packageName,
                    token_amount: tokenAmount,
                    price: price,
                };

                this.disabled = true;
                this.innerHTML = 'Loading...';

                try {
                    const response = await fetch('{{ route("checkout") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(data)
                    });
                    
                    // Cek jika respons dari server bukan OK (bukan 2xx)
                    if (!response.ok) {
                        // Ini akan menangkap error server seperti 500, 419, dll.
                        // dan melemparkannya ke blok catch
                        throw new Error(`Server responded with status: ${response.status}`);
                    }

                    const result = await response.json();

                    if(result.snapToken) {
                        window.snap.pay(result.snapToken, {
                            onSuccess: function(result){
                                // Ganti alert dengan redirect ke halaman sukses
                                window.location.href = '{{ route("payment.success") }}'; 
                            },
                            onPending: function(result){
                                // Ganti alert dengan redirect ke halaman pending
                                window.location.href = '{{ route("payment.pending") }}'; 
                            },
                            onError: function(result){
                                // Ganti alert dengan redirect ke halaman gagal
                                window.location.href = '{{ route("payment.failed") }}';
                            },
                            onClose: function(){
                                // Saat popup ditutup, lebih baik pengguna tetap di halaman ini.
                                // Jadi kita tidak melakukan redirect, cukup kembalikan tombol ke keadaan semula.
                                console.log('Popup pembayaran ditutup oleh pengguna.');
                            }
                        });
                        // Kembalikan tombol ke keadaan semula jika user menutup popup
                        this.disabled = false;
                        this.innerHTML = originalButtonText;

                    } else if (result.error) {
                        console.error('API Error:', result.error);
                        alert('Terjadi kesalahan saat membuat transaksi: ' + result.error);
                        // location.reload(); // DIKOMENTARI SEMENTARA
                    }
                } catch (error) {
                    // Ini adalah blok yang paling mungkin dieksekusi sekarang
                    console.error('Network/Fetch Error:', error); // Tampilkan error di console
                    alert('Terjadi kesalahan. Silakan cek Console (F12) untuk detail.');
                    // location.reload(); // DIKOMENTARI SEMENTARA

                    // TAMBAHKAN INI: Kembalikan tombol ke keadaan semula jika ada error
                    this.disabled = false;
                    this.innerHTML = originalButtonText;
                }
            });
        });
    });
</script>
@endsection