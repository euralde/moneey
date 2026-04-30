@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Modifier la transaction</h2>
    </div>

    <form method="POST" action="{{ route('transactions.update', $transaction->id) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block mb-1 font-medium">Nom</label>
                <input type="text" name="label" class="w-full px-3 py-2 border rounded-lg" value="{{ $transaction->label }}">
                @error('label')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Type</label>
                <select name="type" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="entree" @if($transaction->type == 'entree') selected @endif>💰 Entrée</option>
                    <option value="sortie" @if($transaction->type == 'sortie') selected @endif>💸 Sortie</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Départements</label>
                <select name="departement_id" class="w-full px-3 py-2 border rounded-lg" required>
                    <option value="">-- Sélectionnez un département --</option>
                    @foreach($departements as $dep)
                          <option value="{{ $dep->id }}"
                               {{ $dep->id == $transaction->departement_id ? 'selected' : '' }}>
                               {{ $dep->name }}
                          </option>                
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Montant (FCFA)</label>
                <input type="number" name="montant" class="w-full px-3 py-2 border rounded-lg" value="{{ $transaction->montant }}" required>
                @error('montant')
                    <span class="text-red-500">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <label class="block mb-1 font-medium">Description</label>
                <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ $transaction->description }}</textarea>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg">Modifier</button>
            <a href="{{ route('transactions.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg">Retour</a>
        </div>
    </form>
</div>
@endsection