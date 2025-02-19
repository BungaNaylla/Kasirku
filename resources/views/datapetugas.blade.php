<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Petugas</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100" x-data="{
    openModal: false,
    form: { NamaLengkap: '', Username: '', Password: '', HakAkses: '' },
    errors: {},
    successMessage: '',
    search: '',
    validateForm() {
        this.errors = {};
        let valid = true;

        if (!this.form.NamaLengkap) {
            this.errors.NamaLengkap = 'Nama Lengkap wajib diisi';
            valid = false;
        }
        if (!this.form.Username) {
            this.errors.Username = 'Username wajib diisi';
            valid = false;
        }
        if (!this.form.Password) {
            this.errors.Password = 'Password wajib diisi';
            valid = false;
        }
        if (!this.form.HakAkses) {
            this.errors.HakAkses = 'Hak Akses wajib dipilih';
            valid = false;
        }

        return valid;
    }
}">

    <!-- Sidebar -->
    <div class="fixed w-56 h-screen z-50">
        @include('components.sidebar')
    </div>

    <!-- Content -->
    <div class="flex-1 pl-56 p-5">
        <h1 class="text-2xl font-bold mb-4">Halaman Data Petugas</h1>

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="flex justify-between mb-4">
            <input type="text" placeholder="Cari petugas..." class="border p-2 rounded-lg w-1/3" x-model="search">
            <button @click="openModal = true" class="bg-blue-500 text-white px-4 py-2 rounded-lg">+ Tambah Petugas</button>
        </div>

        <div class="bg-white p-4 shadow-md rounded-lg overflow-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-gray-700 text-center">
                        <th class="border px-2 py-2">No</th>
                        <th class="border px-2 py-2">Nama Lengkap</th>
                        <th class="border px-2 py-2">Username</th>
                        <th class="border px-2 py-2">Hak Akses</th>
                        <th class="border px-2 py-2">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($user as $index => $user)
                        <tr class="text-center border" x-show="{{ json_encode($user->NamaLengkap) }}.toLowerCase().includes(search.toLowerCase()) || {{ json_encode($user->Username) }}.toLowerCase().includes(search.toLowerCase())">
                            <td class="border px-2 py-2">{{ $index + 1 }}</td>
                            <td class="border px-2 py-2">{{ $user->NamaLengkap }}</td>
                            <td class="border px-2 py-2">{{ $user->Username }}</td>
                            <td class="border px-2 py-2">{{ $user->HakAkses }}</td>
                            <td class="border px-2 py-2">
                                <button class="bg-yellow-500 text-white px-2 py-1 rounded">Edit</button>
                                <button class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal Tambah Petugas -->
    <div x-show="openModal" class="fixed inset-0 flex items-center justify-center bg-gray-900 bg-opacity-50">
        <div class="bg-white p-6 rounded-lg w-1/3">
            <h2 class="text-xl font-bold mb-4">Tambah Petugas</h2>
            <form method="POST" action="{{ route('datapetugas.store') }}"
                @submit.prevent="if (validateForm()) { $event.target.submit(); setTimeout(() => { openModal = false }, 500); }">
                @csrf
                <label class="block">Nama Lengkap:</label>
                <input type="text" name="NamaLengkap" x-model="form.NamaLengkap" class="border p-2 w-full mb-2">
                <span class="text-red-500 text-sm" x-show="errors.NamaLengkap" x-text="errors.NamaLengkap"></span>

                <label class="block">Username:</label>
                <input type="text" name="Username" x-model="form.Username" class="border p-2 w-full mb-2">
                <span class="text-red-500 text-sm" x-show="errors.Username" x-text="errors.Username"></span>

                <label class="block">Password:</label>
                <input type="password" name="Password" x-model="form.Password" class="border p-2 w-full mb-2">
                <span class="text-red-500 text-sm" x-show="errors.Password" x-text="errors.Password"></span>

                <label class="block">Hak Akses:</label>
                <select name="HakAkses" x-model="form.HakAkses" class="border p-2 w-full mb-4">
                    <option value="Admin">Admin</option>
                    <option value="Kasir">Kasir</option>
                </select>
                <span class="text-red-500 text-sm" x-show="errors.HakAkses" x-text="errors.HakAkses"></span>

                <div class="flex justify-end space-x-2">
                    <button type="button" @click="openModal = false" class="bg-gray-500 text-white px-4 py-2 rounded">Batal</button>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

</body>

</html>
