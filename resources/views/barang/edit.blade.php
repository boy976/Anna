@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 p-4 md:p-6">

    <div class="max-w-6xl mx-auto">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <div>

                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    Edit Barang
                </h1>

                <p class="text-gray-500 mt-1 text-sm md:text-base">
                    Update data barang dan stok gudang
                </p>

            </div>

            <a href="/stok-barang"
                class="w-full md:w-auto text-center bg-gray-700 hover:bg-gray-800 text-white px-5 py-3 rounded-2xl shadow transition">

                ← Kembali

            </a>

        </div>

        {{-- CONTENT --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- PREVIEW GAMBAR --}}
            <div class="bg-white rounded-3xl shadow-lg p-5 md:p-6">

                <div id="previewContainer"
                    class="w-full flex items-center justify-center min-h-[300px]">

                    @if ($barang->gambar)

                        <div class="w-full">

                            <img
                                src="{{ asset($barang->gambar) }}"
                                alt="{{ $barang->nama }}"
                                class="w-full h-[300px] md:h-[420px] object-cover rounded-2xl shadow">

                            <p class="text-center text-sm text-gray-500 mt-4 font-medium break-all">
                                Gambar saat ini
                            </p>

                        </div>

                    @else

                        <div class="w-full h-[300px] md:h-[420px] bg-gray-100 rounded-2xl flex items-center justify-center text-gray-400 text-center px-6">

                            Tidak Ada Gambar

                        </div>

                    @endif

                </div>

            </div>

            {{-- FORM --}}
            <div class="bg-white rounded-3xl shadow-lg p-5 md:p-6">

                <h2 class="text-lg md:text-xl font-bold mb-6 text-gray-700">
                    Form Edit Barang
                </h2>

                <form
                    method="POST"
                    action="/stok-barang/update/{{ $barang->id }}"
                    enctype="multipart/form-data"
                    class="space-y-4">

                    @csrf

                    {{-- NAMA --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Nama Barang
                        </label>

                        <input
                            name="nama"
                            value="{{ $barang->nama }}"
                            placeholder="Masukkan nama barang"
                            class="w-full border border-gray-300 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">

                    </div>

                    {{-- KODE --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Kode Barang
                        </label>

                        <input
                            name="kode_barang"
                            value="{{ $barang->kode_barang }}"
                            placeholder="Masukkan kode barang"
                            class="w-full border border-gray-300 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">

                    </div>

                    {{-- GRID --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- STOK --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-600 mb-2">
                                Stok Barang
                            </label>

                            <input
                                name="stok"
                                type="number"
                                value="{{ $barang->stok }}"
                                placeholder="0"
                                class="w-full border border-gray-300 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">

                        </div>

                        {{-- HARGA BELI --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-600 mb-2">
                                Harga Beli
                            </label>

                            <input
                                name="harga_beli"
                                type="number"
                                value="{{ $barang->harga_beli }}"
                                placeholder="0"
                                class="w-full border border-gray-300 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">

                        </div>

                    </div>

                    {{-- HARGA JUAL --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Harga Jual
                        </label>

                        <input
                            name="harga_jual"
                            type="number"
                            value="{{ $barang->harga_jual }}"
                            placeholder="0"
                            class="w-full border border-gray-300 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">

                    </div>

                    {{-- GAMBAR --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Ganti Gambar Barang
                        </label>

                        <input
                            type="file"
                            name="gambar"
                            id="gambarInput"
                            accept="image/*"
                            class="w-full border border-gray-300 rounded-xl p-3 bg-white text-sm">

                    </div>

                    {{-- BUTTON --}}
                    <div class="flex flex-col sm:flex-row gap-3 pt-2">

                        <button
                            type="submit"
                            class="w-full sm:w-auto bg-blue-500 hover:bg-blue-600 text-white px-6 py-3 rounded-xl shadow transition font-semibold">

                            Update

                        </button>

                        <a href="/stok-barang"
                            class="w-full sm:w-auto text-center bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-3 rounded-xl transition font-semibold">

                            Batal

                        </a>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

{{-- PREVIEW IMAGE --}}
<script>

    const gambarInput = document.getElementById('gambarInput');
    const previewContainer = document.getElementById('previewContainer');

    gambarInput.addEventListener('change', function(e) {

        const file = e.target.files[0];

        if (file) {

            const reader = new FileReader();

            reader.onload = function(event) {

                previewContainer.innerHTML = `
                    <div class="w-full">
                        <img
                            src="${event.target.result}"
                            class="w-full h-[300px] md:h-[420px] object-cover rounded-2xl shadow">

                        <p class="mt-4 text-sm text-gray-500 font-medium text-center break-all">
                            Preview gambar baru
                        </p>
                    </div>
                `;
            }

            reader.readAsDataURL(file);
        }

    });

</script>

@endsection