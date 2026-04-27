@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Modifier la tâche</h2>
    </div>

    <form method="POST" action="{{ route('taches.update', $tache->id) }}">
        @csrf
        @method('PUT')
        
        <div>
            <label>Titre</label>
            <input type="text" name="title" value="{{ $tache->title }}" class="w-full px-3 py-2 border rounded-lg" required>
        </div>

        <div class="mt-3">
            <label>Description</label>
            <textarea name="description" rows="3" class="w-full px-3 py-2 border rounded-lg">{{ $tache->description }}</textarea>
        </div>

        <div class="mt-3">
            <label>Statut</label>
            <select name="status" class="w-full px-3 py-2 border rounded-lg">
                <option value="actif" @if($tache->status == 'actif') selected @endif>Actif</option>
                <option value="inactif" @if($tache->status == 'inactif') selected @endif>Inactif</option>
            </select>
        </div>

        <div class="mt-5">
            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg">Modifier</button>
            <a href="{{ route('taches.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg">Retour</a>
        </div>
    </form>
</div>
@endsection