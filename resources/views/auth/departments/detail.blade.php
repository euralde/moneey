@extends('layouts.app')

@section('title', 'Service Sourcing - AFRO\'PLUME')
@section('header-title', 'Service Sourcing')
@section('header-subtitle', 'Importation de véhicules et équipements')

@section('content')
<!-- TON HTML EXISTANT RESTE IDENTIQUE -->
<!-- Je ne le réécris pas ici pour gagner de la place -->
<!-- Mais tu gardes EXACTEMENT ton HTML (les cartes, tableaux, modals) -->
<!-- Seul le JavaScript change -->
@endsection

@push('styles')
<style> /* ton style reste identique */ </style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Version avec enregistrement en base de données
    let vehicules = [];
    let leads = [];
    let currentYear = 2026;
    let currentEditVehiculeId = null;
    let currentEditLeadId = null;
    let caChart = null;
    const caData = { 2025: [85, 92, 78, 105, 112, 98, 125, 130, 118, 142, 138, 155], 2026: [98, 112, 125] };

    async function fetchVehicules() {
        const res = await fetch('/api/vehicules');
        vehicules = await res.json();
        renderVehicules();
        updateStats();
    }

    async function fetchLeads() {
        const res = await fetch('/api/leads');
        leads = await res.json();
        renderLeads();
        updateStats();
    }

    async function saveVehicule(data) {
        let url = '/api/vehicules';
        let method = 'POST';
        if (currentEditVehiculeId) {
            url = `/api/vehicules/${currentEditVehiculeId}`;
            method = 'PUT';
        }
        await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        await fetchVehicules();
    }

    async function saveLead(data) {
        let url = '/api/leads';
        let method = 'POST';
        if (currentEditLeadId) {
            url = `/api/leads/${currentEditLeadId}`;
            method = 'PUT';
        }
        await fetch(url, {
            method: method,
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        await fetchLeads();
    }

    async function deleteVehiculeFromDB(id) {
        await fetch(`/api/vehicules/${id}`, { method: 'DELETE' });
        await fetchVehicules();
    }

    async function deleteLeadFromDB(id) {
        await fetch(`/api/leads/${id}`, { method: 'DELETE' });
        await fetchLeads();
    }

    function updateStats() {
        const totalVehicules = vehicules.length;
        const vehiculesVendus = vehicules.filter(v => v.statut === 'vendue').length;
        const totalLeads = leads.length;
        const leadsConvertis = leads.filter(l => l.statut === 'converti').length;
        const tauxConversion = totalLeads > 0 ? Math.round((leadsConvertis / totalLeads) * 100) : 0;
        const caMensuel = caData[currentYear][new Date().getMonth()] || caData[currentYear][caData[currentYear].length-1];

        document.getElementById('caMois').innerText = caMensuel.toLocaleString('fr-FR') + ' FCFA';
        document.getElementById('totalVehicules').innerText = totalVehicules;
        document.getElementById('vehiculesVendus').innerText = vehiculesVendus;
        document.getElementById('totalLeads').innerText = totalLeads;
        document.getElementById('tauxConversion').innerText = tauxConversion;
    }

    function renderVehicules() {
        const tbody = document.getElementById('vehiculesTableBody');
        const empty = document.getElementById('emptyVehicules');
        if (!vehicules.length) {
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
            <tr>
                <td class="px-4 py-3">${v.modele}<div class="text-xs text-gray-400">${v.description || ''}</div></td>
                <td class="px-4 py-3">${v.annee}</td>
                <td class="px-4 py-3">${v.prix.toLocaleString('fr-FR')} FCFA</td>
                <td class="px-4 py-3"><span class="px-2 py-0.5 rounded-full text-xs ${statusClass[v.statut]}">${statusMap[v.statut]}</span></td>
                <td class="px-4 py-3 text-center">
                    <button onclick="editVehicule(${v.id})" class="text-blue-500">✏️</button>
                    <button onclick="deleteVehicule(${v.id})" class="text-rose-500">🗑️</button>
                </td>
            </tr>
        `).join('');
        updateStats();
    }

    function renderLeads() {
        const tbody = document.getElementById('leadsTableBody');
        const empty = document.getElementById('emptyLeads');
        if (!leads.length) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }
        empty.classList.add('hidden');
        const statusMap = { nouveau: '🆕 Nouveau', contacte: '📞 Contacté', rdv: '📅 RDV', negociation: '🤝 Négociation', converti: '🏆 Converti' };
        tbody.innerHTML = leads.map(l => `
            <tr>
                <td class="px-4 py-3">${l.nom}</td>
                <td class="px-4 py-3">${l.email}<br><small>${l.phone}</small></td>
                <td class="px-4 py-3">${l.interet}</td>
                <td class="px-4 py-3">${statusMap[l.statut]}</td>
                <td class="px-4 py-3 text-center">
                    <button onclick="editLead(${l.id})" class="text-blue-500">✏️</button>
                    <button onclick="deleteLead(${l.id})" class="text-rose-500">🗑️</button>
                </td>
            </tr>
        `).join('');
    }

    window.editVehicule = (id) => {
        const v = vehicules.find(v => v.id === id);
        if (v) {
            currentEditVehiculeId = id;
            openModal('vehiculeModal');
            document.getElementById('vehiculeModele').value = v.modele;
            document.getElementById('vehiculeAnnee').value = v.annee;
            document.getElementById('vehiculePrix').value = v.prix;
            document.getElementById('vehiculeStatut').value = v.statut;
            document.getElementById('vehiculeDesc').value = v.description;
        }
    };

    window.deleteVehicule = async (id) => {
        if (confirm('Supprimer ce véhicule ?')) await deleteVehiculeFromDB(id);
    };

    window.editLead = (id) => {
        const l = leads.find(l => l.id === id);
        if (l) {
            currentEditLeadId = id;
            openModal('leadModal');
            document.getElementById('leadNom').value = l.nom;
            document.getElementById('leadEmail').value = l.email;
            document.getElementById('leadPhone').value = l.phone;
            document.getElementById('leadInteret').value = l.interet;
            document.getElementById('leadStatut').value = l.statut;
        }
    };

    window.deleteLead = async (id) => {
        if (confirm('Supprimer ce lead ?')) await deleteLeadFromDB(id);
    };

    document.getElementById('saveVehiculeBtn').onclick = async () => {
        const data = {
            modele: document.getElementById('vehiculeModele').value,
            annee: document.getElementById('vehiculeAnnee').value,
            prix: document.getElementById('vehiculePrix').value,
            statut: document.getElementById('vehiculeStatut').value,
            description: document.getElementById('vehiculeDesc').value
        };
        await saveVehicule(data);
        closeModal('vehiculeModal');
    };

    document.getElementById('saveLeadBtn').onclick = async () => {
        const data = {
            nom: document.getElementById('leadNom').value,
            email: document.getElementById('leadEmail').value,
            phone: document.getElementById('leadPhone').value,
            interet: document.getElementById('leadInteret').value,
            statut: document.getElementById('leadStatut').value
        };
        await saveLead(data);
        closeModal('leadModal');
    };

    function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
    function closeModal(id) { document.getElementById(id).classList.add('hidden'); currentEditVehiculeId = null; currentEditLeadId = null; }

    document.getElementById('openVehiculeModal').onclick = () => { currentEditVehiculeId = null; openModal('vehiculeModal'); };
    document.getElementById('openLeadModal').onclick = () => { currentEditLeadId = null; openModal('leadModal'); };
    document.querySelectorAll('.closeVehiculeModalBtn, .closeLeadModalBtn').forEach(btn => {
        btn.onclick = () => closeModal(btn.closest('.fixed').id);
    });

    document.addEventListener('DOMContentLoaded', () => {
        fetchVehicules();
        fetchLeads();
        initChart();
    });

    function initChart() {
        const ctx = document.getElementById('caChart').getContext('2d');
        caChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Juin', 'Juil', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                datasets: [{ label: 'CA (millions FCFA)', data: caData[currentYear], borderColor: '#3b82f6', tension: 0.3, fill: true }]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });
    }

    document.getElementById('yearSelect').onchange = (e) => {
        currentYear = parseInt(e.target.value);
        if (caChart) caChart.data.datasets[0].data = caData[currentYear];
        caChart.update();
        updateStats();
    };
</script>
@endpush