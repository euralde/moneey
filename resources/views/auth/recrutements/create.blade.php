@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">

        <!-- En-tête -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('recrutement.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <iconify-icon icon="solar:arrow-left-linear" class="text-2xl"></iconify-icon>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    {{ isset($recrutement) ? 'Modifier le recrutement' : 'Nouveau recrutement' }}
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">
                    {{ isset($recrutement) ? 'Modifiez les informations de l\'offre d\'emploi' : 'Créez une nouvelle offre d\'emploi' }}
                </p>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <form id="recrutementForm" class="p-6 space-y-6">
                @csrf
                <input type="hidden" id="recrutementId" value="{{ isset($recrutement) ? $recrutement->id : '' }}">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Titre du poste -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Intitulé du poste <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title"
                            value="{{ isset($recrutement) ? $recrutement->title : '' }}"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500"
                            placeholder="Ex: Développeur Full Stack">
                    </div>

                    <!-- Département -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                        <select id="department" name="department"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20">
                            <option value="IT" {{ isset($recrutement) && $recrutement->department == 'IT' ? 'selected' : '' }}>💻 IT / Développement</option>
                            <option value="Marketing" {{ isset($recrutement) && $recrutement->department == 'Marketing' ? 'selected' : '' }}>📢 Marketing</option>
                            <option value="Commercial" {{ isset($recrutement) && $recrutement->department == 'Commercial' ? 'selected' : '' }}>💰 Commercial</option>
                            <option value="RH" {{ isset($recrutement) && $recrutement->department == 'RH' ? 'selected' : '' }}>👥 Ressources Humaines</option>
                            <option value="Finance" {{ isset($recrutement) && $recrutement->department == 'Finance' ? 'selected' : '' }}>📊 Finance</option>
                            <option value="Logistique" {{ isset($recrutement) && $recrutement->department == 'Logistique' ? 'selected' : '' }}>📦 Logistique</option>
                        </select>
                    </div>

                    <!-- Localisation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                        <input type="text" id="location" name="location"
                            value="{{ isset($recrutement) ? $recrutement->location : '' }}"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                            placeholder="Abidjan, Paris, Remote">
                    </div>

                    <!-- Date limite -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date limite <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="deadline" name="deadline"
                            value="{{ isset($recrutement) ? $recrutement->deadline : '' }}"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20">
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="status" name="status"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20">
                            <option value="ouverte" {{ isset($recrutement) && $recrutement->status == 'ouverte' ? 'selected' : '' }}>🟢 Ouverte</option>
                            <option value="encours" {{ isset($recrutement) && $recrutement->status == 'encours' ? 'selected' : '' }}>🟡 En cours</option>
                            <option value="pourvue" {{ isset($recrutement) && $recrutement->status == 'pourvue' ? 'selected' : '' }}>🔵 Pourvue</option>
                            <option value="fermee" {{ isset($recrutement) && $recrutement->status == 'fermee' ? 'selected' : '' }}>⚫ Fermée</option>
                        </select>
                    </div>

                    <!-- Description du poste -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description du poste</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 resize-none"
                            placeholder="Missions, responsabilités, avantages...">{{ isset($recrutement) ? $recrutement->description : '' }}</textarea>
                    </div>

                    <!-- Prérequis -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prérequis & compétences</label>
                        <textarea id="requirements" name="requirements" rows="4"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 resize-none"
                            placeholder="- Bac+5 en informatique&#10;- 3 ans d&#39;expérience minimum&#10;- Maîtrise de React et Node.js&#10;- Anglais professionnel">{{ isset($recrutement) ? $recrutement->requirements : '' }}</textarea>
                        <p class="text-xs text-gray-400 mt-1">Séparez chaque prérequis par un retour à la ligne</p>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ url('recrutements') }}"
                        class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">Annuler</a>
                    <button type="submit" id="submitBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                        <iconify-icon icon="solar:check-circle-linear" class="inline mr-2 text-base"></iconify-icon>
                        {{ isset($recrutement) ? 'Mettre à jour' : 'Créer l\'offre' }}
                    </button>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            const form = document.getElementById('recrutementForm');
            const submitBtn = document.getElementById('submitBtn');

            // Charger les recrutements existants
            let recrutements = JSON.parse(localStorage.getItem('afro_recrutements') || '[]');
            const editId = document.getElementById('recrutementId').value;

            form.addEventListener('submit', function (e) {
                e.preventDefault();

                // Récupération des valeurs
                const title = document.getElementById('title').value.trim();
                const department = document.getElementById('department').value;
                const location = document.getElementById('location').value.trim();
                const deadline = document.getElementById('deadline').value;
                const status = document.getElementById('status').value;
                const description = document.getElementById('description').value.trim();
                const requirements = document.getElementById('requirements').value.trim();

                // Validation
                if (!title) { alert('Veuillez saisir un intitulé de poste'); return; }
                if (!deadline) { alert('Veuillez saisir une date limite'); return; }

                // Désactiver le bouton pendant l'enregistrement
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<iconify-icon icon="svg-spinners:3-dots-fade" class="inline mr-2 text-base"></iconify-icon> Enregistrement...';

                setTimeout(() => {
                    if (editId) {
                        // Mode modification
                        const index = recrutements.findIndex(r => r.id == editId);
                        if (index !== -1) {
                            recrutements[index] = {
                                ...recrutements[index],
                                title, department, location, deadline, status,
                                description, requirements
                            };
                        }
                    } else {
                        // Mode création
                        const newRecrutement = {
                            id: Date.now(),
                            title, department, location, deadline, status,
                            description, requirements,
                            candidatures: 0,
                            createdAt: new Date().toISOString().split('T')[0]
                        };
                        recrutements.push(newRecrutement);
                    }

                    // Sauvegarde dans localStorage
                    localStorage.setItem('afro_recrutements', JSON.stringify(recrutements));

                    // Redirection vers la liste
                    window.location.href = '{{ url("recrutements") }}';
                }, 500);
            });
        </script>
    @endpush
@endsection