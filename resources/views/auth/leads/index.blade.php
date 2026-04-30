{{-- resources/views/crm/index.blade.php --}}
@extends('layouts.app') {{-- Adaptez selon le nom de votre layout --}}

@section('content')
    <div class="max-w-7xl mx-auto">

        <!-- En-tête -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">CRM - Gestion des leads</h1>
                <p class="text-sm text-gray-500 mt-0.5">Suivez vos prospects et clients</p>
            </div>
            <button id="openLeadModal"
                class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all shadow-sm">
                <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                Nouveau lead
            </button>
        </div>

        <!-- Cartes statistiques -->
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-7 gap-3 mb-6">
            <div class="bg-white rounded-xl border p-3 text-center">
                <p class="text-xs text-gray-500">Total</p>
                <p class="text-xl font-bold text-gray-900">{{$totallead}}</p>
            </div>
            <div class="bg-blue-50 rounded-xl border border-blue-100 p-3 text-center">
                <p class="text-xs text-blue-600">🆕 Nouveau</p>
                <p class="text-xl font-bold text-blue-700">{{$totalnouveau}}</p>
            </div>
            <div class="bg-amber-50 rounded-xl border border-amber-100 p-3 text-center">
                <p class="text-xs text-amber-600">📞 Contacté</p>
                <p class="text-xl font-bold text-amber-700">{{$totalcontacte}}</p>
            </div>
            <div class="bg-purple-50 rounded-xl border border-purple-100 p-3 text-center">
                <p class="text-xs text-purple-600">📅 RDV</p>
                <p class="text-xl font-bold text-purple-700">{{$totalrdv}}</p>
            </div>
            <div class="bg-orange-50 rounded-xl border border-orange-100 p-3 text-center">
                <p class="text-xs text-orange-600">🤝 Négociation</p>
                <p class="text-xl font-bold text-orange-700" >{{$totalnegocation}}</p>
            </div>
            <div class="bg-emerald-50 rounded-xl border border-emerald-100 p-3 text-center">
                <p class="text-xs text-emerald-600">🏆 Gagné</p>
                <p class="text-xl font-bold text-emerald-700">{{$totalgagne}}</p>
            </div>
            <div class="bg-gray-50 rounded-xl border border-gray-100 p-3 text-center">
                <p class="text-xs text-gray-500">❌ Perdu</p>
                <p class="text-xl font-bold text-gray-600">{{$totalperdu}}</p>
            </div>
        </div>

        <!-- Filtres -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex flex-wrap gap-3">
                <select id="statusFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="all">Tous les statuts</option>
                    <option value="nouveau">🆕 Nouveau</option>
                    <option value="contacte">📞 Contacté</option>
                    <option value="rdv">📅 Rendez-vous</option>
                    <option value="negociation">🤝 Négociation</option>
                    <option value="gagne">🏆 Gagné</option>
                    <option value="perdu">❌ Perdu</option>
                </select>
                <select id="sourceFilter" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="all">Toutes sources</option>
                    <option value="site_web">🌐 Site web</option>
                    <option value="linkedin">🔗 LinkedIn</option>
                    <option value="recommandation">⭐ Recommandation</option>
                    <option value="salon">🎪 Salon</option>
                    <option value="cold_call">📞 Cold call</option>
                    <option value="partenaire">🤝 Partenaire</option>
                </select>
                <input type="text" id="searchLead" placeholder="Rechercher..."
                    class="px-3 py-2 border border-gray-200 rounded-lg text-sm w-48">
                <button id="resetFilters"
                    class="px-3 py-2 text-gray-500 hover:text-gray-700 border border-gray-200 rounded-lg">
                    <iconify-icon icon="solar:refresh-linear" class="text-base"></iconify-icon>
                </button>
            </div>
        </div>

        <!-- Datatable leads -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Client / Société</th>
                            <th class="px-6 py-4">Contact</th>
                            <th class="px-6 py-4">Source</th>
                            <th class="px-6 py-4">Statut</th>
                            <th class="px-6 py-4">Assigné à</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody style="text-align: center">
                        @foreach($leads as $lead)
                        <tr>
                            <td>{{ $lead->name }}</td>
                            <td>{{ $lead->phone }}</td>
                            <td>{{ $lead->source }}</td>
                            <td>{{ $lead->status }}</td>
                            <td>{{ $lead->assignedTo->lastname.' '.$lead->assignedTo->firstname }}</td>
                            <td>{{ $lead->created_at->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <button type="button" 
                                            onclick="openEditModal({{ $lead->id }})" 
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium shadow-sm">
                                        <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                                    </button>
                                        <form action="{{ route('lead.delete', $lead->id) }}" method="POST" class="inline-block" onsubmit="return confirm('⚠️ Êtes-vous sûr de vouloir supprimer cet employé ? Cette action est irréversible.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded transition-colors" title="Supprimer">
                                                <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                        </tr>
                        <!-- MODAL de modification -->
                        <div id="editleadModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"> 
                            <div class="absolute inset-0 modal-backdrop" id="editModalBackdrop"></div> 
                            <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="editModalContainer">
                                <div class="flex justify-between items-center p-5 border-b">
                                    <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Nouveau lead</h3>
                                    <button id="closeEditModalBtn" class="text-gray-400 hover:text-gray-600">
                                        <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                                    </button>
                                </div>
                                <div class="p-5 space-y-4">
                                <form action="{{ route('lead.update', $lead->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Nom / Société <span
                                                    class="text-red-500">*</span></label>
                                            <input type="text" 
                                                class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 @error('name') border-red-500 @enderror" value="{{ $lead->name }}" name="name"
                                                placeholder="Ex: Dupont SARL">
                                                @error('name')
                                                    <span class="text-red-500 text-sm">{{ $message }}</span>
                                                @enderror
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                                <input type="email" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('email') border-red-500 @enderror" value="{{ $lead->email }}" name="email"
                                                    placeholder="contact@email.com">
                                                    @error('email')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                                                <input type="tel" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('phone') border-red-500 @enderror" value="{{ $lead->phone }}" name="phone"
                                                    placeholder="+229 XX XX XX XX XX">
                                                    @error('phone')
                                                        <span class="text-red-500 text-sm">{{ $message }}</span>
                                                    @enderror
                                            </div>
                                        </div>
                                        <div class="grid grid-cols-2 gap-3">
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Source</label>
                                                <select  class="w-full px-3 py-2 border border-gray-200 rounded-lg"name="source">
                                                    <option value="site_web">🌐 Site web</option>
                                                    <option value="linkedin">🔗 LinkedIn</option>
                                                    <option value="recommandation">⭐ Recommandation</option>
                                                    <option value="salon">🎪 Salon professionnel</option>
                                                    <option value="cold_call">📞 Cold call</option>
                                                    <option value="partenaire">🤝 Partenaire</option>
                                                </select>
                                            </div>
                                            <div>
                                                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                                                <select  class="w-full px-3 py-2 border border-gray-200 rounded-lg" name="status">
                                                    <option value="nouveau">🆕 Nouveau</option>
                                                    <option value="contacte">📞 Contacté</option>
                                                    <option value="rdv">📅 Rendez-vous pris</option>
                                                    <option value="negociation">🤝 Négociation</option>
                                                    <option value="gagne">🏆 Gagné</option>
                                                    <option value="perdu">❌ Perdu</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Assigné à</label>
                                            <select name="assigned_to" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                                                <option value="">Choisir un employé</option>
                                                @foreach($users as $user)
                                                    <option value="{{ $user->id }}">
                                                        {{ $lead->assigned_to == $user->id ? 'selected' : '' }}>
                                                        {{ $user->lastname.' '.$user->firstname }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div>
                                            <label class="block text-sm font-medium text-gray-700 mb-1">Notes / Commentaires</label>
                                            <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none" value="{{ $lead->notes }}"
                                                placeholder="Informations complémentaires..."></textarea>
                                        </div>
                                    </div>
                                    <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                                        <button id="cancelEditModalBtn"
                                            class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                                        <button type="submit" 
                                            class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL Lead Ajouter -->
    <div id="leadModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4"> 
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div> 
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="modalContainer">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Nouveau lead</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4">
            <form action="{{ route('lead.store') }}" method="POST">
                @csrf
            <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom / Société <span
                            class="text-red-500">*</span></label>
                    <input type="text" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 @error('name') border-red-500 @enderror" value="{{ old('name') }}" name="name"
                        placeholder="Ex: Dupont SARL">
                        @error('name')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('email') border-red-500 @enderror" value="{{ old('email') }}" name="email"
                            placeholder="contact@email.com">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('phone') border-red-500 @enderror" value="{{ old('phone') }}" name="phone"
                            placeholder="+229 XX XX XX XX XX">
                            @error('phone')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Source</label>
                        <select  class="w-full px-3 py-2 border border-gray-200 rounded-lg"name="source">
                            <option value="site_web">🌐 Site web</option>
                            <option value="linkedin">🔗 LinkedIn</option>
                            <option value="recommandation">⭐ Recommandation</option>
                            <option value="salon">🎪 Salon professionnel</option>
                            <option value="cold_call">📞 Cold call</option>
                            <option value="partenaire">🤝 Partenaire</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select  class="w-full px-3 py-2 border border-gray-200 rounded-lg" name="status">
                            <option value="nouveau">🆕 Nouveau</option>
                            <option value="contacte">📞 Contacté</option>
                            <option value="rdv">📅 Rendez-vous pris</option>
                            <option value="negociation">🤝 Négociation</option>
                            <option value="gagne">🏆 Gagné</option>
                            <option value="perdu">❌ Perdu</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Assigné à</label>
                    <select name="assigned_to" class="w-full px-3 py-2 border border-gray-200 rounded-lg @error('assigned_to') border-red-500 @enderror" value="{{ old('assigned_to') }}">
                        <option value="">Choisir un employé</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->lastname.' '.$user->firstname }}</option>
                        @endforeach
                    </select>
                    @error('assigned_to')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes / Commentaires</label>
                    <textarea name="notes" rows="3" class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                        placeholder="Informations complémentaires..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                <button id="cancelModalBtn"
                    class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                <button 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
            </div>
            </form>
        </div>
    </div>

    

    
    @push('scripts')
        <script>
                const leadModal = document.getElementById('leadModal');
                const modalContainer = document.getElementById('modalContainer');
                const backdrop = document.getElementById('modalBackdrop');

                // OUVRIR MODAL
                function openLeadModal() {
                    leadModal.classList.remove('hidden');
                    leadModal.classList.add('flex');

                    // effet animation
                    setTimeout(() => {
                        modalContainer.classList.remove('scale-95', 'opacity-0');
                        modalContainer.classList.add('scale-100', 'opacity-100');
                    }, 10);

                }

                // FERMER MODAL
                function closeLeadModal() {
                    modalContainer.classList.remove('scale-100', 'opacity-100');
                    modalContainer.classList.add('scale-95', 'opacity-0');

                    setTimeout(() => {
                        leadModal.classList.add('hidden');
                        leadModal.classList.remove('flex');
                    }, 200);
                }

            document.getElementById('openLeadModal').addEventListener('click', openLeadModal);
            document.getElementById('closeModalBtn').addEventListener('click', closeLeadModal);
            document.getElementById('modalBackdrop').addEventListener('click', closeLeadModal);

                // ========== MODAL DE MODIFICATION ==========
            const editModal = document.getElementById('editleadModal');
            const editModalContainer = document.getElementById('editModalContainer');
            const closeEditBtn = document.getElementById('closeEditModalBtn');
            const cancelEditBtn = document.getElementById('cancelEditModalBtn');
            const editBackdrop = document.getElementById('editModalBackdrop');
            const openEditBtn = document.getElementById('openEditleadModal');

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

            @if ($errors->any())
                document.addEventListener("DOMContentLoaded", function () {
                    const modal = document.getElementById('leadModal');
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