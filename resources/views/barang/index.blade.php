@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 p-4 md:p-6">

    <div class="max-w-7xl mx-auto">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">

            <div>

                <h1 class="text-2xl md:text-4xl font-bold text-gray-800">
                    Kelola Stok Barang
                </h1>

                <p class="text-gray-500 mt-2 text-sm md:text-base">
                    Kelola stok dan produk toko secara realtime
                </p>

            </div>

        </div>

        {{-- ALERT --}}
        @if (session('success'))

            <div class="bg-green-100 border border-green-300 text-green-700 px-5 py-4 rounded-2xl mb-6 shadow-sm text-sm md:text-base">
                {{ session('success') }}
            </div>

        @endif

        @if (session('error'))

            <div class="bg-red-100 border border-red-300 text-red-700 px-5 py-4 rounded-2xl mb-6 shadow-sm text-sm md:text-base">
                {{ session('error') }}
            </div>

        @endif

        {{-- CARD STATISTIK --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-5 mb-8">

            {{-- TOTAL PRODUK --}}
            <div class="bg-blue-500 rounded-3xl p-6 text-white shadow-lg flex items-center justify-between">

                <div>

                    <p class="opacity-80 text-sm">
                        Total Produk
                    </p>

                    <h2 class="text-4xl md:text-5xl font-bold mt-3">
                        {{ $barangs->count() }}
                    </h2>

                </div>

                <svg class="w-12 h-12 md:w-14 md:h-14 opacity-80"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-14L4 7m8 4v10M4 7v10l8 4" />

                </svg>

            </div>

            {{-- TOTAL STOK --}}
            <div class="bg-green-500 rounded-3xl p-6 text-white shadow-lg flex items-center justify-between">

                <div>

                    <p class="opacity-80 text-sm">
                        Total Stok
                    </p>

                    <h2 class="text-4xl md:text-5xl font-bold mt-3">
                        {{ $barangs->sum('stok') }}
                    </h2>

                </div>

                <svg class="w-12 h-12 md:w-14 md:h-14 opacity-80"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M3 7l9-4 9 4-9 4-9-4zm0 0v10l9 4 9-4V7" />

                </svg>

            </div>

            {{-- STOK KOSONG --}}
            <div class="bg-red-500 rounded-3xl p-6 text-white shadow-lg flex items-center justify-between sm:col-span-2 xl:col-span-1">

                <div>

                    <p class="opacity-80 text-sm">
                        Stok Kosong
                    </p>

                    <h2 class="text-4xl md:text-5xl font-bold mt-3">
                        {{ $barangs->where('stok', 0)->count() }}
                    </h2>

                </div>

                <svg class="w-12 h-12 md:w-14 md:h-14 opacity-80"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="1.8"
                    viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M18.364 5.636L5.636 18.364M6.343 6.343a8 8 0 1011.314 11.314A8 8 0 006.343 6.343z" />

                </svg>

            </div>

        </div>

        {{-- FORM BARANG KELUAR --}}
        <div class="bg-white rounded-3xl shadow-lg p-5 md:p-6 mb-8">

            <div class="mb-6">

                <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                    Barang Terjual
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Kurangi stok produk yang sudah terjual
                </p>

            </div>

            <form method="POST"
                action="/stok-barang/keluar"
                class="grid grid-cols-1 md:grid-cols-3 gap-4">

                @csrf

                <input
                    name="kode_barang"
                    placeholder="Masukkan kode barang"
                    class="border border-gray-300 rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-red-400 w-full">

                <input
                    name="jumlah"
                    type="number"
                    placeholder="Jumlah terjual"
                    class="border border-gray-300 rounded-2xl p-4 focus:outline-none focus:ring-2 focus:ring-red-400 w-full">

                <button
                    class="bg-red-500 hover:bg-red-600 text-white rounded-2xl font-semibold transition shadow-md py-4">

                    Kurangi Stok

                </button>

            </form>

        </div>

        {{-- DATA BARANG --}}
        <div class="bg-white rounded-3xl shadow-lg overflow-hidden">

            {{-- HEADER TABLE --}}
            <div class="p-5 md:p-6 border-b bg-gray-50">

                <div class="flex flex-col xl:flex-row xl:items-center xl:justify-between gap-4">

                    <div>

                        <h2 class="text-xl md:text-2xl font-bold text-gray-800">
                            Data Barang
                        </h2>

                        <p class="text-gray-500 text-sm mt-1">
                            Semua produk yang tersedia di toko
                        </p>

                    </div>

                    <div class="flex flex-col md:flex-row gap-3 w-full xl:w-auto">

                        {{-- SEARCH --}}
                        <form method="GET"
                            action="/stok-barang"
                            class="w-full">

                            <input
                                name="q"
                                value="{{ request('q') }}"
                                placeholder="Cari nama / kode barang..."
                                class="w-full border border-gray-300 rounded-2xl p-3 focus:outline-none focus:ring-2 focus:ring-blue-400"
                                oninput="this.form.submit()">

                        </form>

                        {{-- BUTTON --}}
                        <a href="/stok-barang/create"
                            class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-2xl shadow-md transition whitespace-nowrap text-center">

                            + Tambah Barang

                        </a>

                    </div>

                </div>

            </div>

            {{-- MOBILE CARD --}}
            <div class="block lg:hidden p-4 space-y-4">

                @foreach ($barangs as $b)

                    <div class="border border-gray-200 rounded-3xl p-4 shadow-sm">

                        <div class="flex gap-4">

                            @if ($b->gambar)

                                <img src="{{ asset($b->gambar) }}"
                                    class="w-20 h-20 rounded-2xl object-cover border">

                            @else

                                <div class="w-20 h-20 rounded-2xl bg-gray-200 flex items-center justify-center text-xs text-gray-500">
                                    No Image
                                </div>

                            @endif

                            <div class="flex-1 min-w-0">

                                <h3 class="font-bold text-gray-800 text-lg break-words">
                                    {{ $b->nama }}
                                </h3>

                                <p class="text-sm text-gray-500 mt-1 break-all">
                                    {{ $b->kode_barang }}
                                </p>

                                <div class="mt-3 flex flex-wrap gap-2">

                                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-xl text-sm font-bold">
                                        Stok: {{ $b->stok }}
                                    </span>

                                    @if ($b->stok > 0)

                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-xl text-xs font-bold">
                                            Tersedia
                                        </span>

                                    @else

                                        <span class="bg-red-100 text-red-700 px-3 py-1 rounded-xl text-xs font-bold">
                                            Kosong
                                        </span>

                                    @endif

                                </div>

                                <div class="mt-3 font-bold text-blue-600 text-lg">
                                    Rp {{ number_format($b->harga_jual) }}
                                </div>

                            </div>

                        </div>

                        <div class="flex gap-2 mt-5">

                            <a href="/stok-barang/edit/{{ $b->id }}"
                                class="flex-1 bg-blue-500 hover:bg-blue-600 text-white py-3 rounded-xl text-center text-sm font-semibold transition">

                                Edit

                            </a>

                            <form method="POST"
                                action="/stok-barang/{{ $b->id }}"
                                class="flex-1">

                                @csrf
                                @method('DELETE')

                                <button
                                    onclick="return confirm('Hapus barang ini?')"
                                    class="w-full bg-red-500 hover:bg-red-600 text-white py-3 rounded-xl text-sm font-semibold transition">

                                    Hapus

                                </button>

                            </form>

                        </div>

                    </div>

                @endforeach

            </div>

            {{-- DESKTOP TABLE --}}
            <div class="hidden lg:block overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-gray-300 text-gray-600 text-sm">

                        <tr>

                            <th class="p-5 text-left">
                                Produk
                            </th>

                            <th class="p-5 text-left">
                                Kode
                            </th>

                            <th class="p-5 text-left">
                                Stok
                            </th>

                            <th class="p-5 text-left">
                                Status
                            </th>

                            <th class="p-5 text-left">
                                Harga
                            </th>

                            <th class="p-5 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($barangs as $b)

                            <tr class="border-b hover:bg-gray-50 transition">

                                {{-- PRODUK --}}
                                <td class="p-5">

                                    <div class="flex items-center gap-4">

                                        @if ($b->gambar)

                                            <img src="{{ asset($b->gambar) }}"
                                                class="w-16 h-16 rounded-2xl object-cover border shadow-sm">

                                        @else

                                            <div class="w-16 h-16 rounded-2xl bg-gray-200 flex items-center justify-center text-gray-400 text-xs">
                                                No Image
                                            </div>

                                        @endif

                                        <div>

                                            <h3 class="font-bold text-gray-800 text-lg">
                                                {{ $b->nama }}
                                            </h3>

                                            <p class="text-sm text-gray-500">
                                                Produk toko
                                            </p>

                                        </div>

                                    </div>

                                </td>

                                {{-- KODE --}}
                                <td class="p-5 text-gray-600 font-medium">
                                    {{ $b->kode_barang }}
                                </td>

                                {{-- STOK --}}
                                <td class="p-5">

                                    <span class="bg-blue-100 text-blue-600 px-4 py-2 rounded-xl font-bold">
                                        {{ $b->stok }}
                                    </span>

                                </td>

                                {{-- STATUS --}}
                                <td class="p-5">

                                    @if ($b->stok > 0)

                                        <span class="bg-green-100 text-green-700 px-4 py-2 rounded-full text-xs font-bold">
                                            Tersedia
                                        </span>

                                    @else

                                        <span class="bg-red-100 text-red-700 px-4 py-2 rounded-full text-xs font-bold">
                                            Kosong
                                        </span>

                                    @endif

                                </td>

                                {{-- HARGA --}}
                                <td class="p-5 font-bold text-blue-600 text-lg">

                                    Rp {{ number_format($b->harga_jual) }}

                                </td>

                                {{-- AKSI --}}
                                <td class="p-5">

                                    <div class="flex justify-center gap-3">

                                        <a href="/stok-barang/edit/{{ $b->id }}"
                                            class="bg-blue-500 hover:bg-blue-600 text-white px-5 py-2 rounded-xl text-sm shadow transition">

                                            Edit

                                        </a>

                                        <form method="POST"
                                            action="/stok-barang/{{ $b->id }}">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                onclick="return confirm('Hapus barang ini?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-5 py-2 rounded-xl text-sm shadow transition">

                                                Hapus

                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection