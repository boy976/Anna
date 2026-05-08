@extends('layouts.app')

@section('content')

<style>
    @font-face {
        font-family: 'Plus Jakarta Sans';
        src: url('/fonts/PlusJakartaSans-Regular.ttf') format('truetype');
    }

    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
        background: #f8fafc;
    }
</style>

<div class="min-h-screen p-4 md:p-6">

    <div class="max-w-7xl mx-auto">

        {{-- NOTIFIKASI --}}
        @if(session('success'))

            <div class="mb-6 bg-emerald-50 border border-emerald-200 text-emerald-700 px-5 py-4 rounded-2xl shadow-sm flex items-center gap-3">

                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>

                <span class="font-bold text-sm md:text-base">
                    {{ session('success') }}
                </span>

            </div>

        @endif

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 mb-8">

            <div>

                <h1 class="text-2xl md:text-4xl font-black text-slate-800 tracking-tight">
                    Transaksi Barang
                </h1>

                <p class="text-slate-500 mt-2 text-sm md:text-base">
                    Riwayat barang masuk dan keluar gudang
                </p>

            </div>

        </div>

        {{-- FILTER --}}
        <div class="bg-white rounded-[2rem] border border-slate-200 shadow-sm p-5 md:p-6 mb-8">

            <form method="GET" action="/transaksi">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">

                    {{-- TANGGAL --}}
                    <div class="md:col-span-2">

                        <label class="block text-xs font-black uppercase tracking-widest text-slate-400 mb-2">
                            Filter Tanggal
                        </label>

                        <input
                            type="date"
                            name="tanggal"
                            value="{{ request('tanggal') }}"
                            class="w-full border border-slate-200 rounded-xl px-4 py-3 bg-slate-50 text-slate-700 font-bold outline-none focus:ring-2 focus:ring-blue-100 focus:border-blue-500">

                    </div>

                    {{-- BUTTON --}}
                    <div class="flex gap-3">

                        <button
                            type="submit"
                            class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl font-bold transition shadow-sm">

                            Cari

                        </button>

                        <a
                            href="/transaksi"
                            class="bg-slate-200 hover:bg-slate-300 text-slate-700 px-5 py-3 rounded-xl font-bold transition shadow-sm text-center">

                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

        {{-- TOTAL --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-8">

            {{-- PEMASUKAN --}}
            <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-[2rem] p-6 text-white shadow-lg">

                <p class="uppercase text-xs tracking-widest opacity-80 font-black mb-2">
                    Pemasukan (Produk Laku)
                </p>

                <h2 class="text-2xl md:text-3xl font-black break-all">
                    Rp {{ number_format($pengeluaran, 0, ',', '.') }}
                </h2>

            </div>

            {{-- MODAL / PENGELUARAN (MODAL BELI) --}}
            <div class="bg-gradient-to-br from-red-500 to-red-600 rounded-[2rem] p-6 text-white shadow-lg">

                <p class="uppercase text-xs tracking-widest opacity-80 font-black mb-2">
                    Modal / Pengeluaran (Harga Beli)
                </p>

                <h2 class="text-2xl md:text-3xl font-black break-all">
                    Rp {{ number_format($pengeluaran, 0, ',', '.') }}
                </h2>

            </div>

        </div>

        {{-- MOBILE CARD --}}
        <div class="block lg:hidden space-y-4">

            @forelse ($transaksis as $transaksi)

                @php

                    $jumlahAsli = $transaksi->jumlah;

                    $jumlahCancel = $transaksi->cancel_jumlah ?? 0;

                    $jumlahFinal = $jumlahAsli - $jumlahCancel;

                    $hargaSatuan = $jumlahAsli > 0
                        ? $transaksi->total_harga / $jumlahAsli
                        : 0;

                    $totalHargaFinal = $hargaSatuan * $jumlahFinal;

                @endphp

                <div class="bg-white rounded-3xl border border-slate-200 shadow-sm p-5">

                    {{-- TOP --}}
                    <div class="flex items-start justify-between gap-3 mb-4">

                        <div>

                            <h2 class="font-black text-slate-800 text-base leading-tight">
                                {{ $transaksi->barang->nama }}
                            </h2>

                            <p class="text-xs text-slate-400 mt-1 break-all">
                                {{ $transaksi->barang->kode_barang }}
                            </p>

                        </div>

                        @if ($transaksi->jenis == 'masuk')

                            <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-xl whitespace-nowrap">
                                Masuk
                            </span>

                        @else

                            <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-xl whitespace-nowrap">
                                Keluar
                            </span>

                        @endif

                    </div>

                    {{-- INFO --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">

                        <div>

                            <p class="text-xs uppercase text-slate-400 font-bold mb-1">
                                Tanggal
                            </p>

                            <div class="font-bold text-slate-700 text-sm">
                                {{ $transaksi->created_at->format('d/m/Y') }}
                            </div>

                            <div class="text-xs text-slate-400">
                                {{ $transaksi->created_at->format('H:i') }} WIB
                            </div>

                        </div>

                        <div>

                            <p class="text-xs uppercase text-slate-400 font-bold mb-1">
                                Qty
                            </p>

                            <div class="font-black text-slate-800 text-lg">
                                {{ $jumlahFinal }}
                            </div>

                            @if($jumlahCancel > 0)

                                <div class="text-[11px] text-red-500">
                                    Cancel {{ $jumlahCancel }}
                                </div>

                            @endif

                        </div>

                    </div>

                    {{-- TOTAL --}}
                    <div class="mb-4">

                        <p class="text-xs uppercase text-slate-400 font-bold mb-1">
                            Total Harga
                        </p>

                        <div class="font-black text-slate-900 text-lg break-all">
                            Rp {{ number_format($totalHargaFinal, 0, ',', '.') }}
                        </div>

                        @if($jumlahCancel > 0)

                            <div class="text-[11px] text-slate-400 mt-1">
                                Sebelum:
                                Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                            </div>

                        @endif

                    </div>

                    {{-- STATUS --}}
                    <div class="mb-5">

                        @if($jumlahFinal <= 0)

                            <span class="bg-slate-200 text-slate-700 text-xs px-3 py-2 rounded-xl font-bold">
                                Full Cancel
                            </span>

                        @elseif($jumlahCancel > 0)

                            <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-2 rounded-xl font-bold">
                                Partial Cancel
                            </span>

                        @else

                            <span class="bg-green-100 text-green-700 text-xs px-3 py-2 rounded-xl font-bold">
                                Success
                            </span>

                        @endif

                    </div>

                    {{-- AKSI --}}
                    @if ($transaksi->jenis == 'keluar' && $jumlahFinal > 0)

                        <form
                            action="/transaksi/cancel/{{ $transaksi->id }}"
                            method="POST"
                            class="flex gap-2">

                            @csrf

                            <input
                                type="number"
                                name="jumlah_cancel"
                                min="1"
                                max="{{ $jumlahFinal }}"
                                placeholder="Qty"
                                required
                                class="flex-1 border border-slate-300 rounded-xl px-3 py-2 text-sm outline-none focus:ring-2 focus:ring-red-100">

                            <button
                                onclick="return confirm('Batalkan transaksi ini?')"
                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-xl text-sm font-bold transition">

                                Cancel

                            </button>

                        </form>

                    @endif

                </div>

            @empty

                <div class="bg-white rounded-3xl border border-slate-200 p-10 text-center">

                    <p class="text-slate-400 font-bold">
                        Tidak ada data transaksi
                    </p>

                </div>

            @endforelse

        </div>

        {{-- DESKTOP TABLE --}}
        <div class="hidden lg:block bg-white rounded-[2rem] border border-slate-200 shadow-xl overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead>

                        <tr class="bg-slate-900 text-white text-sm">

                            <th class="px-4 py-4 text-left font-bold">
                                Tanggal
                            </th>

                            <th class="px-4 py-4 text-left font-bold">
                                Barang
                            </th>

                            <th class="px-4 py-4 text-center font-bold">
                                Jenis
                            </th>

                            <th class="px-4 py-4 text-center font-bold">
                                Qty
                            </th>

                            <th class="px-4 py-4 text-right font-bold">
                                Total
                            </th>

                            <th class="px-4 py-4 text-center font-bold">
                                Status
                            </th>

                            <th class="px-4 py-4 text-center font-bold">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($transaksis as $transaksi)

                            @php

                                $jumlahAsli = $transaksi->jumlah;

                                $jumlahCancel = $transaksi->cancel_jumlah ?? 0;

                                $jumlahFinal = $jumlahAsli - $jumlahCancel;

                                $hargaSatuan = $jumlahAsli > 0
                                    ? $transaksi->total_harga / $jumlahAsli
                                    : 0;

                                $totalHargaFinal = $hargaSatuan * $jumlahFinal;

                            @endphp

                            <tr class="hover:bg-slate-50 transition">

                                {{-- TANGGAL --}}
                                <td class="px-4 py-4">

                                    <div class="font-bold text-slate-800 text-sm">
                                        {{ $transaksi->created_at->format('d/m/Y') }}
                                    </div>

                                    <div class="text-xs text-slate-400 mt-1">
                                        {{ $transaksi->created_at->format('H:i') }} WIB
                                    </div>

                                </td>

                                {{-- BARANG --}}
                                <td class="px-4 py-4">

                                    <div class="font-bold text-slate-800 text-sm md:text-base">
                                        {{ $transaksi->barang->nama }}
                                    </div>

                                    <div class="text-xs text-slate-400 mt-1">
                                        {{ $transaksi->barang->kode_barang }}
                                    </div>

                                </td>

                                {{-- JENIS --}}
                                <td class="px-4 py-4 text-center">

                                    @if ($transaksi->jenis == 'masuk')

                                        <span class="bg-green-100 text-green-700 text-xs font-bold px-3 py-1 rounded-lg">
                                            Masuk
                                        </span>

                                    @else

                                        <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-lg">
                                            Keluar
                                        </span>

                                    @endif

                                </td>

                                {{-- QTY --}}
                                <td class="px-4 py-4 text-center">

                                    <div class="font-black text-slate-800">
                                        {{ $jumlahFinal }}
                                    </div>

                                    @if($jumlahCancel > 0)

                                        <div class="text-[10px] text-red-500 mt-1">
                                            Cancel {{ $jumlahCancel }}
                                        </div>

                                    @endif

                                </td>

                                {{-- TOTAL --}}
                                <td class="px-4 py-4 text-right">

                                    <div class="font-black text-slate-900 text-sm md:text-base">
                                        Rp {{ number_format($totalHargaFinal, 0, ',', '.') }}
                                    </div>

                                    @if($jumlahCancel > 0)

                                        <div class="text-[10px] text-slate-400 mt-1">
                                            Sebelum:
                                            Rp {{ number_format($transaksi->total_harga, 0, ',', '.') }}
                                        </div>

                                    @endif

                                </td>

                                {{-- STATUS --}}
                                <td class="px-4 py-4 text-center">

                                    @if($jumlahFinal <= 0)

                                        <span class="bg-slate-200 text-slate-700 text-xs px-3 py-1 rounded-lg font-bold">
                                            Full Cancel
                                        </span>

                                    @elseif($jumlahCancel > 0)

                                        <span class="bg-yellow-100 text-yellow-700 text-xs px-3 py-1 rounded-lg font-bold">
                                            Partial
                                        </span>

                                    @else

                                        <span class="bg-green-100 text-green-700 text-xs px-3 py-1 rounded-lg font-bold">
                                            Success
                                        </span>

                                    @endif

                                </td>

                                {{-- AKSI --}}
                                <td class="px-4 py-4">

                                    @if ($transaksi->jenis == 'keluar' && $jumlahFinal > 0)

                                        <form
                                            action="/transaksi/cancel/{{ $transaksi->id }}"
                                            method="POST"
                                            class="flex items-center justify-center gap-2">

                                            @csrf

                                            <input
                                                type="number"
                                                name="jumlah_cancel"
                                                min="1"
                                                max="{{ $jumlahFinal }}"
                                                placeholder="Qty"
                                                required
                                                class="w-16 border border-slate-300 rounded-lg px-2 py-1 text-sm outline-none focus:ring-2 focus:ring-red-100">

                                            <button
                                                onclick="return confirm('Batalkan transaksi ini?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg text-xs font-bold transition">

                                                Cancel

                                            </button>

                                        </form>

                                    @else

                                        <div class="text-center text-slate-300 text-sm">
                                            -
                                        </div>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="7" class="py-20 text-center">

                                    <p class="text-slate-400 font-bold">
                                        Tidak ada data transaksi
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection