@extends('layouts.app')

@section('content')
    <div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Modifier un département</h2>
                <p class="text-sm text-gray-500 mt-0.5">Gérez vos départements et leur statut</p>
            </div>
        </div>
        <form method="POST" action="{{ route('departements.update', $departement->id) }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                    <input type="text"

                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('name') border-red-500 @enderror"
                        placeholder="Titre du département" name="name"  value="{{ $departement->name }}">
                    @error('name')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <textarea rows="3"
                        class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 resize-none"
                        placeholder="Description" name="description">{{ $departement->description }}</textarea>
                    @error('description')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                    <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                        <option value="actif" @if ($departement->status == 'actif') selected @endif>✅ Actif</option>
                        <option value="inactif" @if ($departement->status == 'inactif') selected @endif>⭕ Inactif</option>
                    </select>
                </div>
            </div>
            <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                <a href="{{ route('departements.index') }}"
                    class="px-4 py-2 text-blue-600 rounded-lg hover:bg-white border border-blue-600">Retour</a>
                <button type="submit"
                    class="px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700">Modifier</button>
            </div>
        </form>
    </div>
@endsection