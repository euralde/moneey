{{-- resources/views/recrutements/index.blade.php --}}
@extends('layouts.app') {{-- Adaptez selon le nom de votre layout --}}

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-xl border p-4 text-center">
                <p class="text-xs text-gray-500">Total offres</p>
                <p class="text-2xl font-bold text-gray-900" id="totalOffres">{{ $totalOffres }}</p>
            </div>
            <div class="bg-blue-50 rounded-xl border border-blue-100 p-4 text-center">
                <p class="text-xs text-blue-600">Ouvertes</p>
                <p class="text-2xl font-bold text-blue-700" id="totalOuvertes">{{ $totalOuvertes }}</p>
            </div>
            <div class="bg-amber-50 rounded-xl border border-amber-100 p-4 text-center">
                <p class="text-xs text-amber-600">En cours</p>
                <p class="text-2xl font-bold text-amber-700" id="totalEnCours">{{ $totalencours }}</p>
            </div>
            <div class="bg-emerald-50 rounded-xl border border-emerald-100 p-4 text-center">
                <p class="text-xs text-emerald-600">Pourvues</p>
                <p class="text-2xl font-bold text-emerald-700" id="totalPourvues">{{ $totalpourvue }}</p>
            </div>
            <div class="bg-purple-50 rounded-xl border border-purple-100 p-4 text-center">
                <p class="text-xs text-purple-600">Candidatures</p>
                <p class="text-2xl font-bold text-purple-700" id="totalCandidatures"></p>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex gap-3">
                <select id="statusFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="all">Tous les statuts</option>
                    <option value="ouverte">🟢 Ouverte</option>
                    <option value="encours">🟡 En cours</option>
                    <option value="pourvue">🔵 Pourvue</option>
                    <option value="fermee">⚫ Fermée</option>
                </select>
                <input type="text" id="searchRecrutement" placeholder="Rechercher..."
                    class="px-3 py-2 border border-gray-200 rounded-lg text-sm w-48">
                <button id="resetFilters"
                    class="px-3 py-2 text-gray-500 hover:text-gray-700 border border-gray-200 rounded-lg">
                    <iconify-icon icon="solar:refresh-linear" class="text-base"></iconify-icon>
                </button>
            </div>
            <a href="{{ route('recrutement.create') }}"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm">
                <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                Nouveau recrutement
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded-lg mb-4">
                {{ session('success') }}
            </div>
        @endif
        
        <!-- Datatable -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Poste</th>
                            <th class="px-6 py-4">Département</th>
                            <th class="px-6 py-4">Localisation</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Date limite</th>
                            <th class="px-6 py-4">Candidatures</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        @foreach ($recrutements as $recrutement)
                            <tr>
                                <td>{{ $recrutement->title }}</td>
                                <td>{{ $recrutement->departement->name }}</td>
                                <td>{{ $recrutement->location }}</td>
                                <td>{{ $recrutement->status }}</td>
                                <td>{{ $recrutement->deadline }}</td>
                                <td>
                                    @forelse($recrutement->candidatures as $candidature)
                                        <div>{{ $candidature->count() }}</div>
                                    @empty
                                        <span>Aucune candidature</span>
                                    @endforelse
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('recrutement.show', $recrutement->id) }}"
                                        class="text-green-600 hover:bg-green-50 p-1.5 rounded"
                                        title="Voir détails">
                                            <iconify-icon icon="solar:eye-linear" class="text-base"></iconify-icon>
                                        </a>
                                        <a href="{{ route('recrutement.edit', $recrutement->id) }}"
                                            class="text-blue-600 hover:bg-blue-50 p-1.5 rounded">
                                            <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                                        </a>
                                        <form action="{{ route('recrutement.destroy', $recrutement->id) }}" method="POST" class="inline-block" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet employé ? Cette action est irréversible.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded transition-colors" title="Supprimer">
                                                <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div id="emptyRecrutements" class="text-center py-12 hidden">
                <iconify-icon icon="solar:users-group-rounded-linear"
                    class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
                <p class="text-gray-400">Aucun recrutement en cours</p>
                <p class="text-gray-300 text-xs mt-1">Cliquez sur "Nouveau recrutement" pour commencer</p>
            </div>
        </div>
    </div>
@endsection