<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="utf-8" />

    <meta name="viewport"
        content="width=device-width, initial-scale=1" />

    <title>
        @yield('title', 'Anna Store')
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-100 min-h-screen overflow-x-hidden">

    {{-- MOBILE TOPBAR --}}
    <div class="lg:hidden fixed top-0 left-0 right-0 z-50 bg-white border-b shadow-sm">

        <div class="flex items-center justify-between px-4 py-3">

            <h1 class="text-lg font-bold text-gray-800">
                Anna Store
            </h1>

            <button
                id="menuButton"
                class="bg-gray-100 hover:bg-gray-200 p-2 rounded-xl transition">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-6 h-6 text-gray-700"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor">

                    <path stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />

                </svg>

            </button>

        </div>

    </div>

    {{-- OVERLAY --}}
    <div
        id="overlay"
        class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden">
    </div>

    {{-- SIDEBAR --}}
    <div
        id="sidebar"
        class="fixed top-0 left-0 z-50 h-full w-72 bg-white shadow-2xl transform -translate-x-full lg:translate-x-0 transition-transform duration-300">

        @include('partials.sidebar')

    </div>

    {{-- CONTENT --}}
    <main class="flex-1 lg:ml-64 pt-20 lg:pt-0">

        <div class="p-4 md:p-6 lg:p-8">

            @yield('content')

        </div>

    </main>

    {{-- SCRIPT --}}
    <script>

        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        const menuButton = document.getElementById('menuButton');

        menuButton.addEventListener('click', () => {

            sidebar.classList.toggle('-translate-x-full');

            overlay.classList.toggle('hidden');

        });

        overlay.addEventListener('click', () => {

            sidebar.classList.add('-translate-x-full');

            overlay.classList.add('hidden');

        });

    </script>

</body>

</html>