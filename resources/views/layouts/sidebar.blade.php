<aside
    class="fixed md:static inset-y-0 left-0 w-[260px] bg-slate-900 text-slate-300 flex flex-col z-50 transform -translate-x-full md:translate-x-0 transition-transform duration-200 flex-shrink-0"
    id="sidebar">
    <div class="flex flex-col justify-center h-20 px-6 border-b border-slate-800">
        <span class="text-xl font-semibold tracking-tighter text-white">AFRO'PLUME</span>
        <span class="text-xs text-slate-400 font-medium mt-0.5">Gestion intelligente</span>
    </div>
    <nav class="flex-1 overflow-y-auto py-6 space-y-1">
        <a href="{{ route('dashboard') }}"
            class="flex items-center px-6 py-2.5 {{ request()->routeIs('dashboard') ? 'text-white bg-slate-800 border-l-4 border-blue-500' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
            <iconify-icon icon="solar:widget-2-linear"
                class="text-lg mr-3 {{ request()->routeIs('dashboard') ? 'text-blue-400' : '' }}"></iconify-icon>
            <span class="font-medium">Dashboard</span>
        </a>
        <a href="#" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:pie-chart-2-linear" class="text-lg mr-3"></iconify-icon>
            <span>Finance</span>
        </a>
        <a href="#" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:calendar-mark-linear" class="text-lg mr-3"></iconify-icon>
            <span>Tâches</span>
        </a>
        <a href="#" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:users-group-rounded-linear" class="text-lg mr-3"></iconify-icon>
            <span>RH</span>
        </a>
        <a href="#" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:chat-round-dots-linear" class="text-lg mr-3"></iconify-icon>
            <span>Collaboration</span>
        </a>
<<<<<<< HEAD
=======
<<<<<<< HEAD

        <a href="{{ route('users') }}" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:server-square-linear" class="text-lg mr-3"></iconify-icon>
            <span>Utilisateur</span>

>>>>>>> a1121a1b8bf15094920d9f2f50d0f10ae0acc9fc
        <a href="/departements" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:server-square-linear" class="text-lg mr-3"></iconify-icon>
            <span>Départements</span>
        </a>
        <a href="#" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:document-text-linear" class="text-lg mr-3"></iconify-icon>
            <span>Notes</span>
        </a>
=======
        <a href="{{ route('users') }}"
            class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:server-square-linear" class="text-lg mr-3"></iconify-icon>
            <span>Utilisateur</span>
            <a href="/departements"
                class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
                <iconify-icon icon="solar:server-square-linear" class="text-lg mr-3"></iconify-icon>
                <span>Départements</span>
            </a>
            <a href="#" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
                <iconify-icon icon="solar:document-text-linear" class="text-lg mr-3"></iconify-icon>
                <span>Notes</span>
            </a>
>>>>>>> 98b626781035dad868eeabc0176e2fbc2846024a
    </nav>
    <div class="p-4 border-t border-slate-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <iconify-icon icon="solar:logout-2-linear" class="text-lg mr-3"></iconify-icon>
            <button type="submit"
                class="flex items-center px-2 py-2 hover:bg-rose-500/10 hover:text-rose-400 text-slate-400">Se
                déconnecter</button>
        </form>
    </div>
</aside>