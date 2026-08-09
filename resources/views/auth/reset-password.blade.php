<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Kata Sandi - Sejenak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap');
        body { font-family: 'Lexend', sans-serif; }
        .shadow-offset-dark { box-shadow: 3px 4px 0px #080330; }
        .rounded-playful { border-radius: 12px; }
        .text-shadow-h1 {
            color: white;
            text-shadow: -1px -1px 0 #080330, 1px -1px 0 #080330, -1px 1px 0 #080330, 1px 1px 0 #080330, 3px 3px 0 #080330;
        }
    </style>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#94B704',
                        secondary: '#DCD489',
                        dark: '#080330',
                        lightbg: '#f7f7f7',
                        logininput: '#e6d09c',
                        placeholder: '#d6d9e1',
                    },
                    fontFamily: { lexend: ['Lexend', 'sans-serif'] },
                    borderRadius: { 'card-lg': '24px' },
                },
            },
        };
    </script>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="flex h-screen w-screen">
        {{-- Left Panel --}}
        <div class="hidden md:flex flex-col items-center justify-center p-8 bg-primary w-1/2 relative text-white text-center">
            <h1 class="text-4xl font-bold mb-4 text-shadow-h1">Buat kata sandi baru yang kuat</h1>
            <div class="md:w-1/2 flex flex-row justify-center align-bottom items-end gap-6 p-8">
                <img class="h-full" src="{{ asset('assets/component/vas.svg') }}" alt="">
                <img class="w-100" src="{{ asset('assets/component/container.svg') }}" alt="">
                <img class="h-full flex justify-end" src="{{ asset('assets/component/table.svg') }}" alt="">
            </div>
            <p class="text-xl">Pastikan kata sandi baru kamu mudah diingat tapi sulit ditebak.</p>
        </div>

        {{-- Right Panel --}}
        <div class="flex-1 flex items-center justify-center md:p-4 bg-secondary md:bg-lightbg md:w-1/2">
            <div class="w-full max-w-sm p-6 md:p-8 bg-secondary md:bg-white md:rounded-card-lg md:border-4 border-dark md:shadow-offset-dark">

                {{-- Validation Errors --}}
                @if ($errors->any())
                    <div class="mb-4 p-3 bg-red-100 border-2 border-red-400 rounded-playful text-sm text-red-700">
                        @foreach ($errors->all() as $error)
                            <p><i class="fas fa-exclamation-circle mr-1"></i>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif

                <div class="flex flex-col justify-start w-full mb-6">
                    <div class="w-12 h-12 rounded-full bg-primary/20 border-2 border-primary flex items-center justify-center mb-3">
                        <i class="fas fa-key text-primary text-xl"></i>
                    </div>
                    <h2 class="text-3xl font-bold mb-1 text-dark">Reset Kata Sandi</h2>
                    <p class="text-sm text-dark opacity-70">Masukkan kata sandi baru kamu di bawah ini.</p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-dark mb-1">Alamat Email</label>
                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $request->email) }}"
                            required
                            autofocus
                            autocomplete="username"
                            placeholder="contoh@email.com"
                            class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 bg-logininput placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                        />
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-dark mb-1">Kata Sandi Baru</label>
                        <div class="relative">
                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="new-password"
                                placeholder="Masukkan kata sandi baru"
                                class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 pr-10 bg-logininput placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            />
                            <button type="button" onclick="togglePassword('password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-dark">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="mb-5">
                        <label for="password_confirmation" class="block text-sm font-medium text-dark mb-1">Konfirmasi Kata Sandi</label>
                        <div class="relative">
                            <input
                                id="password_confirmation"
                                type="password"
                                name="password_confirmation"
                                required
                                autocomplete="new-password"
                                placeholder="Ulangi kata sandi baru"
                                class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 pr-10 bg-logininput placeholder-slate-500 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent"
                            />
                            <button type="button" onclick="togglePassword('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-600 hover:text-dark">
                                <i class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>

                    <button type="submit" class="w-full px-4 py-2.5 font-bold text-dark bg-primary rounded-playful border-2 border-dark shadow-offset-dark transition-all duration-200 hover:bg-[#a9d1a9] hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none">
                        <i class="fas fa-check mr-2"></i>
                        Reset Kata Sandi
                    </button>
                </form>

                <div class="text-center mt-6 text-sm">
                    <p class="text-dark">Ingat kata sandi?
                        <a href="{{ route('login') }}" class="text-dark font-bold underline">Login disini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const icon = button.querySelector('i');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
