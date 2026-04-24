@extends('layouts.app')

@section('title', 'Services IT - AFRO\'PLUME')
@section('header-title', 'Services & Infrastructures')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Liste des services</h2>
            <p class="text-sm text-gray-500 mt-0.5">Gérez vos services et leur statut</p>
        </div>
        <button id="openServiceModal" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all shadow-sm">
            <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
            Ajouter un service
        </button>
    </div>

    <!-- Datatable -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Titre</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody id="servicesTableBody" class="divide-y divide-gray-100 text-sm"></tbody>
            </table>
        </div>
        <div id="emptyServices" class="text-center py-12 hidden">
            <iconify-icon icon="solar:server-square-linear" class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
            <p class="text-gray-400">Aucun service</p>
        </div>
    </div>
</div>

<!-- Modal Service -->
<div id="serviceModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="modalContainer">
        <div class="flex justify-between items-center p-5 border-b">
            <h3 class="text-lg font-semibold" id="modalTitle">Ajouter un service</h3>
            <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <div class="p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                <input type="text" id="serviceTitle" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Nom du service">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="serviceDesc" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none" placeholder="Description du service"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="serviceStatus" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                    <option value="active">✅ Actif</option>
                    <option value="inactive">⭕ Inactif</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
            <button id="cancelModalBtn" class="px-4 py-2 text-gray-600 bg-white border rounded-lg hover:bg-gray-50">Annuler</button>
            <button id="saveServiceBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
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

@push('scripts')
<script>
    let services = JSON.parse(localStorage.getItem('afro_services') || '[{"id":1,"title":"Serveur Web API","description":"Hébergement principal de l\'application","status":"active"},{"id":2,"title":"Base de données MySQL","description":"Base de production","status":"active"},{"id":3,"title":"Service de Backup","description":"Sauvegarde automatique quotidienne","status":"inactive"}]');
    let currentEditId = null;

    function saveServices() {
        localStorage.setItem('afro_services', JSON.stringify(services));
        renderServices();
    }

    function renderServices() {
        const tbody = document.getElementById('servicesTableBody');
        const empty = document.getElementById('emptyServices');

        if(services.length === 0) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            return;
        }

        empty.classList.add('hidden');
        tbody.innerHTML = services.map(s => `
            <tr class="hover:bg-gray-50 transition">
                <td class="px-6 py-4 font-medium text-gray-900">${escapeHtml(s.title)}</td>
                <td class="px-6 py-4 text-gray-500 max-w-xs truncate">${escapeHtml(s.description)}</td>
                <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium ${s.status === 'active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-500'}">
                        ${s.status === 'active' ? 'Actif' : 'Inactif'}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="editService(${s.id})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded">
                            <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                        </button>
                        <button onclick="deleteService(${s.id})" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded">
                            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');
    }

    function escapeHtml(text) {
        if(!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function editService(id) {
        const service = services.find(s => s.id === id);
        if(service) {
            currentEditId = id;
            document.getElementById('modalTitle').innerText = 'Modifier le service';
            document.getElementById('serviceTitle').value = service.title;
            document.getElementById('serviceDesc').value = service.description;
            document.getElementById('serviceStatus').value = service.status;
            openModal();
        }
    }

    function deleteService(id) {
        if(confirm('Supprimer ce service ?')) {
            services = services.filter(s => s.id !== id);
            saveServices();
        }
    }

    function openModal() {
        const modal = document.getElementById('serviceModal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        setTimeout(() => {
            document.getElementById('modalContainer').classList.remove('scale-95', 'opacity-0');
            document.getElementById('modalContainer').classList.add('scale-100', 'opacity-100');
        }, 10);
    }

    function closeModal() {
        const container = document.getElementById('modalContainer');
        container.classList.remove('scale-100', 'opacity-100');
        container.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            document.getElementById('serviceModal').classList.add('hidden');
            document.getElementById('serviceModal').classList.remove('flex');
            resetModal();
        }, 200);
    }

    function resetModal() {
        currentEditId = null;
        document.getElementById('serviceTitle').value = '';
        document.getElementById('serviceDesc').value = '';
        document.getElementById('serviceStatus').value = 'active';
        document.getElementById('modalTitle').innerText = 'Ajouter un service';
    }

    function saveService() {
        const title = document.getElementById('serviceTitle').value.trim();
        const description = document.getElementById('serviceDesc').value.trim();
        const status = document.getElementById('serviceStatus').value;

        if(!title) {
            alert('Veuillez saisir un titre');
            return;
        }

        if(currentEditId) {
            const index = services.findIndex(s => s.id === currentEditId);
            if(index !== -1) {
                services[index] = { ...services[index], title, description, status };
            }
        } else {
            services.push({
                id: Date.now(),
                title,
                description,
                status
            });
        }

        saveServices();
        closeModal();
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('openServiceModal')?.addEventListener('click', () => {
            resetModal();
            openModal();
        });

        document.getElementById('closeModalBtn')?.addEventListener('click', closeModal);
        document.getElementById('cancelModalBtn')?.addEventListener('click', closeModal);
        document.getElementById('modalBackdrop')?.addEventListener('click', closeModal);
        document.getElementById('saveServiceBtn')?.addEventListener('click', saveService);

        renderServices();
    });
</script>
@endpush
