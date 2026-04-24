<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AFRO'PLUME - @yield('title', 'Dashboard')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.iconify.design/iconify-icon/1.0.7/iconify-icon.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        .fade-in { animation: fadeIn 0.3s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
    </style>
    @stack('styles')
</head>
<body class="flex h-screen bg-gray-50 antialiased overflow-hidden text-sm">

    <!-- Mobile Overlay -->
    <div class="fixed inset-0 bg-slate-900/50 z-40 hidden md:hidden" id="mobile-overlay"></div>

    <!-- Sidebar -->
    @include('layouts.sidebar')

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden w-full">
        @include('layouts.header')

        <main class="flex-1 overflow-y-auto p-4 md:p-6 no-scrollbar">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

    <script>
        document.getElementById('mobile-menu-btn')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('-translate-x-full');
            document.getElementById('mobile-overlay').classList.toggle('hidden');
        });
        document.getElementById('mobile-overlay')?.addEventListener('click', () => {
            document.getElementById('sidebar').classList.add('-translate-x-full');
            document.getElementById('mobile-overlay').classList.add('hidden');
        });
    </script>
    @stack('scripts')
</body>
</html>
