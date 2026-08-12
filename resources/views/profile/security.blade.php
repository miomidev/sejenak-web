@extends('layouts.app')

@section('title', 'Keamanan Akun')

@section('content')
<div class="h-full w-full flex items-start justify-center px-4 py-4 md:py-4 overflow-y-auto">
    <div class="bg-background flex flex-col w-full max-w-3xl md:p-4 gap-4 md:h-full">

        <div class="click-1 w-full bg-white border-2 border-dark rounded-playful-md shadow-border-offset p-4 md:p-6 transition-all duration-300 transform flex flex-col justify-center">
            <h1 class="text-2xl md:text-3xl font-bold text-dark text-center mb-2">Keamanan Akun</h1>
            <p class="text-center text-sm text-gray-600">Perbarui kata sandi dan pengaturan keamanan Anda.</p>
        </div>

        @if(session('status') == 'password-updated')
        <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 shadow-border-offset" role="alert">
          <span class="font-medium">Kata sandi berhasil diperbarui!</span>
        </div>
        @endif
        
        @if ($errors->updatePassword->any())
        <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 shadow-border-offset" role="alert">
            <ul class="list-disc pl-5">
                @foreach ($errors->updatePassword->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <div class="click-1 bg-white border-2 border-dark rounded-playful-md shadow-border-offset p-4 md:p-6 transition-all duration-300">
            <h2 class="text-xl font-bold text-dark mb-4">Ganti Kata Sandi</h2>
            
            <form action="{{ route('user-password.update') }}" method="POST" class="flex flex-col gap-4">
                @csrf
                @method('PUT')
                
                @if(!Auth::user()->google_id)
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-700">Kata Sandi Saat Ini</label>
                    <div class="relative mt-1">
                        <input type="password" id="current_password" name="current_password" class="block w-full border-2 border-dark rounded-playful-md p-3 pr-10 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm" required>
                        <i class="fas fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer hover:text-dark toggle-password"></i>
                    </div>
                </div>
                @else
                <div class="mb-2">
                    <p class="text-sm text-gray-600">Akun Anda terhubung dengan Google. Anda dapat menetapkan kata sandi baru tanpa memasukkan kata sandi lama.</p>
                </div>
                @endif
                
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700">Kata Sandi Baru</label>
                    <div class="relative mt-1">
                        <input type="password" id="password" name="password" minlength="6" class="block w-full border-2 border-dark rounded-playful-md p-3 pr-10 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm" required>
                        <i class="fas fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer hover:text-dark toggle-password"></i>
                    </div>
                    <!-- Indikator Kekuatan Password -->
                    <div id="password-strength-container" class="mt-2 hidden">
                        <div class="flex justify-between items-center mb-1">
                            <span class="text-xs font-semibold text-gray-600">Kekuatan Kata Sandi:</span>
                            <span id="password-strength-text" class="text-xs font-bold text-gray-500">Mengetik...</span>
                        </div>
                        <div class="flex gap-1 h-1.5">
                            <div id="bar-1" class="w-1/3 bg-gray-200 rounded-full transition-all duration-300"></div>
                            <div id="bar-2" class="w-1/3 bg-gray-200 rounded-full transition-all duration-300"></div>
                            <div id="bar-3" class="w-1/3 bg-gray-200 rounded-full transition-all duration-300"></div>
                        </div>
                    </div>
                </div>
                
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Konfirmasi Kata Sandi Baru</label>
                    <div class="relative mt-1">
                        <input type="password" id="password_confirmation" name="password_confirmation" minlength="6" class="block w-full border-2 border-dark rounded-playful-md p-3 pr-10 focus:outline-none focus:ring-2 focus:ring-primary shadow-sm" required>
                        <i class="fas fa-eye absolute right-4 top-1/2 -translate-y-1/2 text-gray-500 cursor-pointer hover:text-dark toggle-password"></i>
                    </div>
                    <!-- Indikator Kecocokan Kata Sandi -->
                    <div id="password-match-container" class="mt-2 hidden">
                        <span id="password-match-text" class="text-xs font-bold text-red-500"><i class="fas fa-times-circle mr-1"></i> Kata sandi tidak cocok</span>
                    </div>
                </div>

                <div class="mt-4 flex justify-end">
                    <button type="submit" class="click-1 px-6 py-2 bg-primary text-dark font-bold rounded-playful-md border-2 border-dark shadow-border-offset hover:bg-primary/80 transition-all duration-200">
                        <i class="fas fa-save mr-2"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const togglePasswordButtons = document.querySelectorAll('.toggle-password');
        
        togglePasswordButtons.forEach(button => {
            button.addEventListener('click', function() {
                // Cari input terdekat (sebelum icon)
                const input = this.previousElementSibling;
                
                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });

        // Fitur Kekuatan Password
        const passwordInput = document.getElementById('password');
        const strengthContainer = document.getElementById('password-strength-container');
        const strengthText = document.getElementById('password-strength-text');
        const bar1 = document.getElementById('bar-1');
        const bar2 = document.getElementById('bar-2');
        const bar3 = document.getElementById('bar-3');

        let timeout = null;

        passwordInput.addEventListener('input', function() {
            clearTimeout(timeout);
            
            const value = this.value;
            
            if (value.length === 0) {
                strengthContainer.classList.add('hidden');
                return;
            }
            
            strengthContainer.classList.remove('hidden');
            strengthText.textContent = "Menghitung...";
            strengthText.className = "text-xs font-bold text-gray-500";
            
            // Set timeout agar menunggu user selesai ketik (debounce 500ms)
            timeout = setTimeout(() => {
                evaluatePasswordStrength(value);
            }, 500);
        });

        function evaluatePasswordStrength(password) {
            let strength = 0;
            
            // Minimal 8 karakter
            if (password.length >= 8) strength += 1;
            
            // Memiliki huruf kecil dan huruf besar
            if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1;
            
            // Memiliki angka dan karakter khusus
            if (password.match(/([0-9])/) && password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1;

            // Reset semua bar
            bar1.className = "w-1/3 rounded-full transition-all duration-300 bg-gray-200";
            bar2.className = "w-1/3 rounded-full transition-all duration-300 bg-gray-200";
            bar3.className = "w-1/3 rounded-full transition-all duration-300 bg-gray-200";

            if (password.length < 6) {
                // Sangat Lemah (kurang dari 6)
                strengthText.textContent = "Minimal 6 karakter";
                strengthText.className = "text-xs font-bold text-red-500";
                bar1.classList.replace('bg-gray-200', 'bg-red-500');
            } else if (strength === 0) {
                // Lemah
                strengthText.textContent = "Lemah";
                strengthText.className = "text-xs font-bold text-red-500";
                bar1.classList.replace('bg-gray-200', 'bg-red-500');
            } else if (strength === 1 || strength === 2) {
                // Sedang
                strengthText.textContent = "Sedang";
                strengthText.className = "text-xs font-bold text-orange-500";
                bar1.classList.replace('bg-gray-200', 'bg-orange-500');
                bar2.classList.replace('bg-gray-200', 'bg-orange-500');
            } else if (strength === 3) {
                // Kuat
                strengthText.textContent = "Kuat";
                strengthText.className = "text-xs font-bold text-green-500";
                bar1.classList.replace('bg-gray-200', 'bg-green-500');
                bar2.classList.replace('bg-gray-200', 'bg-green-500');
                bar3.classList.replace('bg-gray-200', 'bg-green-500');
            }
            
            checkFormValidity();
        }

        // Fitur Kecocokan Password
        const passwordConfirmationInput = document.getElementById('password_confirmation');
        const matchContainer = document.getElementById('password-match-container');
        const matchText = document.getElementById('password-match-text');
        const submitButton = document.querySelector('form button[type="submit"]');

        function checkFormValidity() {
            const passwordValue = passwordInput.value;
            const confirmationValue = passwordConfirmationInput.value;
            
            let isValid = true;

            // Cek minimal 6 karakter
            if (passwordValue.length > 0 && passwordValue.length < 6) {
                isValid = false;
            }

            // Cek kecocokan (jika konfirmasi sudah diisi)
            if (confirmationValue.length > 0) {
                matchContainer.classList.remove('hidden');
                if (passwordValue === confirmationValue) {
                    matchText.innerHTML = '<i class="fas fa-check-circle mr-1"></i> Kata sandi cocok';
                    matchText.className = "text-xs font-bold text-green-500";
                } else {
                    matchText.innerHTML = '<i class="fas fa-times-circle mr-1"></i> Kata sandi tidak cocok';
                    matchText.className = "text-xs font-bold text-red-500";
                    isValid = false;
                }
            } else {
                matchContainer.classList.add('hidden');
                isValid = false;
            }
            
            if (passwordValue.length === 0) isValid = false;

            // Enable / Disable button
            if (isValid) {
                submitButton.disabled = false;
                submitButton.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitButton.disabled = true;
                submitButton.classList.add('opacity-50', 'cursor-not-allowed');
            }
        }

        passwordInput.addEventListener('input', checkFormValidity);
        passwordConfirmationInput.addEventListener('input', checkFormValidity);
    });
</script>
@endsection
