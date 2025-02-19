<aside class="h-screen w-54 bg-white shadow-lg fixed top-0 left-0 flex flex-col">
    <!-- Logo -->
    <div class="flex items-center space-x-2 p-6 border-b border-gray-200">
        <img src="{{ asset('storage/logo.jpg') }}" alt="Logo" class="h-10 w-auto">
        <span class="text-2xl font-bold text-gray-800">TOSERBA</span>
    </div>

    <!-- Menu Navigasi -->
    <nav class="flex-1 p-4">
        <ul class="space-y-4">
            <li>
                <a href="{{ url('/beranda') }}"
                    class="block p-2 rounded-lg {{ request()->is('beranda') ? 'bg-[#7887C6] text-white' : 'hover:bg-gray-200 text-gray-600' }}">
                    Beranda
                </a>
            </li>
            <li>
                <a href="{{ url('/transaction') }}"
                    class="block p-2 rounded-lg {{ request()->is('transaction*') ? 'bg-[#7887C6] text-white' : 'hover:bg-gray-200 text-gray-600' }}">
                    Transaksi
                </a>
            </li>
            <li>
                <a href="{{ url('/databarang') }}"
                    class="block p-2 rounded-lg {{ request()->is('databarang') ? 'bg-[#7887C6] text-white' : 'hover:bg-gray-200 text-gray-600' }}">
                    Data Barang
                </a>
            </li>
            <li>
                <a href="{{ url('/member') }}"
                    class="block p-2 rounded-lg {{ request()->is('member') ? 'bg-[#7887C6] text-white' : 'hover:bg-gray-200 text-gray-600' }}">
                    Data Member
                </a>
            </li>
            <li>
                <a href="{{ url('/datapetugas') }}"
                    class="block p-2 rounded-lg {{ request()->is('datapetugas') ? 'bg-[#7887C6] text-white' : 'hover:bg-gray-200 text-gray-600' }}">
                    Data Petugas
                </a>
            </li>
            <li>
                <a href="{{ url('/laporan') }}"
                    class="block p-2 rounded-lg {{ request()->is('laporan') ? 'bg-[#7887C6] text-white' : 'hover:bg-gray-200 text-gray-600' }}">
                    Laporan
                </a>
            </li>
        </ul>
    </nav>

    <!-- Menu Keluar -->
    <div class="p-4 border-t border-gray-200">
        <a href="#" onclick="return confirmLogout()"
            class="flex items-center space-x-2 p-2 rounded-lg hover:bg-gray-200 text-gray-600">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10v1m-6 5h6" />
            </svg>
            <span>Keluar</span>
        </a>
    </div>

    <script>
        function confirmLogout() {
            return confirm("Apakah Anda yakin ingin keluar?");
        }
    </script>
</aside>
