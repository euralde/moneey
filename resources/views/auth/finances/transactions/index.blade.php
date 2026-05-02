@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto pb-20">

    <!-- Cartes récapitulatives -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5 mb-8">
        <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 rounded-xl p-5 text-white shadow-lg">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-emerald-100 text-xs font-medium uppercase tracking-wider">Total entrées</p>
                    <p class="text-3xl font-bold mt-2">{{ number_format($totalEntrees, 0, ',', ' ') }} FCFA</p>
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
                    <p class="text-3xl font-bold mt-2">{{ number_format($totalSorties, 0, ',', ' ') }} FCFA</p>
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
                    <p class="text-3xl font-bold mt-2">{{ number_format($solde, 0, ',', ' ') }} FCFA</p>
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
            <form method="GET" action="{{ route('transactions.index') }}" class="flex gap-3">
                <select name="type" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="all" {{ request('type') == 'all' ? 'selected' : '' }}>Tous les types</option>
                    <option value="entree" {{ request('type') == 'entree' ? 'selected' : '' }}>Entrées</option>
                    <option value="sortie" {{ request('type') == 'sortie' ? 'selected' : '' }}>Sorties</option>
                </select>
                <select name="departement_id" class="px-3 py-2 border border-gray-200 rounded-lg text-sm bg-white">
                    <option value="">Tous les départements</option>
                    @foreach($departements as $dep)
                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                    @endforeach
                </select>
                <button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded-lg">Filtrer</button>
                <a href="{{ route('transactions.index') }}" class="px-3 py-2 text-gray-500 border border-gray-200 rounded-lg">Réinitialiser</a>
            </form>
        </div>
        <div class="flex gap-3">
            <button id="openIncomeModal" data-type="entree"
                class="inline-flex items-center gap-2 px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-all shadow-sm">
                <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
                Nouvelle entrée
            </button>
            <button id="openExpenseModal" data-type="sortie"
                class="inline-flex items-center gap-2 px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-medium transition-all shadow-sm">
                <iconify-icon icon="solar:minus-circle-linear" class="text-lg"></iconify-icon>
                Nouvelle sortie
            </button>
        </div>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg mb-4">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </div>
    @endif

    <!-- Datatable -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Date</th>
                        <th class="px-6 py-4">Libellé</th>
                        <th class="px-6 py-4">Département</th>
                        <th class="px-6 py-4 text-right">Montant</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse($transactions as $transaction)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-6 py-4">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $transaction->label }}</td>
                        <td class="px-6 py-4">{{ $transaction->departement->name }}</td>
                        <td class="px-6 py-4 text-right font-semibold {{ $transaction->type == 'entree' ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $transaction->type == 'entree' ? '+' : '-' }} {{ number_format($transaction->montant, 0, ',', ' ') }} FCFA
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('transactions.show', $transaction->id) }}" class="text-blue-600 hover:bg-blue-50 p-1.5 rounded">
                                    <iconify-icon icon="solar:eye-linear" class="text-base"></iconify-icon>
                                </a>
                                <a href="{{ route('transactions.edit', $transaction->id) }}" class="text-yellow-600 hover:bg-yellow-50 p-1.5 rounded">
                                    <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                                </a>
                                <form action="{{ route('transactions.destroy', $transaction->id) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette transaction ?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-rose-600 hover:bg-rose-50 p-1.5 rounded">
                                        <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center py-12 text-gray-400">
                            <iconify-icon icon="solar:wallet-linear" class="text-5xl mx-auto mb-3"></iconify-icon>
                            <p>Aucune transaction enregistrée</p>
                            <p class="text-xs mt-1">Cliquez sur "Nouvelle entrée" ou "Nouvelle sortie" pour commencer</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- MODAL Transaction -->
<div id="transactionModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4">
    <div class="absolute inset-0 modal-backdrop" id="modalBackdrop"></div>
    <div class="relative bg-white rounded-xl shadow-2xl w-full max-w-md transform transition-all duration-300 scale-95 opacity-0" id="modalContainer">
        <div class="flex justify-between items-center p-5 border-b border-gray-100">
            <h3 class="text-lg font-semibold text-gray-900" id="modalTitle">Nouvelle transaction</h3>
            <button id="closeModalBtn" class="text-gray-400 hover:text-gray-600 transition-colors">
                <iconify-icon icon="solar:close-circle-linear" class="text-2xl"></iconify-icon>
            </button>
        </div>
        <form method="POST" action="{{ route('transactions.store') }}" id="transactionForm">
            @csrf
            <input type="hidden" name="type" id="transactionType" value="entree">
            <div class="p-5 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="date" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        value="{{ old('date', date('Y-m-d')) }}" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Libellé</label>
                    <input type="text" name="label" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Ex: Vente de produits" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                    <select name="departement_id" class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20" required>
                        <option value="">-- Sélectionnez un département --</option>
                        @foreach($departements as $dep)
                            <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Montant (FCFA)</label>
                    <input type="number" name="montant" 
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        placeholder="0" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea name="description" rows="2"
                        class="w-full px-3 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        placeholder="Description optionnelle"></textarea>
                </div>
                <div id="typeIndicator" class="text-xs font-medium p-2 rounded-lg text-center bg-emerald-50 text-emerald-700">
                    🟢 Type: ENTRÉE (revenu)
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t border-gray-100 bg-gray-50/50 rounded-b-xl">
                <button type="button" id="cancelModalBtn" class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition-colors text-sm font-medium">
                    Annuler
                </button>
                <button type="submit" id="saveTransactionBtn" class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors shadow-sm">
                    Enregistrer
                </button>
            </div>
        </form>
    </div>
</div>

<style>
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }
</style>

@push('scripts')
<script>
    const modal = document.getElementById('transactionModal');
    const modalContainer = document.getElementById('modalContainer');
    const modalTitle = document.getElementById('modalTitle');
    const typeIndicator = document.getElementById('typeIndicator');
    const saveBtn = document.getElementById('saveTransactionBtn');
    const transactionTypeInput = document.getElementById('transactionType');

    function openModal(type) {
        transactionTypeInput.value = type;
        if (type === 'entree') {
            modalTitle.innerText = 'Nouvelle entrée';
            typeIndicator.innerHTML = '🟢 Type: ENTRÉE (revenu)';
            typeIndicator.className = 'text-xs font-medium p-2 rounded-lg text-center bg-emerald-50 text-emerald-700';
            saveBtn.className = 'px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg font-medium transition-colors shadow-sm';
        } else {
            modalTitle.innerText = 'Nouvelle sortie';
            typeIndicator.innerHTML = '🔴 Type: SORTIE (dépense)';
            typeIndicator.className = 'text-xs font-medium p-2 rounded-lg text-center bg-rose-50 text-rose-700';
            saveBtn.className = 'px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white rounded-lg font-medium transition-colors shadow-sm';
        }
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
        }, 200);
    }

    document.getElementById('openIncomeModal').addEventListener('click', () => openModal('entree'));
    document.getElementById('openExpenseModal').addEventListener('click', () => openModal('sortie'));
    document.getElementById('closeModalBtn').addEventListener('click', closeModal);
    document.getElementById('cancelModalBtn').addEventListener('click', closeModal);
    document.getElementById('modalBackdrop').addEventListener('click', closeModal);

    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && modal && !modal.classList.contains('hidden')) closeModal();
    });
</script>
@endpush
@endsection