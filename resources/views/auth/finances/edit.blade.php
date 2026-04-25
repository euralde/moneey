@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Modifier la transaction</h2>
    </div>

    <form method="POST" action="{{ route('finances.update', $finance->id) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block mb-1 font-medium">Titre</label>
                <input type="text" name="titre" class="w-full px-3 py-2 border rounded-lg" value="{{ $finance->titre }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Type</label>
                <select name="type" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="entree" @if($finance->type == 'entree') selected @endif>💰 Entrée</option>
                    <option value="sortie" @if($finance->type == 'sortie') selected @endif>💸 Sortie</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Catégorie</label>
                <select name="categorie" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="Commercial" @if($finance->categorie == 'Commercial') selected @endif>Commercial</option>
                    <option value="Logistique" @if($finance->categorie == 'Logistique') selected @endif>Logistique</option>
                    <option value="Salaires" @if($finance->categorie == 'Salaires') selected @endif>Salaires</option>
                    <option value="Marketing" @if($finance->categorie == 'Marketing') selected @endif>Marketing</option>
                    <option value="Divers" @if($finance->categorie == 'Divers') selected @endif>Divers</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Montant (FCFA)</label>
                <input type="number" name="montant" class="w-full px-3 py-2 border rounded-lg" value="{{ $finance->montant }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Date</label>
                <input type="date" name="date" class="w-full px-3 py-2 border rounded-lg" value="{{ $finance->date }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ $finance->description }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg">Modifier</button>
            <a href="{{ route('finances.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg">Retour</a>
        </div>
    </form>
</div>
@endsection