@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Nouvelle transaction</h2>
    </div>

    <form method="POST" action="{{ route('finances.store') }}">
        @csrf
        
        <div class="space-y-4">
            <div>
                <label class="block mb-1 font-medium">Titre</label>
                <input type="text" name="Titre" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Type</label>
                <select name="type" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="entree">💰 Entrée</option>
                    <option value="sortie">💸 Sortie</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">categorie</label>
                <select name="categorie" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="Commercial">Commercial</option>
                    <option value="Logistique">Logistique</option>
                    <option value="Salaires">Salaires</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Divers">Divers</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Montant (FCFA)</label>
                <input type="number" name="montant" class="w-full px-3 py-2 border rounded-lg" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Date</label>
                <input type="date" name="date" class="w-full px-3 py-2 border rounded-lg" value="{{ date('Y-m-d') }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg"></textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Enregistrer</button>
            <a href="{{ route('finances.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg">Retour</a>
        </div>
    </form>
</div>
@endsection