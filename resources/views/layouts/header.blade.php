<header class="h-16 bg-white border-b border-gray-200 flex items-center justify-between px-4 md:px-6 z-10 flex-shrink-0">
    <div class="flex items-center">
        <button class="md:hidden mr-4 text-gray-500" id="mobile-menu-btn">
            <iconify-icon icon="solar:hamburger-menu-linear" class="text-2xl"></iconify-icon>
        </button>
        <h1 class="text-lg font-semibold text-gray-900 hidden sm:block">@yield('header-title', 'Tableau de bord')</h1>
    </div>
    <div class="flex items-center space-x-4">
        <button class="text-gray-400">
            <iconify-icon icon="solar:bell-linear" class="text-xl"></iconify-icon>
        </button>
        <div class="flex items-center space-x-3 pl-4 border-l border-gray-200">
            <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center text-xs border">
                {{ auth()->user()?->initials ?? '??' }}
            </div>
            <span class="font-medium text-gray-700 hidden sm:block">{{ auth()->user()->firstname ." ". auth()->user()->lastname?? 'Non defini' }}</span>
        </div>
        <div class="flex items-center space-x-3 pl-4 border-l border-gray-200">
            <span class="font-medium text-white bg-red-600 border border-red-300 px-2 py-1 rounded-full text-xs">
                {{ ucfirst(auth()->user()->profil?? '??') }}
            </span>
        </div>
    </div>
</header>
