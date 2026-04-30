{{-- resources/views/recrutements/show.blade.php --}}
@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- En-tête avec navigation -->
        <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
            <div class="flex items-center gap-4">
                <a href="{{ route('recrutement.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                    <iconify-icon icon="solar:arrow-left-linear" class="text-2xl"></iconify-icon>
                </a>
                <div>
                    <h1 id="recrutementTitle" class="text-2xl font-bold text-gray-900">{{$recrutement->title}}</h1>
                    <div class="flex flex-wrap gap-2 mt-1">
                        <span id="recrutementStatus"
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"></span>
                        <span id="recrutementDept" class="text-xs text-gray-500"></span>
                        <span id="recrutementLocation" class="text-xs text-gray-500"></span>
                    </div>
                </div>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('recrutement.edit', $recrutement->id) }}"
                                            class="text-blue-600 hover:bg-blue-50 p-1.5 rounded">
                                            <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                                            Modifier
                                        </a>
                                        <form action="{{ route('recrutement.destroy', $recrutement->id) }}" method="POST" class="inline-block" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet employé ? Cette action est irréversible.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded transition-colors" title="Supprimer">
                                                <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                                Supprimer
                                            </button>
                                        </form>
            </div>
        </div>

        <!-- Grille infos + liste candidatures -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Colonne gauche : Infos du recrutement -->
            <div class="lg:col-span-1 space-y-6">
                <!-- Dates -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <iconify-icon icon="solar:calendar-linear" class="text-blue-500 text-lg"></iconify-icon>
                        Informations
                    </h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between pb-2 border-b border-gray-100">
                            <span class="text-gray-500">Date de création</span>
                            <span class="font-medium text-gray-900" id="recrutementCreated">{{$recrutement->created_at}}</span>
                        </div>
                        <div class="flex justify-between pb-2 border-b border-gray-100">
                            <span class="text-gray-500">Date limite</span>
                            <span class="font-medium text-gray-900" id="recrutementDeadline">{{$recrutement->deadline}}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Candidatures reçues</span>
                            <span class="font-medium text-blue-600" id="recrutementCandidatures">{{$totalCandidatures}}</span>
                        </div>
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <iconify-icon icon="solar:clipboard-text-linear" class="text-blue-500 text-lg"></iconify-icon>
                        Description du poste
                    </h3>
                    <p id="recrutementDesc" class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{$recrutement->description}}</p>
                </div>

                <!-- Prérequis -->
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
                    <h3 class="font-semibold text-gray-800 mb-3 flex items-center gap-2">
                        <iconify-icon icon="solar:checklist-linear" class="text-blue-500 text-lg"></iconify-icon>
                        Prérequis & compétences
                    </h3>
                    <p id="recrutementRequirements" class="text-gray-600 text-sm leading-relaxed whitespace-pre-line">{{$recrutement->requirements}}</p>
                </div>
            </div>

            <!-- Colonne droite : Liste des candidatures -->
            <div class="lg:col-span-2">
                <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
                    <div class="px-5 py-4 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                        <div>
                            <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                                <iconify-icon icon="solar:users-group-rounded-linear"
                                    class="text-blue-500 text-lg"></iconify-icon>
                                Candidatures reçues
                            </h3>
                            <p class="text-xs text-gray-400">{{$totalCandidatures}} Candidatures</p>
                        </div>
                        <button id="openCandidatureModal"
                            class="inline-flex items-center gap-2 px-3 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm transition">
                            <iconify-icon icon="solar:add-circle-linear" class="text-base"></iconify-icon>
                            Ajouter
                        </button>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-xs text-gray-500 border-b">
                                <tr>
                                    <th class="px-5 py-3">Candidat</th>
                                    <th class="px-5 py-3">Contact</th>
                                    <th class="px-5 py-3">Statut</th>
                                    <th class="px-5 py-3">Date</th>
                                    <th class="px-5 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody style="text-align: center">
                                @foreach ($candidatures as $candidature)
                                    <tr>
                                        <td>{{ $candidature->name }}</td>
                                        <td>{{ $candidature->phone }}</td>
                                        <td>{{ $candidature->status }}</td>
                                        <td>{{ $candidature->created_at }}</td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('candidatures.show', $candidature->id) }}"
                                                class="text-green-600 hover:bg-green-50 p-1.5 rounded"
                                                title="Voir détails">
                                                    <iconify-icon icon="solar:eye-linear" class="text-base"></iconify-icon>
                                                </a>
                                                <form action="{{ route('candidatures.destroy', $candidature->id) }}" method="POST" class="inline-block" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet employé ? Cette action est irréversible.')">
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
                    <div id="emptyCandidatures" class="text-center py-12 hidden">
                        <iconify-icon icon="solar:users-group-rounded-linear"
                            class="text-4xl text-gray-300 mx-auto mb-2"></iconify-icon>
                        <p class="text-gray-400 text-sm">Aucune candidature pour ce poste</p>
                        <p class="text-gray-300 text-xs mt-1">Cliquez sur "Ajouter" pour enregistrer une candidature</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL Ajouter/Modifier Candidature -->
    <div id="candidatureModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Ajouter une candidature</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="candidatureName" class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                        placeholder="Ex: Jean Koffi">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="candidatureEmail" class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                            placeholder="candidat@email.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" id="candidaturePhone" class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                            placeholder="+225 XX XX XX XX">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">CV (lien ou commentaire)</label>
                    <textarea id="candidatureCv" rows="2"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                        placeholder="Lien Google Drive, Dropbox ou commentaire sur le CV..."></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select id="candidatureStatus" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                        <option value="nouvelle">🆕 Nouvelle</option>
                        <option value="cvee">📄 CV étudié</option>
                        <option value="entretien">📅 Entretien programmé</option>
                        <option value="test">✍️ Test technique</option>
                        <option value="retenu">🏆 Retenu</option>
                        <option value="refuse">❌ Refusé</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                <button id="cancelModalBtn"
                    class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                <button id="saveCandidatureBtn"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700">Enregistrer</button>
            </div>
        </div>
    </div>

@endsection