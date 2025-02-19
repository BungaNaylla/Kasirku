<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kasir - Transaksi</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-900 flex font-sans" x-data="cart">

    @include('components.sidebar')

    <div class="flex-1 pl-56 p-8">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6">Transaksi</h2>

        <!-- Form Input -->
        <div class="bg-white p-6 shadow-md rounded-lg border border-gray-200">
            <div class="mb-4 relative" x-data="memberSearch()">
                <label for="member" class="block text-gray-700 font-medium">Nama Member</label>
                <input type="text" id="member" x-model="searchQuery" @input="fetchMembers"
                    placeholder="Masukkan nama pelanggan"
                    class="w-full border p-3 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                <div class="absolute bg-white border w-full mt-1 shadow-md rounded-md z-10" x-show="showDropdown">
                    <template x-for="(member, index) in members" :key="index">
                        <div @click="selectMember(member)" class="p-2 hover:bg-gray-200 cursor-pointer">
                            <span x-text="member.nama"></span>
                        </div>
                    </template>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="barang" class="block text-gray-700 font-medium">Cari Barang</label>
                    <input type="text" id="barang" x-model="search" @input="fetchProducts" placeholder="Masukkan nama barang" class="w-full border p-3 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                    <div class="absolute bg-white border w-full mt-1 shadow-md rounded-md z-10" x-show="showDropdown">
                        <template x-for="(product, index) in products" :key="index">
                            <div @click="selectProduct(product)" class="p-2 hover:bg-gray-200 cursor-pointer">
                                <span x-text="product.nama"></span>
                            </div>
                        </template>
                    </div>
                </div>
                <div>
                    <label for="jumlah" class="block text-gray-700 font-medium">Jumlah</label>
                    <input type="number" id="jumlah" x-model="quantity" class="w-full border p-3 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
            </div>
            <button @click="addItem" class="mt-4 px-5 py-2 bg-blue-600 text-white font-medium rounded-md shadow hover:bg-blue-700 transition">
                Tambah Barang
            </button>
        </div>

        <!-- Keranjang -->
        <div class="mt-8 bg-white p-6 shadow-md rounded-lg border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Keranjang</h3>
            <table class="w-full border-collapse">
                <thead>
                    <tr class="bg-gray-100 text-gray-700 text-left">
                        <th class="p-3">No</th>
                        <th class="p-3">Kode Barang</th>
                        <th class="p-3">Nama</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Jumlah</th>
                        <th class="p-3">Subtotal</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <template x-for="(item, index) in items" :key="index">
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="p-3" x-text="index + 1"></td>
                            <td class="p-3" x-text="item.kode"></td>
                            <td class="p-3" x-text="item.nama"></td>
                            <td class="p-3" x-text="'Rp ' + item.harga.toLocaleString()"></td>
                            <td class="p-3" x-text="item.jumlah"></td>
                            <td class="p-3 font-semibold text-gray-900" x-text="'Rp ' + (item.harga * item.jumlah).toLocaleString()"></td>
                            <td class="p-3 text-center">
                                <button @click="removeItem(index)" class="px-3 py-1 bg-red-500 text-white text-sm rounded-md shadow hover:bg-red-600 transition">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    </template>
                </tbody>
            </table>
        </div>

        <!-- Pembayaran -->
        <div class="mt-8 bg-white p-6 shadow-md rounded-lg border border-gray-200">
            <h3 class="text-xl font-semibold text-gray-800 mb-4">Pembayaran</h3>
            <div class="mb-4">
                <label for="nominal" class="block text-gray-700 font-medium">Nominal Uang</label>
                <input type="number" id="nominal" x-model="nominalUang" @input="hitungKembalian" class="w-full border p-3 rounded-md focus:ring-2 focus:ring-blue-400 outline-none">
            </div>
            <h3 class="text-lg font-medium text-gray-700">Total: <span class="text-gray-900" x-text="'Rp ' + total.toLocaleString()"></span></h3>
            <h3 class="text-lg font-medium text-green-600">Kembalian: <span x-text="'Rp ' + kembalian.toLocaleString()"></span></h3>
            <button @click="prosesTransaksi" class="mt-4 px-6 py-3 bg-green-500 text-white font-medium rounded-md shadow hover:bg-green-600 transition">
                Proses Transaksi
            </button>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('memberSearch', () => ({
                searchQuery: '',
                members: [],
                showDropdown: false,

                async fetchMembers() {
                    if (this.searchQuery.length > 2) {
                        let response = await fetch(`/members/search?q=${this.searchQuery}`);
                        this.members = await response.json();
                        this.showDropdown = this.members.length > 0;
                    } else {
                        this.showDropdown = false;
                    }
                },

                selectMember(member) {
                    this.searchQuery = member.nama;
                    this.showDropdown = false;
                }
            }));

            Alpine.data('cart', () => ({
                items: [],
                total: 0,
                search: '',
                quantity: 1,
                nominalUang: 0,
                kembalian: 0,
                products: [],
                showDropdown: false,
                member_id: null,

                async fetchProducts() {
                    if (this.search.trim() === '') {
                        this.products = [];
                        this.showDropdown = false;
                        return;
                    }

                    let response = await fetch(`/products/search?q=${this.search}`);
                    let result = await response.json();

                    this.products = result;
                    this.showDropdown = this.products.length > 0;
                },

                selectProduct(product) {
                    this.search = product.nama;
                    this.showDropdown = false;
                },

                addItem() {
                    if (this.search.trim() === '' || this.quantity <= 0) {
                        alert('Harap lengkapi data barang!');
                        return;
                    }

                    let selectedProduct = this.products.find(product => product.nama === this.search);
                    if (!selectedProduct) {
                        alert('Barang tidak ditemukan!');
                        return;
                    }

                    let existingItem = this.items.find(item => item.kode === selectedProduct.kode);
                    if (existingItem) {
                        existingItem.jumlah += this.quantity;
                    } else {
                        this.items.push({
                            kode: selectedProduct.kode,
                            nama: selectedProduct.nama,
                            harga: selectedProduct.harga,
                            jumlah: this.quantity,
                            product_id: selectedProduct.id,
                            subtotal: selectedProduct.harga * this.quantity
                        });
                    }

                    this.total += selectedProduct.harga * this.quantity;
                    this.hitungKembalian();
                    this.search = '';
                    this.quantity = 1;
                    this.products = [];
                    this.showDropdown = false;
                },

                removeItem(index) {
                    this.total -= this.items[index].harga * this.items[index].jumlah;
                    this.items.splice(index, 1);
                    this.hitungKembalian();
                },

                hitungKembalian() {
                    this.kembalian = Math.max(this.nominalUang - this.total, 0);
                },

                async prosesTransaksi() {
                    if (!this.member_id) {
                        alert('Harap pilih member!');
                        return;
                    }

                    let response = await fetch('/transactions', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            member_id: this.member_id,
                            items: this.items,
                            total: this.total,
                            nominal_uang: this.nominalUang,
                            kembalian: this.kembalian
                        })
                    });

                    let result = await response.json();
                    if (response.ok) {
                        alert('Transaksi berhasil disimpan');
                        this.items = [];
                        this.total = 0;
                        this.nominalUang = 0;
                        this.kembalian = 0;
                    } else {
                        alert('Terjadi kesalahan: ' + result.message);
                    }
                }
            }));
        });
    </script>
</body>
</html>
