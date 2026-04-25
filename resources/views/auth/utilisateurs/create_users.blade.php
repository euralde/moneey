@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Ajouter un utilisateur</h2>
            </div>
        </div>
            <form action="{{ route('register') }}" method="post">
                @csrf
                <div class="p-5 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" id="lastname" name="lastname" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Nom de l'utilisateur">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prénom</label>
                        <input type="text" id="firstname" name="firstname" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Prénom de l'utilisateur">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" id="email" name="email" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Email">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" id="password" name="password" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" placeholder="Mot de passe">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Profil</label>
                        <select class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20" name="profil" id="profil">
                            <option value="gerant">Gérant</option>
                            <option value="manager">Manager</option>
                            <option value="employee">Employé</option>
                            <option value="ambassadeur">Ambassadeur</option>
                        </select>                
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20" name="status" id="status">
                            <option value="active">✅ Actif</option>
                            <option value="inactive">⭕ Inactif</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">
                    <a href="{{ route('users.index') }}"
                    class="px-4 py-2 text-blue-600 rounded-lg hover:bg-white border border-blue-600">Retour</a>                    
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Enregistrer</button>
                </div>
            </form>
</div>
@endsection