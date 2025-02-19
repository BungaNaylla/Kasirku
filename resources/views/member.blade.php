<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Member</title>
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
    selectedMember: {},
    form: { NamaMember: '', Alamat: '', NomorTelepon: '' },
    errors: {},
    searchQuery: '',
    validateForm() {
        let valid = true;
        this.errors = {};

        if (!this.form.NamaMember) {
            this.errors.NamaMember = 'Nama Member wajib diisi';
            valid = false;
        }
        if (!this.form.Alamat) {
            this.errors.Alamat = 'Alamat wajib diisi';
            valid = false;
        }
        if (!this.form.NomorTelepon) {
            this.errors.NomorTelepon = 'Nomor Telepon wajib diisi';
            valid = false;
        }
        return valid;
    },
    editMember(member) {
        this.selectedMember = member;
        this.form = { ...member };
        this.openEditModal = true;
    }
}">
    <div class="sidebar">
        @include('components.sidebar')
    </div>

    <div class="flex-1 pl-56 p-5">
        <h1 class="text-2xl font-bold mb-4">Halaman Data Member</h1>

        <div class="flex justify-between mb-4">
            <input type="text" placeholder="Cari berdasarkan nama..." class="border p-2 rounded-lg w-1/3"
                x-model="searchQuery">
            <button @click="openModal = true" class="bg-blue-500 text-white px-4 py-2 rounded-lg">+ Tambah
                Member</button>
        </div>

        <div class="bg-white p-4 shadow-md rounded-lg overflow-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-center">
                        <th class="border px-2 py-2">No</th>
                        <th class="border px-2 py-2">Nama</th>
                        <th class="border px-2 py-2">Alamat</th>
                        <th class="border px-2 py-2">Nomor Telepon</th>
                        <th class="border px-2 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($members as $index => $member)
                        <template
                            x-if="{{ json_encode($member->NamaMember) }}.toLowerCase().includes(searchQuery.toLowerCase())">
                            <tr class="text-center border">
                                <td class="border px-2 py-2">{{ $index + 1 }}</td>
                                <td class="border px-2 py-2">{{ $member->NamaMember }}</td>
                                <td class="border px-2 py-2">{{ $member->Alamat }}</td>
                                <td class="border px-2 py-2">{{ $member->NomorTelepon }}</td>
                                <td class="border px-2 py-2 flex justify-center space-x-1">
                                    <button class="btn-action bg-yellow-500 text-white rounded"
                                        @click="editMember({{ json_encode($member) }})">Edit</button>
                                    <button class="btn-action bg-red-500 text-white rounded"
                                        onclick="confirmDelete({{ $member->id }})">Hapus</button>
                                </td>
                            </tr>
                        </template>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $members->links() }}
        </div>
    </div>

    <!-- Modal Tambah Member -->
    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Tambah Member</h2>
            <form method="POST" action="{{ route('members.store') }}"
                @submit.prevent="if (validateForm()) $event.target.submit()">
                @csrf
                <label class="block">Nama Member:</label>
                <input type="text" name="NamaMember" x-model="form.NamaMember" class="border p-2 w-full mb-2">
                <span class="text-red-500 text-sm" x-show="errors.NamaMember" x-text="errors.NamaMember"></span>

                <label class="block">Alamat:</label>
                <input type="text" name="Alamat" x-model="form.Alamat" class="border p-2 w-full mb-2">
                <span class="text-red-500 text-sm" x-show="errors.Alamat" x-text="errors.Alamat"></span>

                <label class="block">Nomor Telepon:</label>
                <input type="text" name="NomorTelepon" x-model="form.NomorTelepon" class="border p-2 w-full mb-2"
                    pattern="[0-9]{10,15}" title="Nomor telepon harus berupa angka dan minimal 10 digit"
                    @input="form.NomorTelepon = form.NomorTelepon.replace(/\D/g, '')">

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="openModal = false"
                        class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
