@extends('layouts.app')

@section('title', 'Services IT - AFRO\'PLUME')
@section('header-title', 'Services & Infrastructures')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Liste des utlisateurs</h2>
            <p class="text-sm text-gray-500 mt-0.5">Gérez vos utlisateurs</p>
        </div>
        <a href="{{ route('users.creatusers') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all shadow-sm">
                <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                Ajouter un utilisateur
            </a>
    </div>

    <!-- Datatable -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Id</th>
                        <th class="px-6 py-4">Nom</th>
                        <th class="px-6 py-4">Prenom</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4">Profil</th>
                        <th class="px-6 py-4">Département</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="servicesTableBody" class="divide-y divide-gray-100 text-sm">
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->lastname }}</td>
                        <td>{{ $user->firstname }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->status }}</td>
                        <td>{{ $user->profil }}</td>
                        <td>{{ $user->departements->first()->title ?? 'Aucun' }}</td>
                        <td>
                            <div class="flex items-center justify-center gap-2">
                            <!-- Modifier -->
                            <a href="{{ route('users.edit', $user->id) }}"><iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon></a>

                            <!-- Supprimer -->
                            <form action="{{ route('users.delete', $user->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet élément ?')">
                                                    <iconify-icon icon="solar:trash-bin-minimalistic-linear"
                                                        class="text-base"></iconify-icon>
                                                </button>
                            </form>
                    <a href="{{ route('affectations.create', $user->id) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all shadow-sm">
                    <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                        Attribuer un département
                    </a>                            
                </div>
                        </td>

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="emptyServices" class="text-center py-12 hidden">
            <iconify-icon icon="solar:server-square-linear" class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
            <p class="text-gray-400">Aucun utilisateur</p>
        </div>
    </div>
</div>

    
@endsection

@push('styles')
<style>
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }
</style>
@endpush
