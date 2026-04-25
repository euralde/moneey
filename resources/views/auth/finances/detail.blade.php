@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-xl font-semibold">Gestion des finances</h2>
            <p class="text-sm text-gray-500">Suivi des entrées et sorties</p>
        </div>
        <a href="{{ route('finances.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">+ Nouvelle transaction</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <div class="bg-white p-5 rounded-lg border">
            <div class="text-xs text-gray-500">Total Entrées</div>
            <div class="text-2xl font-semibold text-green-600">{{ number_format($totalEntrees, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="bg-white p-5 rounded-lg border">
            <div class="text-xs text-gray-500">Total Sorties</div>
            <div class="text-2xl font-semibold text-red-600">{{ number_format($totalSorties, 0, ',', ' ') }} FCFA</div>
        </div>
        <div class="bg-blue-50 p-5 rounded-lg border">
            <div class="text-xs text-blue-700">Solde net</div>
            <div class="text-2xl font-semibold text-blue-900">{{ number_format($solde, 0, ',', ' ') }} FCFA</div>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left">Date</th>
                    <th class="px-4 py-3 text-left">Titre</th>
                    <th class="px-4 py-3 text-left">Catégorie</th>
                    <th class="px-4 py-3 text-right">Montant</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($finances as $finance)
                <tr class="border-t">
                    <td class="px-4 py-3">{{ \Carbon\Carbon::parse($finance->date)->format('d/m/Y') }}</td>
                    <td class="px-4 py-3">{{ $finance->titre }}</td>
                    <td class="px-4 py-3">{{ $finance->categorie }}</td>
                    <td class="px-4 py-3 text-right">
                        @if($finance->type == 'entree')
                            <span class="text-green-600">+ {{ number_format($finance->montant, 0, ',', ' ') }} FCFA</span>
                        @else
                            <span class="text-red-600">- {{ number_format($finance->montant, 0, ',', ' ') }} FCFA</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('finances.show', $finance->id) }}" class="text-blue-600 mr-2">Voir</a>
                        <a href="{{ route('finances.edit', $finance->id) }}" class="text-yellow-600 mr-2">Modifier</a>
                        <form action="{{ route('finances.destroy', $finance->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600" onclick="return confirm('Supprimer ?')">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection