<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Sejenak</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap');

        body {
            font-family: 'Lexend', sans-serif;
        }

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

        <div class="flex-1 flex items-center bg-secondary justify-center p-0 md:p-4 md:bg-lightbg md:w-1/2">
            <div class="w-full max-w-sm p-6 md:p-8 bg-secondary  md:bg-white md:rounded-card-lg md:border-4 md:border-dark md:shadow-offset-dark">
                <x-validation-errors class="mb-4" />

                <div class="flex flex-col justify-start w-full">
                    <a href="#" class="text-dark hover:text-gray-900 mb-4 flex items-center text-sm">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Kembali
                    </a>
                    <h2 class="text-3xl font-bold mb-1 text-dark">Daftar Akun</h2>
                    <p class="text-sm mb-6 text-dark">Buat akun baru untuk memulai perjalanan Anda</p>
                </div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-dark mb-1">Nama</label>
                        <input id="name" class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 bg-logininput placeholder-placeholder placeholder-slate-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan Nama Anda" />
                    </div>

                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-dark mb-1">Username</label>
                        <input id="username" class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 bg-logininput placeholder-placeholder placeholder-slate-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="Masukkan Username Anda" />
                    </div>

                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-dark mb-1">Email</label>
                        <input id="email" class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 bg-logininput placeholder-placeholder placeholder-slate-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="Masukkan Email Anda" />
                    </div>

                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-dark mb-1">Kata sandi</label>
                        <input id="password" class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 bg-logininput placeholder-placeholder placeholder-slate-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" type="password" name="password" required autocomplete="new-password" placeholder="Masukkan Kata Sandi" />
                    </div>

                    <div class="mb-4">
                        <label for="password_confirmation" class="block text-sm font-medium text-dark mb-1">Konfirmasi Kata Sandi</label>
                        <input id="password_confirmation" class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 bg-logininput placeholder-placeholder placeholder-slate-700 focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi Kata Sandi" />
                    </div>

                    <div class="flex justify-center mt-6">
                        <button type="submit" class="w-full px-4 py-2 font-bold text-dark bg-primary rounded-playful border-2 border-dark shadow-offset-dark transition-all duration-200 hover:bg-[#a9d1a9] hover:shadow-[3px_4px_0_#080330]">
                            Daftar
                        </button>
                    </div>

                    <div class="text-center mt-6 text-sm">
                        <p>Sudah punya akun?
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="text-dark font-bold underline">Masuk disini</a>
                            @endif
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>