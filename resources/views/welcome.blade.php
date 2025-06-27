<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Sistem Temu Janji Pasien - Dokter</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .header {
            background-color: #1E90FF;
            color: white;
            text-align: center;
            padding: 50px 0;
        }
        .header h1 {
            margin: 0;
            font-size: 2.5em;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 1em;
            color: #D3D3D3;
        }
        .content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: calc(100vh - 150px);
            gap: 50px;
        }
        .option {
            text-align: center;
            padding: 20px;
        }
        .option img {
            width: 50px;
            height: 50px;
            margin-bottom: 10px;
        }
        .option a {
            text-decoration: none;
            color: #000;
            font-size: 1.2em;
        }
        .option p {
            margin: 5px 0 0;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>Poliklinik</div>
        <h1>Sistem Temu Janji Pasien - Dokter</h1>
        {{-- <p>Bimbingan Karier 2023 Bidang Web</p> --}}
    </div>
    <div class="content">
        <div class="option">
            <img src="{{ asset('img/pasien-icon.png') }}" alt="Pasien Icon">
            <a href="{{ route('register') }}">Registrasi Sebagai Pasien</a>
            <p>Apabila Anda adalah seorang Pasien, silahkan Registrasi terlebih</p>
        </div>
        <div class="option">
            <img src="{{ asset('img/dokter-icon.png') }}" alt="Dokter Icon">
            <a href="{{ route('login') }}">Login Sebagai Dokter</a>
            <p>Apabila Anda adalah seorang Dokter, silahkan Login terlebih dahulu</p>
        </div>
    </div>
</body>
</html>