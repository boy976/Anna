@extends('layouts.app')

@section('content')

<div class="min-h-screen bg-gray-100 p-4 md:p-6">

    <div class="max-w-6xl mx-auto">

        {{-- HEADER --}}
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-6">

            <div>

                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    Tambah Stok Barang
                </h1>

                <p class="text-gray-500 mt-1 text-sm md:text-base">
                    Tambahkan data barang baru ke gudang
                </p>

            </div>

            <a href="/stok-barang"
                class="w-full md:w-auto text-center bg-gray-700 hover:bg-gray-800 text-white px-5 py-3 rounded-2xl shadow transition">

                ← Kembali

            </a>

        </div>

        {{-- CONTENT --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            {{-- PREVIEW --}}
            <div class="bg-white rounded-3xl shadow-lg p-6 flex items-center justify-center min-h-[300px]">

                <div id="previewContainer"
                    class="text-center text-gray-400 w-full">

                    <div class="text-6xl mb-3">
                        📦
                    </div>

                    <p class="text-sm md:text-base">
                        Preview gambar akan muncul setelah upload
                    </p>

                </div>

            </div>

            {{-- FORM --}}
            <div class="bg-white rounded-3xl shadow-lg p-5 md:p-6">

                <h2 class="text-lg md:text-xl font-bold mb-5 text-gray-700">
                    Form Tambah Stok Barang
                </h2>

                <form method="POST"
                    action="/stok-barang"
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
                            placeholder="Masukkan kode barang"
                            class="w-full border border-gray-300 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">

                    </div>

                    {{-- GRID --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                        {{-- STOK --}}
                        <div>

                            <label class="block text-sm font-semibold text-gray-600 mb-2">
                                Stok
                            </label>

                            <input
                                name="stok"
                                type="number"
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
                            placeholder="0"
                            class="w-full border border-gray-300 rounded-xl p-3 outline-none focus:ring-2 focus:ring-blue-200 focus:border-blue-500">

                    </div>

                    {{-- GAMBAR --}}
                    <div>

                        <label class="block text-sm font-semibold text-gray-600 mb-2">
                            Upload Gambar
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

                            Simpan

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
                    <img
                        src="${event.target.result}"
                        class="w-full max-h-[400px] object-contain rounded-2xl shadow-md">

                    <p class="mt-4 text-sm text-gray-500 font-medium break-all">
                        ${file.name}
                    </p>
                `;
            }

            reader.readAsDataURL(file);
        }
    });

</script>

@endsection