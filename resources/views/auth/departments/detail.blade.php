@extends('layouts.app')

@section('title', 'Service Sourcing - AFRO\'PLUME')
@section('header-title', 'Service Sourcing')
@section('header-subtitle', 'Importation de véhicules et équipements')

@section('content')
<div class="max-w-7xl mx-auto pb-20 space-y-6">

    <!-- En-tête du service -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white shadow-lg">
        <div class="flex justify-between items-start">
            <div>
                <div class="flex items-center gap-2 mb-2">
                    <div class="w-10 h-10 bg-white/20 rounded-xl flex items-center justify-center">
                        <iconify-icon icon="solar:bag-check-bold" class="text-2xl"></iconify-icon>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold">Sourcing & Importation</h2>
                        <p class="text-blue-100 text-sm">Chine - Afrique | Véhicules & Équipements industriels</p>
                    </div>
                </div>
            </div>
            <div class="bg-white/20 rounded-lg px-4 py-2 text-right">
                <p class="text-xs text-blue-100">Statut</p>
                <p class="text-sm font-semibold flex items-center gap-1">
                    <iconify-icon icon="solar:check-circle-bold" class="text-emerald-300"></iconify-icon>
                    Actif
                </p>
            </div>
        </div>
    </div>

    <!-- Cartes KPI -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">CA du mois</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1" id="caMois">0 FCFA</p>
                    <div class="flex items-center gap-1 mt-2">
                        <span class="text-emerald-600 text-xs bg-emerald-50 px-2 py-0.5 rounded-full flex items-center">
                            <iconify-icon icon="solar:trend-up-linear" class="text-xs"></iconify-icon> +15%
                        </span>
                        <span class="text-xs text-gray-400">vs mois dernier</span>
                    </div>
                </div>
                <div class="w-10 h-10 bg-emerald-100 rounded-xl flex items-center justify-center">
                    <iconify-icon icon="solar:wallet-money-linear" class="text-emerald-600 text-xl"></iconify-icon>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Véhicules sourcés</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1" id="totalVehicules">0</p>
                    <p class="text-xs text-gray-400 mt-2">dont <span id="vehiculesVendus">0</span> vendus</p>
                </div>
                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                    <iconify-icon icon="solar:car-linear" class="text-blue-600 text-xl"></iconify-icon>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Leads actifs</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1" id="totalLeads">0</p>
                    <p class="text-xs text-gray-400 mt-2">taux conversion: <span id="tauxConversion">0</span>%</p>
                </div>
                <div class="w-10 h-10 bg-amber-100 rounded-xl flex items-center justify-center">
                    <iconify-icon icon="solar:users-group-two-rounded-linear" class="text-amber-600 text-xl"></iconify-icon>
                </div>
            </div>
        </div>

        <div class="stat-card bg-white rounded-xl border border-gray-200 p-5 shadow-sm hover:shadow-md">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-xs text-gray-400 uppercase tracking-wider">Objectif mensuel</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">150M FCFA</p>
                    <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                        <div class="bg-blue-600 h-1.5 rounded-full" style="width: 68%"></div>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">68% atteint</p>
                </div>
                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                    <iconify-icon icon="solar:target-linear" class="text-purple-600 text-xl"></iconify-icon>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphique CA mensuel -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-5">
        <div class="flex justify-between items-center mb-4">
            <div>
                <h3 class="font-semibold text-gray-800">Évolution du CA</h3>
                <p class="text-xs text-gray-400">Janvier - Mars 2026 (en millions FCFA)</p>
            </div>
            <select id="yearSelect" class="text-sm border border-gray-200 rounded-lg px-3 py-1 bg-white">
                <option value="2025">2025</option>
                <option value="2026" selected>2026</option>
            </select>
        </div>
        <canvas id="caChart" height="220"></canvas>
    </div>

    <!-- Liste des véhicules + Leads récents -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Liste des véhicules -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                        <iconify-icon icon="solar:car-linear" class="text-blue-500 text-lg"></iconify-icon>
                        Catalogue véhicules
                    </h3>
                    <p class="text-xs text-gray-400">Véhicules sourcés depuis la Chine</p>
                </div>
                <button id="openVehiculeModal" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-lg text-sm flex items-center gap-1 transition-colors">
                    <iconify-icon icon="solar:add-circle-linear" class="text-base"></iconify-icon>
                    Ajouter
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-xs text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Modèle</th>
                            <th class="px-4 py-3">Année</th>
                            <th class="px-4 py-3">Prix (FCFA)</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        \)
                    </thead>
                    <tbody id="vehiculesTableBody" class="divide-y divide-gray-100 text-sm"></tbody>
                </table>
            </div>
            <div id="emptyVehicules" class="text-center py-8 hidden">
                <iconify-icon icon="solar:car-linear" class="text-3xl text-gray-300 mx-auto mb-2"></iconify-icon>
                <p class="text-gray-400 text-xs">Aucun véhicule enregistré</p>
            </div>
        </div>

        <!-- Liste des leads -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="px-5 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <div>
                    <h3 class="font-semibold text-gray-800 flex items-center gap-2">
                        <iconify-icon icon="solar:users-group-two-rounded-linear" class="text-amber-500 text-lg"></iconify-icon>
                        Derniers leads
                    </h3>
                    <p class="text-xs text-gray-400">Prospects intéressés par nos services</p>
                </div>
                <button id="openLeadModal" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded-lg text-sm flex items-center gap-1 transition-colors">
                    <iconify-icon icon="solar:add-circle-linear" class="text-base"></iconify-icon>
                    Ajouter
                </button>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 text-xs text-gray-500">
                        <tr>
                            <th class="px-4 py-3">Client</th>
                            <th class="px-4 py-3">Contact</th>
                            <th class="px-4 py-3">Intérêt</th>
                            <th class="px-4 py-3">Statut</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        \)"
                    </thead>
                    <tbody id="leadsTableBody" class="divide-y divide-gray-100 text-sm"></tbody>
                </table>
            </div>
            <div id="emptyLeads" class="text-center py-8 hidden">
                <iconify-icon icon="solar:users-group-two-rounded-linear" class="text-3xl text-gray-300 mx-auto mb-2"></iconify-icon>
                <p class="text-gray-400 text-xs">Aucun lead enregistré</p>
            </div>
        </div>
    </div>
