@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-5 gap-4 mb-6">
            <div class="bg-white rounded-xl border p-4 text-center">
                <p class="text-xs text-gray-500">Total employés</p>
                <p class="text-2xl font-bold text-gray-900" id="totalEmployes">{{ $totalEmployes }}</p>
            </div>
            <div class="bg-emerald-50 rounded-xl border border-emerald-100 p-4 text-center">
                <p class="text-xs text-emerald-600">🟢 Actifs</p>
                <p class="text-2xl font-bold text-emerald-700" id="totalActifs">{{ $totalActifs }}</p>
            </div>
            <div class="bg-amber-50 rounded-xl border border-amber-100 p-4 text-center">
                <p class="text-xs text-amber-600">🟡 En congé</p>
                <p class="text-2xl font-bold text-amber-700" id="totalConge">{{ $totalConge }}</p>
            </div>
            <div class="bg-blue-50 rounded-xl border border-blue-100 p-4 text-center">
                <p class="text-xs text-blue-600">🔵 En télétravail</p>
                <p class="text-2xl font-bold text-blue-700" id="totalTeletravail">{{ $totalTeletravail }}</p>
            </div>
            <div class="bg-purple-50 rounded-xl border border-purple-100 p-4 text-center">
                <p class="text-xs text-purple-600">📊 Départements</p>
                <p class="text-2xl font-bold text-purple-700" id="totalDepartements">{{ $totalDepartements }}</p>
            </div>
        </div>

        <!-- Filtres et actions -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex flex-wrap gap-3">
                <select id="statusFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="all">Tous les statuts</option>
                    <option value="actif">🟢 Actif</option>
                    <option value="conge">🟡 En congé</option>
                    <option value="teletravail">🔵 Télétravail</option>
                    <option value="inactif">⚫ Inactif</option>
                </select>
                <select id="departmentFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="">Tous les départements</option>
                    @foreach($departements as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
                <input type="text" id="searchEmployee" placeholder="Rechercher..."
                    class="px-3 py-2 border border-gray-200 rounded-lg text-sm w-48">
                <button id="resetFilters"
                    class="px-3 py-2 text-gray-500 hover:text-gray-700 border border-gray-200 rounded-lg">
                    <iconify-icon icon="solar:refresh-linear" class="text-base"></iconify-icon>
                </button>
            </div>
            <button id="openEmployeeModal"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm">
                <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                Ajouter un employé
            </button>
        </div>

        <!-- Liste du personnel -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Employé</th>
                            <th class="px-6 py-4">Poste</th>
                            <th class="px-6 py-4">Département</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">Téléphone</th>
                            <th class="px-6 py-4">Date d'embauche</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        @foreach ($employees as $employee)
                            <tr>
                                <td>{{ $employee->user->lastname.' '.$employee->user->firstname }}</td>
                                <td>{{ $employee->poste }}</td>
                                <td>{{ $employee->departement->name }}</td>
                                <td>{{ $employee->user->email }}</td>
                                <td>{{ $employee->user->phone }}</td>
                                <td>{{ $employee->hire_date }}</td>
                                <td>{{ $employee->status }}</td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" 
                                            onclick="openEditModal({{ $employee->id }})" 
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm">
                                        <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                                    </button>
                                        <form action="{{ route('employes.destroy', $employee->id) }}" method="POST" class="inline-block" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet employé ? Cette action est irréversible.')">
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
            <div id="emptyPersonnel" class="text-center py-12 hidden">
                <iconify-icon icon="solar:users-group-rounded-linear"
                    class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
                <p class="text-gray-400">Aucun employé enregistré</p>
                <p class="text-gray-300 text-xs mt-1">Cliquez sur "Ajouter un employé" pour commencer</p>
            </div>
        </div>
    </div>

    <!-- MODAL Employé (Ajouter) -->
    <div id="employeeModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Ajouter un employé</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            
                <form action="{{ route('employes.store') }}" method="POST">
                @csrf
                    <div class="p-5 space-y-4">
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Prénom <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="firstname"
                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 @error('firstname') border-red-500 @enderror" value="{{ old('firstname') }}"
                                    placeholder="Prénom">
                                    @error('firstname')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span
                                        class="text-red-500">*</span></label>
                                <input type="text" name="lastname"
                                    class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 @error('lastname') border-red-500 @enderror" value="{{ old('lastname') }}"
                                    placeholder="Nom">
                                    @error('lastname')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Poste</label>
                                <input type="text" name="poste" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('poste') border-red-500 @enderror" value="{{ old('poste') }}"
                                    placeholder="Ex: Développeur Front-end">
                                    @error('poste')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                                <select name="department_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                                    <option value="">Choisir un département</option>
                                    @foreach($departements as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('email') }}"
                                    placeholder="prenom.nom@afroplume.com">
                                    @error('email')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                <input type="tel" name="phone" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('phone') border-red-500 @enderror" value="{{ old('phone') }}"
                                    placeholder="+229 XX XX XX XX XX">
                                    @error('phone')
                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                    @enderror
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date d'embauche</label>
                                <input type="date" name="hire_date" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('hire_date') border-red-500 @enderror" value="{{ old('hire_date') }}">
                                @error('hire_date')
                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Compétences / Notes</label>
                            <textarea name="skills" rows="2"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                                placeholder="React, Node.js, Gestion d'équipe..."></textarea>
                        </div>
                    </div>
                    <div class="flex justify-end gap-3 p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">
                        <button id="cancelModalBtn"
                            class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                        <button type="submit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
                    </div>
                </form>
        </div>
    </div>

    <!-- MODAL Modification Employé -->
    <div id="editEmployeeModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="editModalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0"
            id="editModalContainer">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900">Modifier l'employé</h3>
                <button id="closeEditModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            
            <form action="{{ route('employes.update', $employee->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="p-5 space-y-4">
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Prénom <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="firstname" value="{{ $employee->user->firstname }}"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                                placeholder="Prénom">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom <span
                                    class="text-red-500">*</span></label>
                            <input type="text" name="lastname" value="{{ $employee->user->lastname }}"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                                placeholder="Nom">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Poste</label>
                            <input type="text" name="poste" value="{{ $employee->poste }}"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                                placeholder="Ex: Développeur Front-end">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                            <select name="department_id" 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                                <option value="">Choisir un département</option>
                                @foreach($departements as $dep)
                                    <option value="{{ $dep->id }}"
                                        {{ $employee->department_id == $dep->id ? 'selected' : '' }}>
                                        {{ $dep->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{$employee->user->email}}"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                                placeholder="prenom.nom@afroplume.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                            <input type="tel" name="phone" value="{{ $employee->user->phone }}"
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                                placeholder="+229 XX XX XX XX XX">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                            <select name="status" 
                                class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                                <option value="actif">🟢 Actif</option>
                                <option value="conge">🟡 En congé</option>
                                <option value="teletravail">🔵 Télétravail</option>
                                <option value="inactif">⚫ Inactif</option>
                            </select>
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Compétences / Notes</label>
                        <textarea name="skills" rows="2"
                            class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                            placeholder="React, Node.js, Gestion d'équipe...">{{$employee->skills}}</textarea>
                    </div>
                </div>
                <div class="flex justify-end gap-3 p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">
                    <button id="cancelEditModalBtn"
                        class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                    <button type="submit"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            // GESTION DU MODAL - OUVERTURE ET FERMETURE UNIQUEMENT

            // ========== MODAL DE MODIFICATION ==========
            const editModal = document.getElementById('editEmployeeModal');
            const editModalContainer = document.getElementById('editModalContainer');
            const closeEditBtn = document.getElementById('closeEditModalBtn');
            const cancelEditBtn = document.getElementById('cancelEditModalBtn');
            const editBackdrop = document.getElementById('editModalBackdrop');
            const openEditBtn = document.getElementById('openEditEmployeeModal');

            // Récupération des éléments
            const modal = document.getElementById('employeeModal');
            const modalContainer = document.getElementById('modalContainer');
            const openBtn = document.getElementById('openEmployeeModal');
            const closeBtn = document.getElementById('closeModalBtn');
            const cancelBtn = document.getElementById('cancelModalBtn');
            const backdrop = document.getElementById('modalBackdrop');

            // Fonction pour ouvrir le modal
            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modalContainer.classList.remove('scale-95', 'opacity-0');
                    modalContainer.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            // Fonction pour fermer le modal
            function closeModal() {
                modalContainer.classList.remove('scale-100', 'opacity-100');
                modalContainer.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }, 200);
            }

            // Ouvrir le modal
            function openEditModal(){
                editModal.classList.remove('hidden');
                editModal.classList.add('flex');
                setTimeout(() => {
                    editModalContainer.classList.remove('scale-95', 'opacity-0');
                    editModalContainer.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeEditModal() {
                editModalContainer.classList.remove('scale-100', 'opacity-100');
                editModalContainer.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    editModal.classList.add('hidden');
                    editModal.classList.remove('flex');
                }, 200);
            }

            // Événements de fermeture du modal de modification
            closeEditBtn.addEventListener('click', closeEditModal);
            cancelEditBtn.addEventListener('click', closeEditModal);
            editBackdrop.addEventListener('click', closeEditModal);

            // Événements d'ouverture
            openBtn.addEventListener('click', openModal);

            // Événements de fermeture
            closeBtn.addEventListener('click', closeModal);
            cancelBtn.addEventListener('click', closeModal);
            backdrop.addEventListener('click', closeModal);
            
            @if ($errors->any())
                document.addEventListener("DOMContentLoaded", function () {
                    const modal = document.getElementById('employeeModal');
                    const container = document.getElementById('modalContainer');

                    modal.classList.remove('hidden');
                    modal.classList.add('flex');

                    container.classList.remove('scale-95', 'opacity-0');
                    container.classList.add('scale-100', 'opacity-100');
                });
            @endif
        </script>

        

        <style>
            .modal-backdrop {
                background-color: rgba(0, 0, 0, 0.5);
                backdrop-filter: blur(4px);
            }

            .fade-in {
                animation: fadeIn 0.2s ease;
            }

            @keyframes fadeIn {
                from {
                    opacity: 0;
                    transform: translateY(5px);
                }

                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }

            .status-badge {
                transition: all 0.2s ease;
            }

            .avatar-placeholder {
                background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            }
        </style>
    @endpush
@endsection