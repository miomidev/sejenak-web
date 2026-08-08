<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Sejenak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap');

        body {
            font-family: 'Lexend', sans-serif;
        }

        /* Custom shadow and border radius for a playful look */
        .shadow-offset-dark {
            box-shadow: 3px 4px 0px #080330;
        }
        .shadow-offset-primary {
            box-shadow: 3px 4px 0px #8FD14F;
        }
        .rounded-playful {
            border-radius: 12px;
        }
        .text-shadow-h1 {
            color: white;
            text-shadow:
                -1px -1px 0 #080330,
                1px -1px 0 #080330,
                -1px 1px 0 #080330,
                1px 1px 0 #080330,
                3px 3px 0 #080330;
            text-rendering: optimizeLegibility;
            -webkit-font-smoothing: antialiased;
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
                    fontFamily: {
                        lexend: ['Lexend', 'sans-serif'],
                    },
                    borderRadius: {
                        'card-lg': '24px',
                    },
                },
            },
        };
    </script>
</head>
<body class="flex items-center justify-center min-h-screen">

    <div class="flex h-screen w-screen">
        <div class="hidden md:flex flex-col items-center justify-center p-8 bg-primary w-1/2 relative text-white text-center">
            <h1 class="text-4xl font-bold mb-4 text-shadow-h1">Luangkan waktu refleksi cukup sejenak saja</h1>
            <div class="md:w-1/2 flex flex-row justify-center align-bottom items-end gap-6 p-8">
                <img class="h-full" src="{{ asset('assets/component/vas.svg') }}" alt="">
                <img class="w-100" src="{{ asset('assets/component/container.svg') }}" alt="">
                <img class="h-full flex justify-end" src="{{ asset('assets/component/table.svg') }}" alt="">
            </div>
            <p class="text-xl">Perjalanan menuju kesejahteraan emosional dimulai di sini.</p>
        </div>

        <div class="flex-1 flex items-center justify-center  md:p-4 bg-secondary md:bg-lightbg md:w-1/2">
            <div class="w-full max-w-sm p-6 md:p-8 bg-secondary md:bg-white md:rounded-card-lg md:border-4 border-dark md:shadow-offset-dark">

                <x-validation-errors class="mb-4" />

                @session('status')
                    <div class="mb-4 font-medium text-sm text-green-600">
                        {{ $value }}
                    </div>
                @endsession

                <div class="flex flex-col justify-start w-full">
                    <a href="#" class="text-dark hover:text-gray-900 mb-4 flex items-center text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <h2 class="text-3xl font-bold mb-1 text-dark">Welcome back!</h2>
                    <p class="text-sm mb-6 text-dark">Tolong login kembali kedalam akun anda</p>
                </div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-dark mb-1">Email</label>
                        <input id="email" class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 bg-logininput placeholder-placeholder placeholder-slate-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="Masukkan Email Anda" />
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-dark mb-1">Kata sandi</label>
                        <input id="password" class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 bg-logininput placeholder-placeholder placeholder-slate-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" type="password" name="password" required autocomplete="current-password" placeholder="Masukkan Kata Sandi" />
                    </div>

                    <div class="flex justify-between items-center mt-4 mb-6">
                        <label for="remember_me" class="flex items-center text-sm text-dark">
                            <input id="remember_me" type="checkbox" class="h-4 w-4 text-primary border-2 border-dark rounded checked:bg-primary focus:ring-primary" name="remember">
                            <span class="ms-2">Ingat saya</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="underline text-sm text-dark hover:text-gray-900" href="{{ route('password.request') }}">
                                Lupa kata sandi?
                            </a>
                        @endif
                    </div>

                    <div class="flex justify-center">
                        <button type="submit" class="w-full px-4 py-2 font-bold text-dark bg-primary rounded-playful border-2 border-dark shadow-offset-dark transition-all duration-200 hover:bg-[#a9d1a9] hover:shadow-[3px_4px_0_#080330]">
                            Login
                        </button>
                    </div>
                </form>

                <!-- ====== PEMISAH DAN TOMBOL GOOGLE ====== -->
                <div class="my-6 flex items-center">
                    <div class="flex-grow border-t-2 md:border-gray-300 border-gray-800"></div>
                    <span class="flex-shrink mx-4 text-sm md:text-gray-500 text-gray-800">ATAU</span>
                    <div class="flex-grow border-t-2 md:border-gray-300 border-gray-800"></div>
                </div>

                <a href="{{ route('google.redirect') }}" class="w-full flex items-center justify-center px-4 py-2 font-bold text-dark bg-white rounded-playful border-2 border-dark shadow-offset-dark transition-all duration-200 hover:bg-gray-100 hover:shadow-[3px_4px_0_#080330]">
                    <img src="https://developers.google.com/identity/images/g-logo.png" alt="Google logo" class="w-5 h-5 mr-3">
                    Login dengan Google
                </a>
                <!-- ====== AKHIR BAGIAN GOOGLE ====== -->

                <div class="text-center mt-6 text-sm">
                    <p>Tidak punya akun?
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="text-dark font-bold underline">Daftar disini</a>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
