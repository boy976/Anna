<div class="w-64 bg-gray-900 text-white p-6 fixed h-full">
    <h1 class="text-3xl font-bold mb-10 flex items-center gap-3">
        <span>ANNA SHOPP</span>
    </h1>

    <ul class="space-y-3">
        <li>
            <a href="/"
                class="flex items-center gap-3 p-4 rounded-2xl {{ request()->is('/') ? 'bg-blue-500 font-semibold shadow-lg' : 'hover:bg-gray-800 transition' }}">
                <!-- Heroicon: Home -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 9.75L12 3l9 6.75V21a1.5 1.5 0 01-1.5 1.5H4.5A1.5 1.5 0 013 21V9.75z" />
                </svg>
                Dashboard
            </a>
        </li>

        <li>
            <a href="/stok-barang"
                class="flex items-center gap-3 p-4 rounded-2xl {{ request()->is('barang*') ? 'bg-blue-500 font-semibold shadow-lg' : 'hover:bg-gray-800 transition' }}">
                <!-- Heroicon: Squares 2x2 -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2z" />
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                </svg>
                Kelola Barang
            </a>
        </li>

        <li>
            <a href="/transaksi" class="flex items-center gap-3 p-4 rounded-2xl hover:bg-gray-800 transition">
                <!-- Heroicon: Credit Card -->
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.0"
                    stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M3 7a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18" />
                </svg>
                Transaksi
            </a>
        </li>
    </ul>
</div>
