@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Modifier l'utilisateur</h2>
            </div>
        </div>
<form method="POST" action="{{ route('users.update', $user->id) }}">
    @csrf

            <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" id="lastname" name="lastname" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" value="{{ $user->lastname }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" id="firstname" name="firstname" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" value="{{ $user->firstname }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" value="{{ $user->email }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Profil</label>
                        <select class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20" name="profil" id="profil">
                            <option value="gerant" @if ($user->profil == 'gerant') selected @endif>Gérant</option>
                            <option value="manager" @if ($user->profil == 'manager') selected @endif>Manager</option>
                            <option value="employee" @if ($user->profil == 'employee') selected @endif>Employé</option>
                            <option value="ambassadeur" @if ($user->profil == 'ambassadeur') selected @endif>Ambassadeur</option>
                        </select>                
                        <div>
                </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select name="status" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20">
                            <option value="actif" @if ($user->status == 'actif') selected @endif>✅ Actif</option>
                            <option value="inactif" @if ($user->status == 'inactif') selected @endif>⭕ Inactif</option>
                        </select>
                    </div>
            </div>
                <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                    <a href="{{ route('users.index') }}"
                    class="px-4 py-2 text-blue-600 rounded-lg hover:bg-white border border-blue-600">Retour</a>
                    <button id="" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Modifier</button>
                </div>
</form>
</div>
@endsection