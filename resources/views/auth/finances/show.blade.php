@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Détail de la transaction</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm text-gray-500">Titre</label>
                <p class="font-medium">{{ $transaction->label }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Type</label>
                <p class="font-medium">
                    @if($transaction->type == 'entree')
                        <span class="text-green-600">💰 Entrée</span>
                    @else
                        <span class="text-red-600">💸 Sortie</span>
                    @endif
                </p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Départements</label>
                <p class="font-medium">{{ $transaction->departement->name }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Montant</label>
                <p class="font-medium">{{ number_format($transaction->montant, 0, ',', ' ') }} FCFA</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Date</label>
                <p class="font-medium">{{ \Carbon\Carbon::parse($transaction->date)->format('d/m/Y') }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Statut</label>
                <p class="font-medium">{{ $transaction->statut ?? 'valide' }}</p>
            </div>
            <div class="col-span-2">
                <label class="block text-sm text-gray-500">Description</label>
                <p>{{ $transaction->description ?? 'Aucune description' }}</p>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('transactions.edit', $transaction->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg">Modifier</a>
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg">Retour</a>
        </div>
    </div>
</div>
@endsection