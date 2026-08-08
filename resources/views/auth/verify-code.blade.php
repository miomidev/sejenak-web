<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Akun Sejenak</title>
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
<body class="flex items-center justify-center min-h-screen bg-lightbg p-4">

    <div class="w-full max-w-sm p-6 md:p-8 bg-white rounded-card-lg border-4 border-dark shadow-offset-dark">

        @if ($errors->any())
            <div class="mb-4">
                <div class="font-medium text-red-600">Ups! Ada yang salah.</div>
                <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @if (session('success'))
            <div class="mb-4 font-medium text-sm text-green-600">
                {{ session('success') }}
            </div>
        @endif
        
        @if (session('error'))
            <div class="mb-4 font-medium text-sm text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <div class="flex flex-col justify-start w-full">
            <h2 class="text-3xl font-bold mb-1 text-dark">Verifikasi Akun</h2>
            <p class="text-sm mb-6 text-dark">Kami telah mengirimkan 6 digit kode ke email Anda. Silakan masukkan di bawah ini.</p>
        </div>

        <form method="POST" action="{{ route('verification.verify') }}">
            @csrf
            
            <!-- Hidden email input -->
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="mb-4">
                <label for="verification_code" class="block text-sm font-medium text-dark mb-1">Kode Verifikasi</label>
                <input id="verification_code" class="block w-full rounded-playful border-2 border-dark shadow-offset-dark p-2 bg-logininput placeholder-placeholder focus:outline-none focus:ring-2 focus:ring-primary focus:border-transparent" type="text" name="verification_code" required autofocus autocomplete="one-time-code" placeholder="Masukkan 6 Digit Kode" />
            </div>

            <div class="flex justify-center mt-6">
                <button type="submit" class="w-full px-4 py-2 font-bold text-dark bg-primary rounded-playful border-2 border-dark shadow-offset-dark transition-all duration-200 hover:bg-[#a9d1a9] hover:shadow-[3px_4px_0_#080330]">
                    Verifikasi Akun
                </button>
            </div>
        </form>

        <div class="text-center mt-6 text-sm">
            <p>Tidak menerima kode?</p>
            <div class="mt-2 flex items-center justify-center space-x-4">
                <form method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <input type="hidden" name="email" value="{{ $email }}">
                    <button type="submit" class="text-dark font-bold underline">
                        Kirim ulang kode
                    </button>
                </form>
        
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="text-dark font-bold underline">
                        Log Out
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>