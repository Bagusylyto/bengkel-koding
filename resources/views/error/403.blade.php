<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>403 Forbidden</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-100 to-gray-300 h-screen flex items-center justify-center">
    <div class="text-center p-8 bg-white rounded-2xl shadow-xl max-w-md">
        <div class="text-red-500 text-7xl font-bold mb-4">403</div>
        <h1 class="text-2xl font-semibold text-gray-800 mb-2">Akses Ditolak</h1>
        <p class="text-gray-600 mb-6">Maaf, Anda tidak memiliki izin untuk mengakses halaman ini.</p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-2 text-white bg-red-500 hover:bg-red-600 rounded-full shadow transition duration-300">
            Kembali ke Beranda
        </a>
    </div>
</body>
</html>