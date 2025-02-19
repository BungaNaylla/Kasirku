<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk Belanja</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>
<body class="p-6 bg-gray-100">
    <div class="max-w-md mx-auto bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-xl font-semibold text-gray-800 text-center">Struk Belanja</h2>
        <p class="text-gray-600 text-center">{{ $transaction->tanggal }}</p>
        <hr class="my-4">
        <p><strong>Nama Pelanggan:</strong> {{ $member->nama ?? 'Umum' }}</p>
        <hr class="my-2">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="border-b">
                    <th class="p-2">Barang</th>
                    <th class="p-2">Qty</th>
                    <th class="p-2">Harga</th>
                    <th class="p-2">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $item)
                <tr class="border-b">
                    <td class="p-2">{{ $item['nama'] }}</td>
                    <td class="p-2">{{ $item['jumlah'] }}</td>
                    <td class="p-2">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                    <td class="p-2">Rp {{ number_format($item['harga'] * $item['jumlah'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <hr class="my-4">
        <h3 class="text-lg font-semibold text-gray-800">Total: Rp {{ number_format($transaction->total, 0, ',', '.') }}</h3>
    </div>
</body>
</html>
