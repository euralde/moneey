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
                <p class="text-xl font-bold text-gray-900" id="totalLeads">0</p>
            </div>
            <div class="bg-blue-50 rounded-xl border border-blue-100 p-3 text-center">
                <p class="text-xs text-blue-600">🆕 Nouveau</p>
                <p class="text-xl font-bold text-blue-700" id="totalNouveau">0</p>
            </div>
            <div class="bg-amber-50 rounded-xl border border-amber-100 p-3 text-center">
                <p class="text-xs text-amber-600">📞 Contacté</p>
                <p class="text-xl font-bold text-amber-700" id="totalContacte">0</p>
            </div>
            <div class="bg-purple-50 rounded-xl border border-purple-100 p-3 text-center">
                <p class="text-xs text-purple-600">📅 RDV</p>
                <p class="text-xl font-bold text-purple-700" id="totalRdv">0</p>
            </div>
            <div class="bg-orange-50 rounded-xl border border-orange-100 p-3 text-center">
                <p class="text-xs text-orange-600">🤝 Négociation</p>
                <p class="text-xl font-bold text-orange-700" id="totalNegociation">0</p>
            </div>
            <div class="bg-emerald-50 rounded-xl border border-emerald-100 p-3 text-center">
                <p class="text-xs text-emerald-600">🏆 Gagné</p>
                <p class="text-xl font-bold text-emerald-700" id="totalGagne">0</p>
            </div>
            <div class="bg-gray-50 rounded-xl border border-gray-100 p-3 text-center">
                <p class="text-xs text-gray-500">❌ Perdu</p>
                <p class="text-xl font-bold text-gray-600" id="totalPerdu">0</p>
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
                    <tbody id="leadsTableBody" class="divide-y divide-gray-100"></tbody>
                </table>
            </div>
            <div id="emptyLeads" class="text-center py-12 hidden">
                <iconify-icon icon="solar:users-group-two-rounded-linear"
                    class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
                <p class="text-gray-400">Aucun lead enregistré</p>
                <p class="text-gray-300 text-xs mt-1">Cliquez sur "Nouveau lead" pour commencer</p>
            </div>
        </div>
    </div>

    <!-- MODAL Lead (Ajouter/Modifier) -->
    <div id="leadModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Nouveau lead</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom / Société <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="leadName"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Ex: Dupont SARL">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="leadEmail" class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                            placeholder="contact@email.com">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                        <input type="tel" id="leadPhone" class="w-full px-3 py-2 border border-gray-200 rounded-lg"
                            placeholder="+225 XX XX XX XX">
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Source</label>
                        <select id="leadSource" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
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
                        <select id="leadStatus" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
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
                    <select id="leadAssignedTo" class="w-full px-3 py-2 border border-gray-200 rounded-lg">
                        <option value="Junior SANNI">👤 Junior SANNI</option>
                        <option value="Marc Dupont">👨‍💻 Marc Dupont</option>
                        <option value="Koffi Jean">👨‍💻 Koffi Jean</option>
                        <option value="Aïssata Diallo">👩‍💼 Aïssata Diallo</option>
                        <option value="Pauline Yao">👩‍💼 Pauline Yao</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes / Commentaires</label>
                    <textarea id="leadNotes" rows="3" class="w-full px-3 py-2 border border-gray-200 rounded-lg resize-none"
                        placeholder="Informations complémentaires..."></textarea>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                <button id="cancelModalBtn"
                    class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50">Annuler</button>
                <button id="saveLeadBtn"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
            </div>
        </div>
    </div>

    <!-- MODAL Interactions (Historique) -->
    <div id="interactionModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="interactionModalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
            id="interactionModalContainer">
            <div class="flex justify-between items-center p-5 border-b">
                <h3 class="text-lg font-semibold text-gray-900" id="interactionModalTitle">Historique des interactions</h3>
                <button id="closeInteractionModalBtn" class="text-gray-400 hover:text-gray-600">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4 max-h-[400px] overflow-y-auto" id="interactionContent">
                <!-- Contenu dynamique -->
            </div>
            <div class="p-5 border-t bg-gray-50/50 rounded-b-xl">
                <div class="flex gap-2">
                    <input type="text" id="interactionInput" placeholder="Ajouter une note..."
                        class="flex-1 px-3 py-2 border border-gray-200 rounded-lg text-sm">
                    <button id="addInteractionBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Ajouter</button>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Données initiales
            let leads = JSON.parse(localStorage.getItem('afro_crm_leads') || JSON.stringify([
                {
                    id: 1, name: "Tech Solutions SARL", company: "Tech Solutions", email: "contact@techsolutions.com",
                    phone: "+225 07 12 34 56", source: "site_web", status: "negociation",
                    assignedTo: "Junior SANNI", notes: "Premier contact positif, devis envoyé",
                    createdAt: "2026-03-15", interactions: [
                        { date: "2026-03-15", text: "Premier contact - client intéressé" },
                        { date: "2026-03-20", text: "Envoi du devis" },
                        { date: "2026-03-25", text: "Relance client" }
                    ]
                },
                {
                    id: 2, name: "Marie Koné", company: "", email: "marie.kone@email.com",
                    phone: "+225 05 98 76 54", source: "linkedin", status: "rdv",
                    assignedTo: "Marc Dupont", notes: "RDV prévu le 25 mars pour présentation",
                    createdAt: "2026-03-10", interactions: [
                        { date: "2026-03-10", text: "Contact via LinkedIn" }
                    ]
                },
                {
                    id: 3, name: "Digital Africa", company: "Digital Africa", email: "info@digitalafrica.com",
                    phone: "+225 01 23 45 67", source: "salon", status: "gagne",
                    assignedTo: "Junior SANNI", notes: "Contrat signé le 20 mars",
                    createdAt: "2026-02-28", interactions: [
                        { date: "2026-02-28", text: "Rencontré au salon" },
                        { date: "2026-03-05", text: "Proposition commerciale envoyée" },
                        { date: "2026-03-20", text: "Contrat signé !" }
                    ]
                },
                {
                    id: 4, name: "Orange CI", company: "Orange", email: "partenariat@orange.ci",
                    phone: "+225 07 00 11 22", source: "cold_call", status: "nouveau",
                    assignedTo: "Koffi Jean", notes: "À contacter pour proposition",
                    createdAt: "2026-03-18", interactions: []
                }
            ]));

            let currentEditId = null;
            let currentInteractionLeadId = null;

            const statusLabels = {
                nouveau: { label: "🆕 Nouveau", color: "bg-blue-100 text-blue-700" },
                contacte: { label: "📞 Contacté", color: "bg-amber-100 text-amber-700" },
                rdv: { label: "📅 Rendez-vous", color: "bg-purple-100 text-purple-700" },
                negociation: { label: "🤝 Négociation", color: "bg-orange-100 text-orange-700" },
                gagne: { label: "🏆 Gagné", color: "bg-emerald-100 text-emerald-700" },
                perdu: { label: "❌ Perdu", color: "bg-gray-100 text-gray-600" }
            };

            const sourceLabels = {
                site_web: "🌐 Site web",
                linkedin: "🔗 LinkedIn",
                recommandation: "⭐ Recommandation",
                salon: "🎪 Salon professionnel",
                cold_call: "📞 Cold call",
                partenaire: "🤝 Partenaire"
            };

            function saveLeads() { localStorage.setItem('afro_crm_leads', JSON.stringify(leads)); }

            function updateStats() {
                document.getElementById('totalLeads').innerText = leads.length;
                document.getElementById('totalNouveau').innerText = leads.filter(l => l.status === 'nouveau').length;
                document.getElementById('totalContacte').innerText = leads.filter(l => l.status === 'contacte').length;
                document.getElementById('totalRdv').innerText = leads.filter(l => l.status === 'rdv').length;
                document.getElementById('totalNegociation').innerText = leads.filter(l => l.status === 'negociation').length;
                document.getElementById('totalGagne').innerText = leads.filter(l => l.status === 'gagne').length;
                document.getElementById('totalPerdu').innerText = leads.filter(l => l.status === 'perdu').length;
            }

            function renderLeads() {
                let filtered = [...leads];
                const statusVal = document.getElementById('statusFilter').value;
                const sourceVal = document.getElementById('sourceFilter').value;
                const searchVal = document.getElementById('searchLead').value.toLowerCase();

                if (statusVal !== 'all') filtered = filtered.filter(l => l.status === statusVal);
                if (sourceVal !== 'all') filtered = filtered.filter(l => l.source === sourceVal);
                if (searchVal) {
                    filtered = filtered.filter(l =>
                        l.name.toLowerCase().includes(searchVal) ||
                        (l.company && l.company.toLowerCase().includes(searchVal)) ||
                        (l.email && l.email.toLowerCase().includes(searchVal))
                    );
                }

                filtered.sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt));

                const tbody = document.getElementById('leadsTableBody');
                const empty = document.getElementById('emptyLeads');

                if (filtered.length === 0) {
                    tbody.innerHTML = '';
                    empty.classList.remove('hidden');
                    updateStats();
                    return;
                }
                empty.classList.add('hidden');

                tbody.innerHTML = filtered.map(lead => `
                                                    <tr class="hover:bg-gray-50 transition-colors">
                                                        <td class="px-6 py-4">
                                                            <div class="font-medium text-gray-900">${escapeHtml(lead.name)}</div>
                                                            ${lead.company ? `<div class="text-xs text-gray-400">${escapeHtml(lead.company)}</div>` : ''}
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <div class="text-sm text-gray-600">${escapeHtml(lead.email || '-')}</div>
                                                            <div class="text-xs text-gray-400">${escapeHtml(lead.phone || '-')}</div>
                                                        </td>
                                                        <td class="px-6 py-4"><span class="text-xs">${sourceLabels[lead.source] || lead.source}</span></td>
                                                        <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ${statusLabels[lead.status]?.color || 'bg-gray-100'}">${statusLabels[lead.status]?.label || lead.status}</span></td>
                                                        <td class="px-6 py-4 text-sm text-gray-600">${escapeHtml(lead.assignedTo || 'Non assigné')}</td>
                                                        <td class="px-6 py-4 text-gray-400 text-xs">${new Date(lead.createdAt).toLocaleDateString('fr-FR')}</td>
                                                        <td class="px-6 py-4 text-center">
                                                            <div class="flex items-center justify-center gap-1">
                                                                <button onclick="openInteractions(${lead.id})" class="text-purple-600 hover:bg-purple-50 p-1.5 rounded" title="Historique">
                                                                    <iconify-icon icon="solar:chat-round-dots-linear" class="text-base"></iconify-icon>
                                                                </button>
                                                                <button onclick="editLead(${lead.id})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded" title="Modifier">
                                                                    <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                                                                </button>
                                                                <button onclick="deleteLead(${lead.id})" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded" title="Supprimer">
                                                                    <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                `).join('');
                updateStats();
            }

            function escapeHtml(str) { if (!str) return ''; return str.replace(/[&<>]/g, function (m) { if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; return m; }); }

            // CRUD
            function editLead(id) {
                const lead = leads.find(l => l.id === id);
                if (lead) {
                    currentEditId = id;
                    document.getElementById('modalTitle').innerText = 'Modifier le lead';
                    document.getElementById('leadName').value = lead.name;
                    document.getElementById('leadEmail').value = lead.email || '';
                    document.getElementById('leadPhone').value = lead.phone || '';
                    document.getElementById('leadSource').value = lead.source;
                    document.getElementById('leadStatus').value = lead.status;
                    document.getElementById('leadAssignedTo').value = lead.assignedTo || 'Junior SANNI';
                    document.getElementById('leadNotes').value = lead.notes || '';
                    openModal();
                }
            }

            function deleteLead(id) {
                if (confirm('⚠️ Supprimer ce lead ? Cette action est irréversible.')) {
                    leads = leads.filter(l => l.id !== id);
                    saveLeads();
                    renderLeads();
                }
            }

            // Interactions
            function openInteractions(id) {
                const lead = leads.find(l => l.id === id);
                if (lead) {
                    currentInteractionLeadId = id;
                    document.getElementById('interactionModalTitle').innerHTML = `Historique - ${escapeHtml(lead.name)}`;

                    const interactionsHtml = (lead.interactions || []).map(i => `
                                                        <div class="border-b border-gray-100 pb-2 mb-2">
                                                            <div class="flex justify-between items-start">
                                                                <p class="text-sm text-gray-700">${escapeHtml(i.text)}</p>
                                                                <span class="text-[10px] text-gray-400">${i.date}</span>
                                                            </div>
                                                        </div>
                                                    `).join('');

                    document.getElementById('interactionContent').innerHTML = interactionsHtml || '<p class="text-sm text-gray-400 text-center">Aucune interaction</p>';
                    document.getElementById('interactionInput').value = '';
                    openInteractionModal();
                }
            }

            function addInteraction() {
                const text = document.getElementById('interactionInput').value.trim();
                if (!text || !currentInteractionLeadId) return;

                const lead = leads.find(l => l.id === currentInteractionLeadId);
                if (lead) {
                    if (!lead.interactions) lead.interactions = [];
                    lead.interactions.push({
                        date: new Date().toISOString().split('T')[0],
                        text: text
                    });
                    saveLeads();
                    openInteractions(currentInteractionLeadId);
                }
            }

            // Modal principal
            function openModal() {
                const modal = document.getElementById('leadModal');
                const container = document.getElementById('modalContainer');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    container.classList.remove('scale-95', 'opacity-0');
                    container.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal() {
                const container = document.getElementById('modalContainer');
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    document.getElementById('leadModal').classList.add('hidden');
                    document.getElementById('leadModal').classList.remove('flex');
                    resetForm();
                }, 200);
            }

            function resetForm() {
                currentEditId = null;
                document.getElementById('modalTitle').innerText = 'Nouveau lead';
                document.getElementById('leadName').value = '';
                document.getElementById('leadEmail').value = '';
                document.getElementById('leadPhone').value = '';
                document.getElementById('leadSource').value = 'site_web';
                document.getElementById('leadStatus').value = 'nouveau';
                document.getElementById('leadAssignedTo').value = 'Junior SANNI';
                document.getElementById('leadNotes').value = '';
            }

            function saveLead() {
                const name = document.getElementById('leadName').value.trim();
                if (!name) { alert('Veuillez saisir un nom'); return; }

                const email = document.getElementById('leadEmail').value.trim();
                const phone = document.getElementById('leadPhone').value.trim();
                const source = document.getElementById('leadSource').value;
                const status = document.getElementById('leadStatus').value;
                const assignedTo = document.getElementById('leadAssignedTo').value;
                const notes = document.getElementById('leadNotes').value.trim();

                if (currentEditId !== null) {
                    const index = leads.findIndex(l => l.id === currentEditId);
                    if (index !== -1) {
                        leads[index] = { ...leads[index], name, email, phone, source, status, assignedTo, notes };
                    }
                } else {
                    leads.push({
                        id: Date.now(),
                        name, email, phone, source, status, assignedTo, notes,
                        company: '',
                        interactions: [],
                        createdAt: new Date().toISOString().split('T')[0]
                    });
                }
                saveLeads();
                renderLeads();
                closeModal();
            }

            // Interaction modal
            function openInteractionModal() {
                const modal = document.getElementById('interactionModal');
                const container = document.getElementById('interactionModalContainer');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    container.classList.remove('scale-95', 'opacity-0');
                    container.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeInteractionModal() {
                const container = document.getElementById('interactionModalContainer');
                container.classList.remove('scale-100', 'opacity-100');
                container.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    document.getElementById('interactionModal').classList.add('hidden');
                    document.getElementById('interactionModal').classList.remove('flex');
                    currentInteractionLeadId = null;
                }, 200);
            }

            // Event listeners
            document.getElementById('openLeadModal').addEventListener('click', () => { resetForm(); openModal(); });
            document.getElementById('closeModalBtn').addEventListener('click', closeModal);
            document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
            document.getElementById('modalBackdrop').addEventListener('click', closeModal);
            document.getElementById('saveLeadBtn').addEventListener('click', saveLead);

            document.getElementById('closeInteractionModalBtn').addEventListener('click', closeInteractionModal);
            document.getElementById('interactionModalBackdrop').addEventListener('click', closeInteractionModal);
            document.getElementById('addInteractionBtn').addEventListener('click', addInteraction);
            document.getElementById('interactionInput').addEventListener('keypress', (e) => {
                if (e.key === 'Enter') addInteraction();
            });

            document.getElementById('statusFilter').addEventListener('change', renderLeads);
            document.getElementById('sourceFilter').addEventListener('change', renderLeads);
            document.getElementById('searchLead').addEventListener('input', renderLeads);
            document.getElementById('resetFilters').addEventListener('click', () => {
                document.getElementById('statusFilter').value = 'all';
                document.getElementById('sourceFilter').value = 'all';
                document.getElementById('searchLead').value = '';
                renderLeads();
            });

            // Escape key
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape') {
                    if (!document.getElementById('leadModal').classList.contains('hidden')) closeModal();
                    if (!document.getElementById('interactionModal').classList.contains('hidden')) closeInteractionModal();
                }
            });

            // Styles
            const style = document.createElement('style');
            style.textContent = `.modal-backdrop { background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); }`;
            document.head.appendChild(style);

            // Initial render
            renderLeads();
        </script>
    @endpush
@endsection