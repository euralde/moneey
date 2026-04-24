@extends('layouts.app')

@section('title', 'Finance - AFRO\'PLUME')
@section('header-title', 'Finance & Comptabilité')

@section('content')
<div class="max-w-7xl mx-auto pb-20 space-y-8">
    <!-- Actions -->
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4">
        <div>
            <h2 class="text-xl font-semibold">Trésorerie</h2>
            <p class="text-sm text-gray-500">Suivi des flux financiers en temps réel</p>
        </div>
        <div class="flex space-x-3">
            <button id="newExpenseBtn" class="px-4 py-2 bg-white border text-rose-600 rounded-lg flex items-center shadow-sm text-xs hover:bg-rose-50 transition-all">
                <iconify-icon icon="solar:minus-circle-linear" class="mr-1.5 text-base"></iconify-icon>
                Nouvelle sortie
            </button>
            <button id="newIncomeBtn" class="px-4 py-2 bg-emerald-600 text-white rounded-lg flex items-center shadow-sm text-xs hover:bg-emerald-700 transition-all">
                <iconify-icon icon="solar:add-circle-linear" class="mr-1.5 text-base"></iconify-icon>
                Nouvelle entrée
            </button>
        </div>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-white p-5 rounded-lg border shadow-sm hover:shadow-md transition-shadow">
            <span class="text-xs font-medium text-gray-500">Total Entrées</span>
            <div class="mt-3">
                <span class="text-2xl font-semibold" id="totalIncomes">12 500 000 FCFA</span>
                <div class="text-emerald-600 text-xs mt-1 flex items-center">
                    <iconify-icon icon="solar:trend-up-linear" class="mr-1"></iconify-icon>
                    +12% ce mois
                </div>
            </div>
        </div>
        <div class="bg-white p-5 rounded-lg border shadow-sm hover:shadow-md transition-shadow">
            <span class="text-xs font-medium text-gray-500">Total Sorties</span>
            <div class="mt-3">
                <span class="text-2xl font-semibold" id="totalExpenses">8 200 000 FCFA</span>
                <div class="text-rose-600 text-xs mt-1 flex items-center">
                    <iconify-icon icon="solar:trend-down-linear" class="mr-1"></iconify-icon>
                    -5% ce mois
                </div>
            </div>
        </div>
        <div class="bg-blue-50/50 p-5 rounded-lg border border-blue-100 shadow-sm hover:shadow-md transition-shadow">
            <span class="text-xs font-medium text-blue-700">Solde Net</span>
            <div class="mt-3">
                <span class="text-2xl font-semibold text-blue-900" id="netBalance">4 300 000 FCFA</span>
                <div class="text-blue-600 text-xs mt-1">En caisse</div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="flex flex-wrap gap-3 items-center justify-between">
        <div class="flex gap-2">
            <select id="filterType" class="px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                <option value="all">Toutes les transactions</option>
                <option value="income">Entrées uniquement</option>
                <option value="expense">Sorties uniquement</option>
            </select>
            <select id="filterCategory" class="px-3 py-2 border rounded-lg text-sm focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 bg-white">
                <option value="all">Toutes catégories</option>
                <option value="Commercial">Commercial</option>
                <option value="Logistique">Logistique</option>
                <option value="Salaires">Salaires</option>
                <option value="Marketing">Marketing</option>
                <option value="Divers">Divers</option>
            </select>
        </div>
        <button id="exportBtn" class="text-gray-600 hover:text-blue-600 text-sm flex items-center gap-1">
            <iconify-icon icon="solar:export-linear" class="text-base"></iconify-icon>
            Exporter
        </button>
    </div>

    <!-- Transactions Table -->
    <div class="bg-white border rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left whitespace-nowrap">
                <thead class="bg-gray-50/80 border-b text-xs font-medium text-gray-500">
                    <tr>
                        <th class="py-3 px-5">Date</th>
                        <th class="py-3 px-5">Libellé</th>
                        <th class="py-3 px-5">Catégorie</th>
                        <th class="py-3 px-5 text-right">Montant</th>
                        <th class="py-3 px-5 text-center">Action</th>
                    </tr>
                </thead>
                <tbody id="transactionsTableBody" class="divide-y divide-gray-100 text-sm"></tbody>
            </table>
        </div>
        <div id="emptyTransactions" class="text-center py-12 hidden">
            <iconify-icon icon="solar:wallet-money-linear" class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
            <p class="text-gray-400">Aucune transaction trouvée</p>
        </div>
    </div>
</div>