</div>

<!-- MODAL Véhicule -->
<div id="vehiculeModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" id="vehiculeModalBackdrop"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="vehiculeModalContainer">
        <div class="flex justify-between items-center p-5 border-b">
            <h3 class="text-lg font-semibold" id="vehiculeModalTitle">Ajouter un véhicule</h3>
            <button class="closeVehiculeModalBtn text-gray-400 hover:text-gray-600">
                <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <div class="p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Modèle</label>
                <input type="text" id="vehiculeModele" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Ex: Toyota Land Cruiser">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Année</label>
                    <input type="number" id="vehiculeAnnee" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Prix (FCFA)</label>
                    <input type="number" id="vehiculePrix" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="vehiculeStatut" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                    <option value="disponible">🟢 Disponible</option>
                    <option value="vendue">🔵 Vendue</option>
                    <option value="reservee">🟡 Réservée</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="vehiculeDesc" rows="2" class="w-full px-3 py-2 border rounded-lg resize-none focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Kilométrage, motorisation, options..."></textarea>
            </div>
        </div>
        <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
            <button class="closeVehiculeModalBtn px-4 py-2 text-gray-600 bg-white border rounded-lg hover:bg-gray-50">Annuler</button>
            <button id="saveVehiculeBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
    </div>
</div>

