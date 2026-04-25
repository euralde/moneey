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
                <p class="font-medium">{{ $finance->titre }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Type</label>
                <p class="font-medium">
                    @if($finance->type == 'entree')
                        <span class="text-green-600">💰 Entrée</span>
                    @else
                        <span class="text-red-600">💸 Sortie</span>
                    @endif
                </p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Catégorie</label>
                <p class="font-medium">{{ $finance->categorie }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Montant</label>
                <p class="font-medium">{{ number_format($finance->montant, 0, ',', ' ') }} FCFA</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Date</label>
                <p class="font-medium">{{ \Carbon\Carbon::parse($finance->date)->format('d/m/Y') }}</p>
            </div>
            <div>
                <label class="block text-sm text-gray-500">Statut</label>
                <p class="font-medium">{{ $finance->statut }}</p>
            </div>
            <div class="col-span-2">
                <label class="block text-sm text-gray-500">Description</label>
                <p>{{ $finance->description ?? 'Aucune description' }}</p>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <a href="{{ route('finances.edit', $finance->id) }}" class="px-4 py-2 bg-yellow-600 text-white rounded-lg">Modifier</a>
            <a href="{{ route('finances.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg">Retour</a>
        </div>
    </div>
</div>
@endsection