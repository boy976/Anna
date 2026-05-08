@extends('layouts.app')

@section('content')

<div class="mb-8">

    <h1 class="text-4xl font-bold text-gray-800">
        Dashboard
    </h1>

    <p class="text-gray-500 mt-2">
        Monitoring stok dan statistik produk toko
    </p>

</div>

<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-8">

    <div class="bg-blue-500 text-white p-6 rounded-3xl shadow-lg">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-sm opacity-80">
                    Total Produk
                </p>

                <h2 class="text-4xl font-bold mt-3">
                    {{ $barangs->count() }}
                </h2>

            </div>

            <div class="bg-white/20 p-4 rounded-2xl">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M20 13V7a2 2 0 00-2-2h-3V3H9v2H6a2 2 0 00-2 2v6m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0H4"/>

                </svg>

            </div>

        </div>

    </div>

    <div class="bg-green-500 text-white p-6 rounded-3xl shadow-lg">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-sm opacity-80">
                    Stok Ready
                </p>

                <h2 class="text-4xl font-bold mt-3">
                    {{ $barangs->where('stok','>',0)->count() }}
                </h2>

            </div>

            <div class="bg-white/20 p-4 rounded-2xl">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"/>

                </svg>

            </div>

        </div>

    </div>

    <div class="bg-yellow-500 text-white p-6 rounded-3xl shadow-lg">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-sm opacity-80">
                    Total Stok
                </p>

                <h2 class="text-4xl font-bold mt-3">
                    {{ $barangs->sum('stok') }}
                </h2>

            </div>

            <div class="bg-white/20 p-4 rounded-2xl">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M3 3h2l.4 2M7 13h10l4-8H5.4"/>

                </svg>

            </div>

        </div>

    </div>

    <div class="bg-red-500 text-white p-6 rounded-3xl shadow-lg">

        <div class="flex justify-between items-center">

            <div>

                <p class="text-sm opacity-80">
                    Stok Kosong
                </p>

                <h2 class="text-4xl font-bold mt-3">
                    {{ $barangs->where('stok',0)->count() }}
                </h2>

            </div>

            <div class="bg-white/20 p-4 rounded-2xl">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-8 h-8 text-white"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01M10.29 3.86l-7.1 12.3A1 1 0 004.05 18h15.9a1 1 0 00.86-1.5l-7.1-12.3a1 1 0 00-1.72 0z"/>

                </svg>

            </div>

        </div>

    </div>

</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">

    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6">

        <div class="flex items-center justify-between mb-5">

            <div>

                <h2 class="text-xl font-bold text-gray-800">
                    Diagram Stok Barang
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Statistik stok produk
                </p>

            </div>

            <div class="bg-blue-100 p-3 rounded-2xl">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-blue-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 3v18m4-12v12m4-6v6M7 8v13"/>

                </svg>

            </div>

        </div>

        <div class="relative h-72">
            <canvas id="stokChart"></canvas>
        </div>

    </div>

    <div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6">

        <div class="flex items-center justify-between mb-5">

            <div>

                <h2 class="text-xl font-bold text-gray-800">
                    Status Produk
                </h2>

                <p class="text-sm text-gray-500 mt-1">
                    Ready dan kosong
                </p>

            </div>

            <div class="bg-green-100 p-3 rounded-2xl">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-green-500"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M11 11V3m0 8c0 4.418 3.582 8 8 8"/>

                </svg>

            </div>

        </div>

        <div class="relative h-72">
            <canvas id="statusChart"></canvas>
        </div>

    </div>

</div>

<div class="bg-white border border-gray-200 rounded-3xl shadow-sm p-6">

    <div class="flex items-center justify-between mb-5">

        <div>

            <h2 class="text-xl font-bold text-gray-800">
                Produk Stok Terbanyak
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Produk dengan stok tertinggi
            </p>

        </div>

        <div class="bg-yellow-100 p-3 rounded-2xl">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="w-6 h-6 text-yellow-500"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor">

                <path stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M5 3h14v4a7 7 0 01-14 0V3z"/>

            </svg>

        </div>

    </div>

    <div class="relative h-80">
        <canvas id="topChart"></canvas>
    </div>

</div>

<script>

const stokCtx = document.getElementById('stokChart');

new Chart(stokCtx, {
    type: 'bar',
    data: {
        labels: [
            @foreach($barangs as $b)
                "{{ $b->nama }}",
            @endforeach
        ],
        datasets: [{
            label: 'Jumlah Stok',
            data: [
                @foreach($barangs as $b)
                    {{ $b->stok }},
                @endforeach
            ],
            backgroundColor: '#3b82f6',
            borderRadius: 8
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            }
        }
    }
});

const statusCtx = document.getElementById('statusChart');

new Chart(statusCtx, {
    type: 'doughnut',
    data: {
        labels: ['Ready', 'Kosong'],
        datasets: [{
            data: [
                {{ $barangs->where('stok','>',0)->count() }},
                {{ $barangs->where('stok',0)->count() }}
            ],
            backgroundColor: [
                '#22c55e',
                '#ef4444'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

const topCtx = document.getElementById('topChart');

new Chart(topCtx, {
    type: 'line',
    data: {
        labels: [
            @foreach($barangs->sortByDesc('stok')->take(5) as $b)
                "{{ $b->nama }}",
            @endforeach
        ],
        datasets: [{
            label: 'Top Stok',
            data: [
                @foreach($barangs->sortByDesc('stok')->take(5) as $b)
                    {{ $b->stok }},
                @endforeach
            ],
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.1)',
            fill: true,
            tension: 0.4
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});

</script>

@endsection