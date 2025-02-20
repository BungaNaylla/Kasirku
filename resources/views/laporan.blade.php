<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">

    <div class="sidebar">
        @include('components.sidebar')
    </div>

    <div class="flex-1 pl-56 p-5">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">Laporan Transaksi</h2>

        <!-- Form Filter Tanggal -->
        <form method="GET" action="{{ route('laporan.index') }}" class="mb-6 flex gap-4">
            <input type="date" name="tanggal" value="{{ request('tanggal') }}"
                   class="border p-2 rounded-md shadow">
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600">
                Filter
            </button>
        </form>

        <!-- Tabel Laporan -->
        <div class="bg-white shadow-md rounded-lg overflow-hidden border border-gray-200">
            <table class="w-full border-collapse">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 text-left">#</th>
                        <th class="p-3 text-left">Tanggal</th>
                        <th class="p-3 text-left">Nama Member</th>
                        <th class="p-3 text-left">Nomor Transaksi</th>
                        <th class="p-3 text-left">Detail</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($reports as $index => $report)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="p-3">{{ $index + 1 }}</td>
                        <td class="p-3">{{ $report->Tanggal }}</td>
                        <td class="p-3">{{ $report->NamaMember }}</td>
                        <td class="p-3">{{ $report->NomorTransaksi }}</td>
                        <td class="p-3">
                            <button @click="open{{ $index }} = !open{{ $index }}"
                                    class="px-3 py-1 bg-blue-500 text-white text-sm rounded-md hover:bg-blue-600">
                                Lihat Detail
                            </button>
                            <div x-data="{ open{{ $index }}: false }">
                                <div x-show="open{{ $index }}" class="mt-2 p-3 bg-gray-100 rounded-md">
                                    <pre class="text-sm">{{ json_decode($report->transaction_details, true) }}</pre>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center p-4 text-gray-600">Tidak ada data laporan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>