<!-- Modal Transaction -->
<div id="transactionModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="modalContainer">
        <div class="flex justify-between items-center p-5 border-b">
            <h3 class="text-lg font-semibold" id="modalTitle">Nouvelle transaction</h3>
            <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600">
                <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <div class="p-5 space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <select id="transactionType" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                    <option value="income">💰 Entrée</option>
                    <option value="expense">💸 Sortie</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Libellé</label>
                <input type="text" id="transactionLabel" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20" placeholder="Ex: Vente produits">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                <select id="transactionCategory" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                    <option value="Commercial">Commercial</option>
                    <option value="Logistique">Logistique</option>
                    <option value="Salaires">Salaires</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Divers">Divers</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Montant (FCFA)</label>
                <input type="number" id="transactionAmount" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20" placeholder="0">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                <input type="date" id="transactionDate" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
            </div>
        </div>
        <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
            <button id="cancelModalBtn" class="px-4 py-2 text-gray-600 bg-white border rounded-lg hover:bg-gray-50">Annuler</button>
            <button id="saveTransactionBtn" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
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
    let transactions = JSON.parse(localStorage.getItem('afro_transactions') || JSON.stringify([
        { id: 1, date: '2026-03-12', label: 'Vente produits', category: 'Commercial', amount: 500000, type: 'income' },
        { id: 2, date: '2026-03-11', label: 'Achat matériel', category: 'Logistique', amount: 200000, type: 'expense' },
        { id: 3, date: '2026-03-10', label: 'Paiement salaires', category: 'Salaires', amount: 1500000, type: 'expense' },
        { id: 4, date: '2026-03-09', label: 'Campagne publicitaire', category: 'Marketing', amount: 300000, type: 'expense' },
        { id: 5, date: '2026-03-08', label: 'Vente prestations', category: 'Commercial', amount: 750000, type: 'income' },
    ]));

    let currentEditId = null;

    function formatDate(dateStr) {
        const date = new Date(dateStr);
        return date.toLocaleDateString('fr-FR');
    }

    function formatAmount(amount, type) {
        const formatted = amount.toLocaleString('fr-FR') + ' FCFA';
        return type === 'income' ? `+ ${formatted}` : `- ${formatted}`;
    }

    function updateStats() {
        const totalIncomes = transactions.filter(t => t.type === 'income').reduce((sum, t) => sum + t.amount, 0);
        const totalExpenses = transactions.filter(t => t.type === 'expense').reduce((sum, t) => sum + t.amount, 0);
        const netBalance = totalIncomes - totalExpenses;

        document.getElementById('totalIncomes').innerHTML = `${totalIncomes.toLocaleString('fr-FR')} FCFA`;
        document.getElementById('totalExpenses').innerHTML = `${totalExpenses.toLocaleString('fr-FR')} FCFA`;
        document.getElementById('netBalance').innerHTML = `${netBalance.toLocaleString('fr-FR')} FCFA`;
    }

    function renderTransactions() {
        const filterType = document.getElementById('filterType')?.value || 'all';
        const filterCategory = document.getElementById('filterCategory')?.value || 'all';

        let filtered = [...transactions];

        if (filterType !== 'all') {
            filtered = filtered.filter(t => t.type === filterType);
        }

        if (filterCategory !== 'all') {
            filtered = filtered.filter(t => t.category === filterCategory);
        }

        filtered.sort((a, b) => new Date(b.date) - new Date(a.date));

        const tbody = document.getElementById('transactionsTableBody');
        const empty = document.getElementById('emptyTransactions');

        if(filtered.length === 0) {
            tbody.innerHTML = '';
            empty.classList.remove('hidden');
            updateStats();
            return;
        }

        empty.classList.add('hidden');
        tbody.innerHTML = filtered.map(t => `
            <tr class="hover:bg-gray-50 transition">
                <td class="py-3 px-5 text-gray-500">${formatDate(t.date)}</td>
                <td class="py-3 px-5 font-medium">${escapeHtml(t.label)}</td>
                <td class="py-3 px-5">
                    <span class="px-2 py-0.5 rounded text-xs bg-gray-100">${escapeHtml(t.category)}</span>
                </td>
                <td class="py-3 px-5 text-right ${t.type === 'income' ? 'text-emerald-600' : 'text-rose-600'}">
                    ${formatAmount(t.amount, t.type)}
                </td>
                <td class="py-3 px-5 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <button onclick="editTransaction(${t.id})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded">
                            <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                        </button>
                        <button onclick="deleteTransaction(${t.id})" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded">
                            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                        </button>
                        <button onclick="downloadPDF(${t.id})" class="text-gray-400 hover:text-blue-600 p-1.5 rounded">
                            <iconify-icon icon="solar:file-pdf-linear" class="text-base"></iconify-icon>
                        </button>
                    </div>
                </td>
            </tr>
        `).join('');

        updateStats();
    }

    function escapeHtml(text) {
        if(!text) return '';
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }

    function saveTransactions() {
        localStorage.setItem('afro_transactions', JSON.stringify(transactions));
        renderTransactions();
    }

    function editTransaction(id) {
        const transaction = transactions.find(t => t.id === id);
        if(transaction) {
            currentEditId = id;
            document.getElementById('modalTitle').innerText = 'Modifier la transaction';
            document.getElementById('transactionType').value = transaction.type;
            document.getElementById('transactionLabel').value = transaction.label;
            document.getElementById('transactionCategory').value = transaction.category;
            document.getElementById('transactionAmount').value = transaction.amount;
            document.getElementById('transactionDate').value = transaction.date;
            openModal();

            // Style selon le type
            const typeSelect = document.getElementById('transactionType');
            if(transaction.type === 'income') {
                typeSelect.style.borderColor = '#10b981';
            } else {
                typeSelect.style.borderColor = '#e11d48';
            }
        }
    }

    function deleteTransaction(id) {
        if(confirm('Supprimer cette transaction ?')) {
            transactions = transactions.filter(t => t.id !== id);
            saveTransactions();
        }
    }

    function downloadPDF(id) {
        const transaction = transactions.find(t => t.id === id);
        if(transaction) {
            alert(`Téléchargement du PDF pour : ${transaction.label}\nMontant: ${formatAmount(transaction.amount, transaction.type)}`);
            // Implémenter la génération PDF ici
        }
    }

    function openModal() {
        const modal = document.getElementById('transactionModal');
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
            document.getElementById('transactionModal').classList.add('hidden');
            document.getElementById('transactionModal').classList.remove('flex');
            resetModal();
        }, 200);
    }

    function resetModal() {
        currentEditId = null;
        document.getElementById('modalTitle').innerText = 'Nouvelle transaction';
        document.getElementById('transactionType').value = 'income';
        document.getElementById('transactionLabel').value = '';
        document.getElementById('transactionCategory').value = 'Commercial';
        document.getElementById('transactionAmount').value = '';
        document.getElementById('transactionDate').value = new Date().toISOString().split('T')[0];
        document.getElementById('transactionType').style.borderColor = '';
    }

    function saveTransaction() {
        const type = document.getElementById('transactionType').value;
        const label = document.getElementById('transactionLabel').value.trim();
        const category = document.getElementById('transactionCategory').value;
        const amount = parseInt(document.getElementById('transactionAmount').value);
        const date = document.getElementById('transactionDate').value;

        if(!label) {
            alert('Veuillez saisir un libellé');
            return;
        }

        if(isNaN(amount) || amount <= 0) {
            alert('Veuillez saisir un montant valide');
            return;
        }

        if(!date) {
            alert('Veuillez sélectionner une date');
            return;
        }

        if(currentEditId) {
            const index = transactions.findIndex(t => t.id === currentEditId);
            if(index !== -1) {
                transactions[index] = { ...transactions[index], type, label, category, amount, date };
            }
        } else {
            transactions.push({
                id: Date.now(),
                date,
                label,
                category,
                amount,
                type
            });
        }

        saveTransactions();
        closeModal();
    }

    // Event Listeners
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('newIncomeBtn')?.addEventListener('click', () => {
            resetModal();
            document.getElementById('transactionType').value = 'income';
            openModal();
        });

        document.getElementById('newExpenseBtn')?.addEventListener('click', () => {
            resetModal();
            document.getElementById('transactionType').value = 'expense';
            openModal();
        });

        document.getElementById('closeModalBtn')?.addEventListener('click', closeModal);
        document.getElementById('cancelModalBtn')?.addEventListener('click', closeModal);
        document.getElementById('modalBackdrop')?.addEventListener('click', closeModal);
        document.getElementById('saveTransactionBtn')?.addEventListener('click', saveTransaction);
        document.getElementById('filterType')?.addEventListener('change', renderTransactions);
        document.getElementById('filterCategory')?.addEventListener('change', renderTransactions);

        document.getElementById('exportBtn')?.addEventListener('click', () => {
            const dataStr = JSON.stringify(transactions, null, 2);
            const dataUri = 'data:application/json;charset=utf-8,'+ encodeURIComponent(dataStr);
            const exportFileDefaultName = `transactions_${new Date().toISOString().split('T')[0]}.json`;
            const linkElement = document.createElement('a');
            linkElement.setAttribute('href', dataUri);
            linkElement.setAttribute('download', exportFileDefaultName);
            linkElement.click();
        });

        // Style du select type au changement
        document.getElementById('transactionType')?.addEventListener('change', (e) => {
            if(e.target.value === 'income') {
                e.target.style.borderColor = '#10b981';
            } else {
                e.target.style.borderColor = '#e11d48';
            }
        });

        renderTransactions();
    });
</script>
@endpush
