@php
    $profil = auth()->user()->profil;
@endphp
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
<<<<<<< HEAD
        @if(auth()->user()->profil === 'gerant')
        <a href="{{ route('employes.index') }}"
            class="flex items-center px-6 py-2.5 {{ request()->routeIs('employes.index') ? 'text-white bg-slate-800 border-l-4 border-blue-500' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
            <iconify-icon icon="solar:users-group-two-rounded-linear" class="text-lg mr-3"></iconify-icon>
            <span>Utilisateur</span>
        </a>
        

        <a href="{{ route('departements.index') }}"
            class="flex items-center px-6 py-2.5 {{ request()->routeIs('departements.index') ? 'text-white bg-slate-800 border-l-4 border-blue-500' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
            <iconify-icon icon="solar:buildings-2-linear" class="text-lg mr-3"></iconify-icon>
            <span>Départements</span>
        </a>
        @endif

        <a href="{{ route('notes.index') }}"
            class="flex items-center px-6 py-2.5 {{ request()->routeIs('notes.index') ? 'text-white bg-slate-800 border-l-4 border-blue-500' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
            <iconify-icon icon="solar:notes-linear" class="text-lg mr-3"></iconify-icon>
            <span>Notes</span>
        </a>
        @if(in_array($profil, ['gerant', 'manager']))
        <a href="{{ route('transactions.index') }}"
            class="flex items-center px-6 py-2.5 {{ request()->routeIs('transactions.index') ? 'text-white bg-slate-800 border-l-4 border-blue-500' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
            <iconify-icon icon="solar:wallet-money-linear" class="text-lg mr-3"></iconify-icon>
            <span>Finances</span>
        </a>
        @endif

        <a href="{{ route('lead.index') }}"
            class="flex items-center px-6 py-2.5 {{ request()->routeIs('lead.index') ? 'text-white bg-slate-800 border-l-4 border-blue-500' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
            <iconify-icon icon="solar:chart-square-linear" class="text-lg mr-3"></iconify-icon>
            <span>CRM</span>
        </a>

        @if(in_array($profil, ['gerant', 'manager']))
        <a href="{{ route('recrutement.index') }}"
            class="flex items-center px-6 py-2.5 {{ request()->routeIs('recrutement.index') ? 'text-white bg-slate-800 border-l-4 border-blue-500' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
            <iconify-icon icon="solar:users-group-rounded-linear" class="text-lg mr-3"></iconify-icon>
            <span>Recrutements</span>
        </a>
        @endif

        <a href="{{ route('tasks.index') }}"
            class="flex items-center px-6 py-2.5 {{ request()->routeIs('tasks.index') ? 'text-white bg-slate-800 border-l-4 border-blue-500' : 'hover:bg-slate-800 hover:text-white text-slate-300' }}">
            <iconify-icon icon="solar:checklist-minimalistic-linear"
                class="text-lg mr-3 {{ request()->routeIs('tasks.index') ? 'text-blue-400' : '' }}"></iconify-icon>
=======

        <a href="{{ route('tasks.index') }}" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:calendar-mark-linear" class="text-lg mr-3"></iconify-icon>
>>>>>>> 888f35c6a086e016f5655b318bfc166c7efb95ac
            <span>Tâches</span>
        </a>

        <a href="{{ route('messages.index') }}" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:chat-round-dots-linear" class="text-lg mr-3"></iconify-icon>
            <span>Messages</span>
        </a>

        <a href="{{ route('finances.index') }}" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:wallet-money-linear" class="text-lg mr-3"></iconify-icon>
            <span>Finances</span>
        </a>

        <a href="#" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:users-group-rounded-linear" class="text-lg mr-3"></iconify-icon>
            <span>RH</span>
        </a>

        <a href="#" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:chat-round-dots-linear" class="text-lg mr-3"></iconify-icon>
            <span>Collaboration</span>
        </a>


        <a href="{{ route('users.index') }}" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:server-square-linear" class="text-lg mr-3"></iconify-icon>
            <span>Utilisateur</span>
        </a>

        <a href="/departements" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:server-square-linear" class="text-lg mr-3"></iconify-icon>
            <span>Départements</span>
        </a>

        <a href="#" class="flex items-center px-6 py-2.5 hover:bg-slate-800 hover:text-white text-slate-300">
            <iconify-icon icon="solar:document-text-linear" class="text-lg mr-3"></iconify-icon>
            <span>Notes</span>
        </a>
    </nav>

    <div class="p-4 border-t border-slate-800">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center px-2 py-2 hover:bg-rose-500/10 hover:text-rose-400 text-slate-400">
                <iconify-icon icon="solar:logout-2-linear" class="text-lg mr-3"></iconify-icon>
                Se déconnecter
            </button>
        </form>
    </div>
</aside>