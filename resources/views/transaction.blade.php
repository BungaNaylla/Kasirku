<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi - Aplikasi Kasir</title>
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>

    <div class="sidebar">
        @include('components.sidebar')
    </div>

    <!-- Main Content -->
    <div class="lex-1 pl-56 p-5">
        <div class="grid grid-cols-2 gap-4">
            <!-- Input Section -->
            <div x-data="searchProduct()" class="bg-white p-5 shadow-md rounded-lg relative">
                <h2 class="text-xl font-bold mb-4">Tambahkan Barang</h2>

                <!-- Input Pencarian Produk -->
                <input type="text" x-model="search" x-on:input="filterProducts"
                    class="w-full p-2 border rounded mb-4" placeholder="Nama Barang" />

                <!-- Daftar Produk (AutoComplete) -->
                <ul x-show="search.length > 0">
                    @foreach ($products as $product)
                        <li @click="selectProduct({{ json_encode($product) }})">{{ $product->NamaProduk }}</li>
                    @endforeach
                </ul>

                <input type="number" x-model="qty" class="w-full p-2 border rounded mb-4" placeholder="Qty"
                    value="1" />
                <div class="flex space-x-2">
                    <button class="bg-red-500 text-white px-4 py-2 rounded" @click="removeItem(index)">Hapus</button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded" @click="addItem()">Tambah Item</button>
                </div>
            </div>

            <!-- Cart Section -->
            <div class="bg-white p-5 shadow-md rounded-lg">
                <h2 class="text-xl font-bold mb-4">TOTAL</h2>
                <div class="mb-4">
                    <label class="block font-bold">Kasir</label>
                    <input type="text" class="w-full p-2 border rounded" value="Admin" disabled />
                </div>
                <div class="mb-4">
                    <label class="block font-bold">Nama Member</label>
                    {{-- {{ dd($members) }} --}}
                    <select name="member_id" class="w-full p-2 border rounded">
                        <option value="">Pilih Member</option>
                        @foreach ($members as $member)
                            <option value="{{ $member->id }}">{{ $member['NamaMember'] }}</option>
                        @endforeach
                    </select>
                </div>
                <table class="w-full border">
                    <thead>
                        <tr class="bg-gray-200">
                            <th class="p-2">Kode</th>
                            <th class="p-2">Nama Barang</th>
                            <th class="p-2">Harga</th>
                            <th class="p-2">Qty</th>
                            <th class="p-2">Sub Total</th>
                            <th class="p-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="(item, index) in selectedProducts" :key="item.id">
                            <tr>
                                <td class="p-2" x-text="item.id"></td>
                                <td class="p-2" x-text="item.nama"></td>
                                <td class="p-2" x-text="item.harga"></td>
                                <td class="p-2" x-text="item.qty"></td>
                                <td class="p-2" x-text="item.subtotal"></td>
                                <td class="p-2">
                                    <button class="bg-red-500 text-white px-2 py-1 rounded" @click="removeItem(index)">Hapus</button>
                                </td>
                            </tr>
                        </template>
                        <tr>
                            <td colspan="5" class="text-center p-4 font-bold">TOTAL Rp. <span x-text="totalHarga()"></span></td>
                        </tr>
                    </tbody>
                    
                </table>
                <div class="mt-4">
                    <label class="block">Nominal (Rp.)</label>
                    <input type="number" class="w-full p-2 border rounded" value="0" />
                </div>
                <div class="flex space-x-2 mt-4">
                    <button class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                    <button class="bg-blue-500 text-white px-4 py-2 rounded">Proses Transaksi & PRINT</button>
                </div>
            </div>
        </div>

        <script>
            function searchProduct() {
                return {
                    search: "",
                    products: {!! json_encode($products) !!}, // Ambil data produk dari controller
                    filteredProducts: [],
                    selectedProducts: [],
                    qty: 1,

                    filterProducts() {
                        if (this.search.length > 0) {
                            this.filteredProducts = this.products.filter(product =>
                                product.NamaProduk.toLowerCase().includes(this.search.toLowerCase())
                            );
                        } else {
                            this.filteredProducts = [];
                        }
                    },

                    selectProduct(product) {
                        this.search = product.NamaProduk;
                        this.filteredProducts = [];
                    }

                    addItem() {
                        let product = this.products.find(p => p.NamaProduk.toLowerCase() === this.search.toLowerCase());
                        if (!product) return alert("Barang tidak ditemukan!");

                        let existingItem = this.selectedProducts.find(item => item.id === product.id);
                        if (existingItem) {
                            existingItem.qty += parseInt(this.qty);
                            existingItem.subtotal = existingItem.qty * existingItem.harga;
                        } else {
                            this.selectedProducts.push({
                                id: product.id,
                                nama: product.NamaProduk,
                                harga: product.Harga,
                                qty: parseInt(this.qty),
                                subtotal: parseInt(this.qty) * product.Harga,
                            });
                        }

                        this.search = "";
                        this.qty = 1;
                    }


                    removeItem(index) {
                        this.selectedProducts.splice(index, 1);
                    }
                    selectedMember: "",

                    totalHarga() {
                        return this.selectedProducts.reduce((sum, item) => sum + item.subtotal, 0);
                    }
                };
            }
        </script>
    </div>

</body>

</html>
