{{-- resources/views/transactions/index.blade.php --}}
@extends('layouts.app') {{-- Adaptez selon le nom de votre layout --}}

@section('content')
    <div class="max-w-7xl mx-auto pb-20">

        <!-- Cartes récapitulatives -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
            <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-emerald-100 text-xs font-medium uppercase tracking-wider">Total entrées</p>
                        <p class="text-3xl font-bold mt-2" id="totalIncomes">0 FCFA</p>
                    </div>
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <iconify-icon icon="solar:wallet-money-linear" class="text-2xl"></iconify-icon>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-rose-500 to-rose-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-rose-100 text-xs font-medium uppercase tracking-wider">Total sorties</p>
                        <p class="text-3xl font-bold mt-2" id="totalOutcomes">0 FCFA</p>
                    </div>
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <iconify-icon icon="solar:cart-large-minimalistic-linear" class="text-2xl"></iconify-icon>
                    </div>
                </div>
            </div>
            <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-xl p-5 text-white shadow-lg">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="text-blue-100 text-xs font-medium uppercase tracking-wider">Solde net</p>
                        <p class="text-3xl font-bold mt-2" id="netBalance">0 FCFA</p>
                    </div>
                    <div class="w-10 h-10 bg-white/20 rounded-full flex items-center justify-center">
                        <iconify-icon icon="solar:card-linear" class="text-2xl"></iconify-icon>
                    </div>
                </div>
            </div>
        </div>

        <!-- Filtres et bouton ajout -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
            <div class="flex flex-wrap gap-3">
                <select id="typeFilter"
                    class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-blue-500/20">
                    <option value="all">Tous les types</option>
                    <option value="entree">Entrées</option>
                    <option value="sortie">Sorties</option>
                </select>
                <select id="categoryFilter"
                    class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white focus:ring-2 focus:ring-blue-500/20">
                    <option value="all">Toutes catégories</option>
                    <option value="Commercial">💰 Commercial</option>
                    <option value="Logistique">📦 Logistique</option>
                    <option value="Salaires">👥 Salaires</option>
                    <option value="Marketing">📢 Marketing</option>
                    <option value="Autre">🔧 Autre</option>
                </select>
                <button id="resetFilters"
                    class="px-3 py-2 text-gray-500 hover:text-gray-700 border border-gray-200 rounded-lg">
                    <iconify-icon icon="solar:refresh-linear" class="text-base"></iconify-icon>
                </button>
            </div>
            <div class="flex gap-3">
                <button id="openIncomeModal"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all shadow-sm">
                    <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                    Nouvelle entrée
                </button>
                <button id="openExpenseModal"
                    class="inline-flex items-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-medium transition-all shadow-sm">
                    <iconify-icon icon="solar:minus-circle-linear" class="text-lg"></iconify-icon>
                    Nouvelle sortie
                </button>
            </div>
        </div>

        <!-- Datatable -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Libellé</th>
                            <th class="px-6 py-4">Catégorie</th>
                            <th class="px-6 py-4 text-right">Montant</th>
                            <th class="px-6 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="transactionsTableBody" class="divide-y divide-gray-100"></tbody>
                </table>
            </div>
            <div id="emptyTransactions" class="text-center py-12 hidden">
                <iconify-icon icon="solar:wallet-linear" class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
                <p class="text-gray-400">Aucune transaction enregistrée</p>
                <p class="text-gray-300 text-xs mt-1">Cliquez sur "Nouvelle entrée" ou "Nouvelle sortie" pour commencer</p>
            </div>
        </div>
    </div>

    <!-- MODAL Transaction (Entrée ou Sortie) -->
    <div id="transactionModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
        <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
        <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0"
            id="modalContainer">
            <div class="flex justify-between items-center p-5 border-b border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Nouvelle transaction</h3>
                <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" id="transactionDate"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Libellé</label>
                    <input type="text" id="transactionLabel"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Ex: Vente de produits, Achat fournitures...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Catégorie</label>
                    <select id="transactionCategory"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20">
                        <option value="Commercial">💰 Commercial</option>
                        <option value="Logistique">📦 Logistique</option>
                        <option value="Salaires">👥 Salaires</option>
                        <option value="Marketing">📢 Marketing</option>
                        <option value="Autre">🔧 Autre</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Montant (FCFA)</label>
                    <input type="number" id="transactionAmount"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        placeholder="0">
                </div>
                <div id="typeIndicator" class="text-xs font-medium p-2 rounded-lg text-center"></div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">
                <button id="cancelModalBtn"
                    class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">Annuler</button>
                <button id="saveTransactionBtn"
                    class="px-4 py-2 rounded-lg text-white font-medium transition-colors shadow-sm">Enregistrer</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Données initiales
            let transactions = JSON.parse(localStorage.getItem('afro_transactions') || JSON.stringify([
                { id: 1, date: '2026-03-12', label: 'Vente produits', category: 'Commercial', amount: 500000, type: 'entree' },
                { id: 2, date: '2026-03-11', label: 'Achat matériel', category: 'Logistique', amount: 200000, type: 'sortie' },
                { id: 3, date: '2026-03-10', label: 'Paiement salaires', category: 'Salaires', amount: 1500000, type: 'sortie' },
                { id: 4, date: '2026-03-09', label: 'Campagne publicitaire', category: 'Marketing', amount: 300000, type: 'sortie' },
                { id: 5, date: '2026-03-08', label: 'Vente prestation', category: 'Commercial', amount: 250000, type: 'entree' }
            ]));

            let currentTransactionType = 'entree'; // 'entree' ou 'sortie'
            let currentEditId = null;

            // Éléments DOM
            const tbody = document.getElementById('transactionsTableBody');
            const emptyDiv = document.getElementById('emptyTransactions');
            const totalIncomesSpan = document.getElementById('totalIncomes');
            const totalOutcomesSpan = document.getElementById('totalOutcomes');
            const netBalanceSpan = document.getElementById('netBalance');
            const typeFilter = document.getElementById('typeFilter');
            const categoryFilter = document.getElementById('categoryFilter');
            const resetFiltersBtn = document.getElementById('resetFilters');

            // Modal elements
            const modal = document.getElementById('transactionModal');
            const modalContainer = document.getElementById('modalContainer');
            const modalTitle = document.getElementById('modalTitle');
            const transactionDate = document.getElementById('transactionDate');
            const transactionLabel = document.getElementById('transactionLabel');
            const transactionCategory = document.getElementById('transactionCategory');
            const transactionAmount = document.getElementById('transactionAmount');
            const typeIndicator = document.getElementById('typeIndicator');
            const saveBtn = document.getElementById('saveTransactionBtn');

            // Helper functions
            function formatNumber(n) { return n.toLocaleString('fr-FR'); }

            function updateStats() {
                const totalIn = transactions.filter(t => t.type === 'entree').reduce((sum, t) => sum + t.amount, 0);
                const totalOut = transactions.filter(t => t.type === 'sortie').reduce((sum, t) => sum + t.amount, 0);
                totalIncomesSpan.innerText = formatNumber(totalIn) + ' FCFA';
                totalOutcomesSpan.innerText = formatNumber(totalOut) + ' FCFA';
                netBalanceSpan.innerText = formatNumber(totalIn - totalOut) + ' FCFA';
            }

            function saveToLocal() { localStorage.setItem('afro_transactions', JSON.stringify(transactions)); }

            function renderTransactions() {
                let filtered = [...transactions];
                const typeVal = typeFilter.value;
                const catVal = categoryFilter.value;
                if (typeVal !== 'all') filtered = filtered.filter(t => t.type === typeVal);
                if (catVal !== 'all') filtered = filtered.filter(t => t.category === catVal);
                filtered.sort((a, b) => new Date(b.date) - new Date(a.date));

                if (filtered.length === 0) {
                    tbody.innerHTML = '';
                    emptyDiv.classList.remove('hidden');
                    updateStats();
                    return;
                }
                emptyDiv.classList.add('hidden');
                tbody.innerHTML = filtered.map(t => `
                                            <tr class="hover:bg-gray-50 transition-colors transaction-enter">
                                                <td class="px-6 py-4 text-gray-500 whitespace-nowrap">${new Date(t.date).toLocaleDateString('fr-FR')}</td>
                                                <td class="px-6 py-4 font-medium text-gray-900">${escapeHtml(t.label)}</td>
                                                <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">${escapeHtml(t.category)}</span></td>
                                                <td class="px-6 py-4 text-right font-semibold ${t.type === 'entree' ? 'text-emerald-600' : 'text-rose-600'}">${t.type === 'entree' ? '+' : '-'} ${formatNumber(t.amount)} FCFA</td>
                                                <td class="px-6 py-4 text-center">
                                                    <div class="flex items-center justify-center gap-2">
                                                        <button onclick="editTransaction(${t.id})" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded transition-colors">
                                                            <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                                                        </button>
                                                        <button onclick="deleteTransaction(${t.id})" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded transition-colors">
                                                            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        `).join('');
                updateStats();
            }

            function escapeHtml(str) { if (!str) return ''; return str.replace(/[&<>]/g, function (m) { if (m === '&') return '&amp;'; if (m === '<') return '&lt;'; if (m === '>') return '&gt;'; return m; }); }

            // CRUD Operations
            function editTransaction(id) {
                const t = transactions.find(t => t.id === id);
                if (t) {
                    currentEditId = id;
                    currentTransactionType = t.type;
                    transactionDate.value = t.date;
                    transactionLabel.value = t.label;
                    transactionCategory.value = t.category;
                    transactionAmount.value = t.amount;
                    updateModalUI();
                    openModal();
                }
            }

            function deleteTransaction(id) {
                if (confirm('Supprimer cette transaction ?')) {
                    transactions = transactions.filter(t => t.id !== id);
                    saveToLocal();
                    renderTransactions();
                }
            }

            // Modal UI
            function updateModalUI() {
                if (currentTransactionType === 'entree') {
                    modalTitle.innerText = currentEditId ? 'Modifier une entrée' : 'Nouvelle entrée';
                    typeIndicator.innerHTML = '🟢 Type: ENTRÉE (revenu)';
                    typeIndicator.className = 'text-xs font-medium p-2 rounded-lg text-center bg-emerald-50 text-emerald-700';
                    saveBtn.className = 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors shadow-sm';
                } else {
                    modalTitle.innerText = currentEditId ? 'Modifier une sortie' : 'Nouvelle sortie';
                    typeIndicator.innerHTML = '🔴 Type: SORTIE (dépense)';
                    typeIndicator.className = 'text-xs font-medium p-2 rounded-lg text-center bg-rose-50 text-rose-700';
                    saveBtn.className = 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-medium transition-colors shadow-sm';
                }
            }

            function openModal() {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    modalContainer.classList.remove('scale-95', 'opacity-0');
                    modalContainer.classList.add('scale-100', 'opacity-100');
                }, 10);
            }

            function closeModal() {
                modalContainer.classList.remove('scale-100', 'opacity-100');
                modalContainer.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    currentEditId = null;
                    transactionDate.value = new Date().toISOString().split('T')[0];
                    transactionLabel.value = '';
                    transactionCategory.value = 'Commercial';
                    transactionAmount.value = '';
                }, 200);
            }

            function saveTransaction() {
                const date = transactionDate.value;
                const label = transactionLabel.value.trim();
                const category = transactionCategory.value;
                const amount = parseFloat(transactionAmount.value);

                if (!date) { alert('Veuillez sélectionner une date'); return; }
                if (!label) { alert('Veuillez saisir un libellé'); return; }
                if (!amount || amount <= 0) { alert('Veuillez saisir un montant valide'); return; }

                if (currentEditId !== null) {
                    const index = transactions.findIndex(t => t.id === currentEditId);
                    if (index !== -1) {
                        transactions[index] = {
                            ...transactions[index],
                            date, label, category, amount,
                            type: currentTransactionType
                        };
                    }
                } else {
                    transactions.push({
                        id: Date.now(),
                        date, label, category, amount,
                        type: currentTransactionType
                    });
                }
                saveToLocal();
                renderTransactions();
                closeModal();
            }

            // Event listeners
            document.getElementById('openIncomeModal').addEventListener('click', () => {
                currentTransactionType = 'entree';
                currentEditId = null;
                updateModalUI();
                transactionDate.value = new Date().toISOString().split('T')[0];
                transactionLabel.value = '';
                transactionCategory.value = 'Commercial';
                transactionAmount.value = '';
                openModal();
            });

            document.getElementById('openExpenseModal').addEventListener('click', () => {
                currentTransactionType = 'sortie';
                currentEditId = null;
                updateModalUI();
                transactionDate.value = new Date().toISOString().split('T')[0];
                transactionLabel.value = '';
                transactionCategory.value = 'Logistique';
                transactionAmount.value = '';
                openModal();
            });

            document.getElementById('closeModalBtn').addEventListener('click', closeModal);
            document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
            document.getElementById('modalBackdrop').addEventListener('click', closeModal);
            saveBtn.addEventListener('click', saveTransaction);

            typeFilter.addEventListener('change', renderTransactions);
            categoryFilter.addEventListener('change', renderTransactions);
            resetFiltersBtn.addEventListener('click', () => {
                typeFilter.value = 'all';
                categoryFilter.value = 'all';
                renderTransactions();
            });

            // Escape key to close modal
            document.addEventListener('keydown', (e) => {
                if (e.key === 'Escape' && !modal.classList.contains('hidden')) closeModal();
            });

            // Styles additionnels
            const style = document.createElement('style');
            style.textContent = `
                                        .modal-backdrop { background-color: rgba(0, 0, 0, 0.5); backdrop-filter: blur(4px); }
                                        .transaction-enter { animation: fadeInUp 0.2s ease; }
                                        @keyframes fadeInUp { from { opacity: 0; transform: translateY(5px); } to { opacity: 1; transform: translateY(0); } }
                                    `;
            document.head.appendChild(style);

            // Initial render
            renderTransactions();
        </script>
    @endpush
@endsection