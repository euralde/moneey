{{-- resources/views/recrutements/index.blade.php --}}
@extends('layouts.app') {{-- Adaptez selon le nom de votre layout --}}

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-xl border p-4 text-center">
                <p class="text-xs text-gray-500">Total offres</p>
                <p class="text-2xl font-bold text-gray-900" id="totalOffres">0</p>
            </div>
            <div class="bg-blue-50 rounded-xl border border-blue-100 p-4 text-center">
                <p class="text-xs text-blue-600">Ouvertes</p>
                <p class="text-2xl font-bold text-blue-700" id="totalOuvertes">0</p>
            </div>
            <div class="bg-amber-50 rounded-xl border border-amber-100 p-4 text-center">
                <p class="text-xs text-amber-600">En cours</p>
                <p class="text-2xl font-bold text-amber-700" id="totalEnCours">0</p>
            </div>
            <div class="bg-emerald-50 rounded-xl border border-emerald-100 p-4 text-center">
                <p class="text-xs text-emerald-600">Pourvues</p>
                <p class="text-2xl font-bold text-emerald-700" id="totalPourvues">0</p>
            </div>
            <div class="bg-purple-50 rounded-xl border border-purple-100 p-4 text-center">
                <p class="text-xs text-purple-600">Candidatures</p>
                <p class="text-2xl font-bold text-purple-700" id="totalCandidatures">0</p>
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
                    <tbody id="recrutementsTableBody"></tbody>
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

    <!-- MODAL Recrutement -->
    <div id="recrutementModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Nouveau recrutement</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Intitulé du poste <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="recrutementTitle"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Ex: Développeur Full Stack">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                        <select id="recrutementDept" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                            <option value="IT">IT / Développement</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Commercial">Commercial</option>
                            <option value="RH">Ressources Humaines</option>
                            <option value="Finance">Finance</option>
                            <option value="Logistique">Logistique</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                        <input type="text" id="recrutementLocation"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg" placeholder="Abidjan, Paris, Remote">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date limite</label>
                        <input type="date" id="recrutementDeadline"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="recrutementStatus" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                            <option value="ouverte">🟢 Ouverte</option>
                            <option value="encours">🟡 En cours</option>
                            <option value="pourvue">🔵 Pourvue</option>
                            <option value="fermee">⚫ Fermée</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description du poste</label>
                    <textarea id="recrutementDesc" rows="3"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                        placeholder="Missions, compétences requises, expérience..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prérequis</label>
                    <textarea id="recrutementRequirements" rows="2"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                        placeholder="- Bac+5 en informatique&#10;- 3 ans d'expérience minimum&#10;- Maîtrise de React et Node.js"></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">
                <button id="cancelModalBtn"
                    class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                <button id="saveRecrutementBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
            </div>
        </div>
    </div>
@endsection