<!-- MODAL Lead -->
<div id="leadModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" id="leadModalBackdrop"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="leadModalContainer">
        <div class="flex justify-between items-center p-5 border-b">
            <h3 class="text-lg font-semibold">Nouveau lead</h3>
            <button class="closeLeadModalBtn text-gray-400 hover:text-gray-600">
                <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <div class="p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nom complet</label>
                <input type="text" id="leadNom" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20" placeholder="Ex: Jean Koffi">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="email" id="leadEmail" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Téléphone</label>
                    <input type="tel" id="leadPhone" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Intérêt</label>
                <select id="leadInteret" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                    <option value="Véhicule">🚗 Achat véhicule</option>
                    <option value="Équipement">🏭 Équipement industriel</option>
                    <option value="Partenariat">🤝 Partenariat</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="leadStatut" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                    <option value="nouveau">🆕 Nouveau</option>
                    <option value="contacte">📞 Contacté</option>
                    <option value="rdv">📅 RDV pris</option>
                    <option value="negociation">🤝 Négociation</option>
                    <option value="converti">🏆 Converti</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
            <button class="closeLeadModalBtn px-4 py-2 text-gray-600 bg-white border rounded-lg hover:bg-gray-50">Annuler</button>
            <button id="saveLeadBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
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
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Données simulateur sourcing
    let vehicules = JSON.parse(localStorage.getItem('sourcing_vehicules') || JSON.stringify([
        { id: 1, modele: "Toyota Land Cruiser V8", annee: 2023, prix: 85000000, statut: "disponible", description: "4x4 tout-terrain, 8 places, 4.5L" },
        { id: 2, modele: "Kia Cerato", annee: 2024, prix: 18500000, statut: "vendue", description: "Berline, essence, boîte automatique" },
        { id: 3, modele: "Haval H6", annee: 2024, prix: 22500000, statut: "disponible", description: "SUV, hybride, toit panoramique" },
        { id: 4, modele: "Mercedes Classe G", annee: 2022, prix: 145000000, statut: "reservee", description: "Edition speciale" }
    ]));

    let leads = JSON.parse(localStorage.getItem('sourcing_leads') || JSON.stringify([
        { id: 1, nom: "Koffi Jean", email: "koffi@email.com", phone: "+225 07 89 01 23", interet: "Véhicule", statut: "negociation" },
        { id: 2, nom: "Aïssata Diallo", email: "aissata@email.com", phone: "+225 05 67 89 01", interet: "Véhicule", statut: "contacte" },
        { id: 3, nom: "Société Générale", email: "contact@sogeci.com", phone: "+225 20 30 40 50", interet: "Équipement", statut: "converti" }
    ]));

    // Stats CA mensuel (simulation)
    const caData = { 2025: [85, 92, 78, 105, 112, 98, 125, 130, 118, 142, 138, 155], 2026: [98, 112, 125] };
    let currentYear = 2026;
    let currentEditVehiculeId = null;
    let currentEditLeadId = null;
    let caChart = null;

    function formatNumber(n) {
        return n.toLocaleString('fr-FR');
    }

    function formatPrix(p) {
        return p.toLocaleString('fr-FR') + ' FCFA';
    }

    function updateStats() {
        const totalVehicules = vehicules.length;
        const vehiculesVendus = vehicules.filter(v => v.statut === 'vendue').length;
        const totalLeads = leads.length;
        const leadsConvertis = leads.filter(l => l.statut === 'converti').length;
        const tauxConversion = totalLeads > 0 ? Math.round((leadsConvertis / totalLeads) * 100) : 0;
        const caMensuel = caData[currentYear][new Date().getMonth()] || caData[currentYear][caData[currentYear].length-1];

        document.getElementById('totalVehicules').innerText = totalVehicules;
        document.getElementById('vehiculesVendus').innerText = vehiculesVendus;
        document.getElementById('totalLeads').innerText = totalLeads;
        document.getElementById('tauxConversion').innerText = tauxConversion;
        document.getElementById('caMois').innerText = formatNumber(caMensuel) + ' FCFA';
    }

    function escapeHtml(str) {
        if(!str) return '';
        return str.replace(/[&<>]/g, function(m) {
            if(m === '&') return '&amp;';
            if(m === '<') return '&lt;';
            if(m === '>') return '&gt;';
            return m;
        });
    }

    function renderVehicules() {
        const tbody = document.getElementById('vehiculesTableBody');
        const empty = document.getElementById('emptyVehicules');

        if(vehicules.length === 0) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            updateStats();
            return;
        }

        empty.classList.add('hidden');
        const statusMap = { disponible: '🟢 Disponible', vendue: '🔵 Vendue', reservee: '🟡 Réservée' };
        const statusClass = {
            disponible: 'bg-emerald-100 text-emerald-700',
            vendue: 'bg-blue-100 text-blue-700',
            reservee: 'bg-amber-100 text-amber-700'
        };

        tbody.innerHTML = vehicules.map(v => `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 font-medium">
                    ${escapeHtml(v.modele)}
                    <div class="text-xs text-gray-400">${escapeHtml(v.description?.substring(0,50)||'')}</div>
                </td>
                <td class="px-4 py-3">${v.annee}</td>
                <td class="px-4 py-3 text-emerald-600 font-medium">${formatPrix(v.prix)}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs ${statusClass[v.statut]}">${statusMap[v.statut]}</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-1">
                        <button onclick="editVehicule(${v.id})" class="text-blue-500 hover:bg-blue-50 p-1 rounded transition-colors">
                            <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                        </button>
                        <button onclick="deleteVehicule(${v.id})" class="text-rose-500 hover:bg-rose-50 p-1 rounded transition-colors">
                            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
        updateStats();
    }

    function renderLeads() {
        const tbody = document.getElementById('leadsTableBody');
        const empty = document.getElementById('emptyLeads');

        if(leads.length === 0) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');
        const statusMap = {
            nouveau: '🆕 Nouveau',
            contacte: '📞 Contacté',
            rdv: '📅 RDV',
            negociation: '🤝 Négociation',
            converti: '🏆 Converti'
        };

        tbody.innerHTML = leads.map(l => `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-4 py-3 font-medium">${escapeHtml(l.nom)}</td>
                <td class="px-4 py-3">
                    <div>${escapeHtml(l.email)}</div>
                    <div class="text-xs text-gray-400">${escapeHtml(l.phone)}</div>
                </td>
                <td class="px-4 py-3">${l.interet}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-0.5 rounded-full text-xs bg-purple-100 text-purple-700">${statusMap[l.statut]}</span>
                </td>
                <td class="px-4 py-3 text-center">
                    <div class="flex justify-center gap-1">
                        <button onclick="editLead(${l.id})" class="text-blue-500 hover:bg-blue-50 p-1 rounded transition-colors">
                            <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                        </button>
                        <button onclick="deleteLead(${l.id})" class="text-rose-500 hover:bg-rose-50 p-1 rounded transition-colors">
                            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function editVehicule(id) {
        const v = vehicules.find(v => v.id === id);
        if(v) {
            currentEditVehiculeId = id;
            document.getElementById('vehiculeModalTitle').innerText = 'Modifier véhicule';
            document.getElementById('vehiculeModele').value = v.modele;
            document.getElementById('vehiculeAnnee').value = v.annee;
            document.getElementById('vehiculePrix').value = v.prix;
            document.getElementById('vehiculeStatut').value = v.statut;
            document.getElementById('vehiculeDesc').value = v.description || '';
            openModal('vehiculeModal', 'vehiculeModalContainer');
        }
    }

    function editLead(id) {
        const l = leads.find(l => l.id === id);
        if(l) {
            currentEditLeadId = id;
            document.getElementById('leadNom').value = l.nom;
            document.getElementById('leadEmail').value = l.email;
            document.getElementById('leadPhone').value = l.phone;
            document.getElementById('leadInteret').value = l.interet;
            document.getElementById('leadStatut').value = l.statut;
            openModal('leadModal', 'leadModalContainer');
        }
    }

    function deleteVehicule(id) {
        if(confirm('Supprimer ce véhicule ?')) {
            vehicules = vehicules.filter(v => v.id !== id);
            localStorage.setItem('sourcing_vehicules', JSON.stringify(vehicules));
            renderVehicules();
        }
    }

    function deleteLead(id) {
        if(confirm('Supprimer ce lead ?')) {
            leads = leads.filter(l => l.id !== id);
            localStorage.setItem('sourcing_leads', JSON.stringify(leads));
            renderLeads();
            updateStats();
        }
    }

    function saveVehicule() {
        const modele = document.getElementById('vehiculeModele').value.trim();
        if(!modele) { alert('Veuillez saisir un modèle'); return; }

        const annee = parseInt(document.getElementById('vehiculeAnnee').value);
        const prix = parseInt(document.getElementById('vehiculePrix').value);
        const statut = document.getElementById('vehiculeStatut').value;
        const description = document.getElementById('vehiculeDesc').value;

        if(currentEditVehiculeId) {
            const idx = vehicules.findIndex(v => v.id === currentEditVehiculeId);
            if(idx !== -1) {
                vehicules[idx] = { ...vehicules[idx], modele, annee, prix, statut, description };
            }
        } else {
            vehicules.push({ id: Date.now(), modele, annee, prix, statut, description });
        }

        localStorage.setItem('sourcing_vehicules', JSON.stringify(vehicules));
        renderVehicules();
        closeModal('vehiculeModal', 'vehiculeModalContainer');
    }

    function saveLead() {
        const nom = document.getElementById('leadNom').value.trim();
        if(!nom) { alert('Veuillez saisir un nom'); return; }

        const email = document.getElementById('leadEmail').value;
        const phone = document.getElementById('leadPhone').value;
        const interet = document.getElementById('leadInteret').value;
        const statut = document.getElementById('leadStatut').value;

        if(currentEditLeadId) {
            const idx = leads.findIndex(l => l.id === currentEditLeadId);
            if(idx !== -1) {
                leads[idx] = { ...leads[idx], nom, email, phone, interet, statut };
            }
        } else {
            leads.push({ id: Date.now(), nom, email, phone, interet, statut });
        }

        localStorage.setItem('sourcing_leads', JSON.stringify(leads));
        renderLeads();
        updateStats();
        closeModal('leadModal', 'leadModalContainer');
    }

    function openModal(modalId, containerId) {
        const modal = document.getElementById(modalId);
        const container = document.getElementById(containerId);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            container.classList.remove('scale-95', 'opacity-0');
            container.classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal(modalId, containerId) {
        const container = document.getElementById(containerId);
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            document.getElementById(modalId).classList.add('hidden');
            document.getElementById(modalId).classList.remove('flex');
            resetVehiculeForm();
            resetLeadForm();
        }, 200);
    }

    function resetVehiculeForm() {
        currentEditVehiculeId = null;
        document.getElementById('vehiculeModalTitle').innerText = 'Ajouter un véhicule';
        document.getElementById('vehiculeModele').value = '';
        document.getElementById('vehiculeAnnee').value = '';
        document.getElementById('vehiculePrix').value = '';
        document.getElementById('vehiculeStatut').value = 'disponible';
        document.getElementById('vehiculeDesc').value = '';
    }

    function resetLeadForm() {
        currentEditLeadId = null;
        document.getElementById('leadNom').value = '';
        document.getElementById('leadEmail').value = '';
        document.getElementById('leadPhone').value = '';
        document.getElementById('leadInteret').value = 'Véhicule';
        document.getElementById('leadStatut').value = 'nouveau';
    }

    function initChart() {
        const ctx = document.getElementById('caChart').getContext('2d');
        caChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{
                    label: 'CA (millions FCFA)',
                    data: caData[currentYear],
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59,130,246,0.05)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#3b82f6',
                    pointBorderColor: '#fff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { display: false },
                    tooltip: { callbacks: { label: (ctx) => `${ctx.raw} M FCFA` } }
                },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#e5e7eb' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    function updateChart() {
        if(caChart) {
            caChart.data.datasets[0].data = caData[currentYear];
            caChart.update();
        }
        updateStats();
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('yearSelect')?.addEventListener('change', (e) => {
            currentYear = parseInt(e.target.value);
            updateChart();
        });

        document.getElementById('openVehiculeModal')?.addEventListener('click', () => {
            resetVehiculeForm();
            openModal('vehiculeModal', 'vehiculeModalContainer');
        });

        document.getElementById('openLeadModal')?.addEventListener('click', () => {
            resetLeadForm();
            openModal('leadModal', 'leadModalContainer');
        });

        document.querySelectorAll('.closeVehiculeModalBtn').forEach(btn => {
            btn.addEventListener('click', () => closeModal('vehiculeModal', 'vehiculeModalContainer'));
        });

        document.querySelectorAll('.closeLeadModalBtn').forEach(btn => {
            btn.addEventListener('click', () => closeModal('leadModal', 'leadModalContainer'));
        });

        document.getElementById('vehiculeModalBackdrop')?.addEventListener('click', () => {
            closeModal('vehiculeModal', 'vehiculeModalContainer');
        });

        document.getElementById('leadModalBackdrop')?.addEventListener('click', () => {
            closeModal('leadModal', 'leadModalContainer');
        });

        document.getElementById('saveVehiculeBtn')?.addEventListener('click', saveVehicule);
        document.getElementById('saveLeadBtn')?.addEventListener('click', saveLead);

        renderVehicules();
        renderLeads();
        initChart();
        updateStats();
    });
</script>
@endpush
