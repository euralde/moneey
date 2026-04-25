@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Ajouter un service</h2>
            <p class="text-sm text-gray-500 mt-0.5">Gérez vos services et leur statut</p>
        </div>
    </div>
    <form method="POST" action="{{ route('departements.store') }}">
    @csrf
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Titre</label>
                <input type="text" id="serviceTitle" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Nom du service" name="title" >
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea id="serviceDesc" rows="3" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none" placeholder="Description du service"  name="description"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                <select id="serviceStatus" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                    <option value="active">✅ Actif</option>
                    <option value="inactive">⭕ Inactif</option>
                </select>
            </div>
        </div>
        <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
        </div>
    </form>
</div>
@endsection