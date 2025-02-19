<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-sans flex min-h-screen">

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Konten Utama -->
    <div class="flex-1 pl-56 p-5 bg-white w-auto h-[96px] shadow-ms">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">SELAMAT DATANG!</h1>
                <p class="text-sm text-gray-600">Anda berhasil masuk sebagai Admin</p>
            </div>
        </div>
</body>
</html>
