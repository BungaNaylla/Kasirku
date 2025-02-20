<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100 font-sans flex min-h-screen">

    <!-- Sidebar -->
    @include('components.sidebar')

    <!-- Konten Utama -->
    <div class="flex-1 pl-56 p-5 bg-white">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">Dashboard</h1>
        <p class="text-gray-600">Selamat datang, Admin!</p>

        <!-- Kotak Statistik Utama -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">

            <!-- Kotak Jumlah Transaksi (Belum diambil dari database) -->
            <div class="bg-blue-500 text-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold">Total Transaksi</h2>
                <p class="text-3xl font-bold mt-2">-</p> <!-- Belum diambil dari database -->
            </div>

            <!-- Kotak Jumlah Stok Barang (Sudah bisa diambil dari database) -->
            <div class="bg-green-500 text-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold">Total Stok Barang</h2>
                <p class="text-3xl font-bold mt-2">{{ $totalStokBarang }}</p> <!-- Stok barang dari database -->
            </div>

            <!-- Kotak Total Pendapatan (Belum diambil dari database) -->
            <div class="bg-yellow-500 text-white p-6 rounded-lg shadow-md">
                <h2 class="text-xl font-semibold">Total Pendapatan</h2>
                <p class="text-3xl font-bold mt-2">Rp -</p> <!-- Belum diambil dari database -->
            </div>
        </div>

    <script>
        fetch('/total-stok-barang')
        .then(response => response.json())
        .then(data => {
            document.getElementById('total-stok-barang').innerText = data.totalStokBarang;
        });
        // Data Dummy untuk sementara (nanti diganti dengan data dari controller)
        const transaksiData = {
            'Minggu 1': 10,
            'Minggu 2': 15,
            'Minggu 3': 7,
            'Minggu 4': 12
        };

        // Konversi data dummy ke format Chart.js
        const labels = Object.keys(transaksiData);
        const data = Object.values(transaksiData);

        // Inisialisasi Chart.js
        const ctx = document.getElementById('transaksiChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Jumlah Transaksi',
                    data: data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>

</body>

</html>
