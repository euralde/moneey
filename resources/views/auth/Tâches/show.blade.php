@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Liste des tâches</h2>
        <a href="{{ route('taches.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">+ Ajouter</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr><th class="px-4 py-2 text-left">Titre</th><th class="px-4 py-2 text-left">Statut</th><th class="px-4 py-2">Actions</th></tr>
            </thead>
            <tbody>
                @foreach($taches as $tache)
                <tr>
                    <td class="px-4 py-2">{{ $tache->title }}</td>
                    <td class="px-4 py-2">{{ $tache->status }}</td>
                    <td class="px-4 py-2">
                        <a href="{{ route('taches.edit', $tache->id) }}" class="text-yellow-600">Modifier</a>
                        <form action="{{ route('taches.destroy', $tache->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection