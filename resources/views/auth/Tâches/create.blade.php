@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Ajouter une tâche</h2>
                <p class="text-sm text-gray-500 mt-0.5">Gérez vos tâches et leur statut</p>
            </div>
        </div>
        <form method="POST" action="{{ route('taches.store') }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                    <input type="text"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('title') border-red-500 @enderror"
                        placeholder="Titre de la tâche" name="title" required>
                    @error('title')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea rows="3"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none"
                        placeholder="Description" name="description"></textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20"
                        required>
                        <option value="actif">✅ Actif</option>
                        <option value="inactif">⭕ Inactif</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                <a href="{{ route('taches.index') }}"
                    class="px-4 py-2 text-blue-600 rounded-lg hover:bg-white border border-blue-600">Retour</a>
                <button type="submit"
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
            </div>
        </form>
    </div>
@endsection