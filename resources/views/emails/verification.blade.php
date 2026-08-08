<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Akun Sejenak</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Exo2:wght@400;700&display=swap');
        body {
            font-family: 'Exo2', sans-serif;
            background-color: #f7f7f7;
            margin: 0;
            padding: 20px;
            -webkit-font-smoothing: antialiased;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background-color: #ffffff;
            border: 4px solid #080330;
            border-radius: 24px;
            box-shadow: 5px 6px 0px #080330;
            overflow: hidden;
        }
        .header {
            background-color: #94B704;
            padding: 20px;
            text-align: center;
        }
        .header h1 {
            color: #ffffff;
            font-size: 24px;
            margin: 0;
            font-weight: 700;
             text-shadow:
                -1px -1px 0 #080330,
                1px -1px 0 #080330,
                -1px 1px 0 #080330,
                1px 1px 0 #080330;
        }
        .content {
            padding: 30px;
            color: #080330;
            text-align: center;
        }
        .content p {
            font-size: 16px;
            line-height: 1.5;
            margin: 0 0 20px 0;
        }
        .code-box {
            background-color: #e6d09c;
            border: 2px solid #080330;
            border-radius: 12px;
            padding: 15px 20px;
            margin: 20px auto;
            display: inline-block;
        }
        .code {
            font-size: 36px;
            font-weight: 700;
            letter-spacing: 10px;
            color: #080330;
        }
        .footer {
            padding: 20px;
            font-size: 12px;
            color: #777777;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Sejenak</h1>
        </div>
        <div class="content">
            <p>Halo!</p>
            <p>Terima kasih telah mendaftar. Gunakan kode berikut untuk menyelesaikan proses verifikasi akun Anda:</p>
            <div class="code-box">
                <span class="code">{{ $code }}</span>
            </div>
            <p>Kode ini akan kedaluwarsa dalam 10 menit.<br>Jika Anda tidak merasa mendaftar, abaikan saja email ini.</p>
        </div>
        <div class="footer">
            © {{ date('Y') }} Sejenak. Seluruh hak cipta dilindungi undang-undang.
        </div>
    </div>
</body>
</html>