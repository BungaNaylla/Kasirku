<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Barang</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <style>
        .sidebar {
            height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
            padding: 15px;
        }

        .btn-action {
            padding: 5px 10px;
            font-size: 14px;
            text-align: center;
        }

        table {
            width: 100%;
            white-space: nowrap;
        }
    </style>
</head>

<body class="bg-gray-100" x-data="{
    openModal: false,
    openEditModal: false,
    selectedProduct: {},
    form: { kode_barang: '', NamaProduk: '', Harga: '', Stok: '' },
    errors: {},
    searchQuery: '',
    validateForm() {
        let valid = true;
        this.errors = {};

        if (!this.form.kode_barang) {
            this.errors.kode_barang = 'Kode Barang wajib diisi';
            valid = false;
        }
        if (!this.form.NamaProduk) {
            this.errors.NamaProduk = 'Nama Produk wajib diisi';
            valid = false;
        }
        if (!this.form.Harga) {
            this.errors.Harga = 'Harga wajib diisi';
            valid = false;
        }
        if (!this.form.Stok) {
            this.errors.Stok = 'Stok wajib diisi';
            valid = false;
        }
        return valid;
    },
    editProduct(product) {
        this.selectedProduct = product;
        this.form = { ...product };
        this.openEditModal = true;
    }
}">
    <div class="sidebar">
        @include('components.sidebar')
    </div>

    <div class="flex-1 pl-56 p-5">
        <h1 class="text-2xl font-bold mb-4">Halaman Data Barang</h1>

        <div class="flex justify-between mb-4">
            <input type="text" placeholder="Cari berdasarkan kode atau nama..." class="border p-2 rounded-lg w-1/3"
                x-model="searchQuery">
            <button @click="openModal = true" class="bg-blue-500 text-white px-4 py-2 rounded-lg">+ Tambah Data</button>
        </div>

        <div class="bg-white p-4 shadow-md rounded-lg overflow-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-center">
                        <th class="border px-2 py-2">No</th>
                        <th class="border px-2 py-2">Kode</th>
                        <th class="border px-2 py-2">Nama Barang</th>
                        <th class="border px-2 py-2">Harga</th>
                        <th class="border px-2 py-2">Qty</th>
                        <th class="border px-2 py-2">Subtotal</th>
                        <th class="border px-2 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $index => $barang)
                        <template
                            x-if="{{ json_encode($barang->kode_barang) }}.includes(searchQuery) || {{ json_encode($barang->NamaProduk) }}.toLowerCase().includes(searchQuery.toLowerCase())">
                            <tr class="text-center border">
                                <td class="border px-2 py-2">{{ $index + 1 }}</td>
                                <td class="border px-2 py-2">{{ $barang->kode_barang }}</td>
                                <td class="border px-2 py-2">{{ $barang->NamaProduk }}</td>
                                <td class="border px-2 py-2">Rp{{ number_format($barang->Harga, 0, ',', '.') }}</td>
                                <td class="border px-2 py-2">{{ $barang->Stok }}</td>
                                <td class="border px-2 py-2">
                                    Rp{{ number_format($barang->Harga * $barang->Stok, 0, ',', '.') }}</td>
                                <td class="border px-2 py-2 flex justify-center space-x-1">
                                    <button class="btn-action bg-yellow-500 text-white rounded"
                                        @click="editProduct({{ json_encode($barang) }})">
                                        Edit
                                    </button>
                                    <button class="btn-action bg-red-500 text-white rounded"
                                        onclick="confirmDelete({{ $barang->id }})">
                                        Hapus
                                    </button>
                                </td>
                            </tr>
                        </template>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- Modal Edit Produk -->
        <div x-show="openEditModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
            <div class="bg-white p-6 rounded-lg w-1/3">
                <h2 class="text-xl font-bold mb-4">Edit Barang</h2>
                <form method="POST" :action="'/products/update/' + form.id" @submit.prevent="submitUpdate">
                    @csrf
                    @method('PUT')
                    <label class="block">Kode Barang:</label>
                    <input type="text" name="kode_barang" x-model="form.kode_barang" class="border p-2 w-full mb-2">
                    <span class="text-red-500 text-sm" x-show="errors.kode_barang" x-text="errors.kode_barang"></span>

                    <label class="block">Nama Produk:</label>
                    <input type="text" name="NamaProduk" x-model="form.NamaProduk" class="border p-2 w-full mb-2">
                    <span class="text-red-500 text-sm" x-show="errors.NamaProduk" x-text="errors.NamaProduk"></span>

                    <label class="block">Harga:</label>
                    <input type="number" name="Harga" x-model="form.Harga" class="border p-2 w-full mb-2">
                    <span class="text-red-500 text-sm" x-show="errors.Harga" x-text="errors.Harga"></span>

                    <label class="block">Stok:</label>
                    <input type="number" name="Stok" x-model="form.Stok" class="border p-2 w-full mb-4">
                    <span class="text-red-500 text-sm" x-show="errors.Stok" x-text="errors.Stok"></span>

                    <div class="flex justify-end space-x-2">
                        <button type="button" @click="openEditModal = false"
                            class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                        <button type="submit" class="bg-yellow-500 text-white px-4 py-2 rounded">Update</button>
                    </div>
                </form>
            </div>
        </div>
        <form id="delete-form-{{ $barang->id }}" method="POST"
            action="{{ route('products.destroy', $barang->id) }}" class="hidden">
            @csrf
            @method('DELETE')
        </form>

        <div class="mt-4">
            {{ $products->links() }}
        </div>
    </div>

    <!-- Modal Tambah Produk -->
    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Tambah Barang</h2>
            <form method="POST" action="{{ route('products.store') }}"
                @submit.prevent="if (validateForm()) $event.target.submit()">
                @csrf
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <label class="block">Kode Barang:</label>
                <input type="text" name="kode_barang" x-model="form.kode_barang" class="border p-2 w-full mb-2">
                <span class="text-red-500 text-sm" x-show="errors.kode_barang" x-text="errors.kode_barang"></span>

                <label class="block">Nama Produk:</label>
                <input type="text" name="NamaProduk" x-model="form.NamaProduk" class="border p-2 w-full mb-2">
                <span class="text-red-500 text-sm" x-show="errors.NamaProduk" x-text="errors.NamaProduk"></span>

                <label class="block">Harga:</label>
                <input type="number" name="Harga" x-model="form.Harga" class="border p-2 w-full mb-2">
                <span class="text-red-500 text-sm" x-show="errors.Harga" x-text="errors.Harga"></span>

                <label class="block">Stok:</label>
                <input type="number" name="Stok" x-model="form.Stok" class="border p-2 w-full mb-4">
                <span class="text-red-500 text-sm" x-show="errors.Stok" x-text="errors.Stok"></span>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="openModal = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function confirmDelete(productId) {
            if (confirm("Apakah Anda yakin ingin menghapus produk ini?")) {
                document.getElementById('delete-form-' + productId).submit();
            }
        }
        submitUpdate() {
            fetch(`/products/update/${this.form.id}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify(this.form)
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload(); // Reload halaman agar data terupdate
                    } else {
                        alert("Gagal update data!");
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>
</body>

</html>
