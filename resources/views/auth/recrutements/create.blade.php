@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto">

        <!-- En-tête -->
        <div class="flex items-center gap-4 mb-6">
            <a href="{{ route('recrutement.index') }}" class="text-gray-400 hover:text-gray-600 transition">
                <iconify-icon icon="solar:arrow-left-linear" class="text-2xl"></iconify-icon>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Nouveau recrutement
                </h1>
                <p class="text-sm text-gray-500 mt-0.5">
                    Créez une nouvelle offre d'emploi
                </p>
            </div>
        </div>

        <!-- Formulaire -->
        <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
            <form action="{{ route('recrutement.store') }}" method="POST" class="p-6 space-y-6">
                @csrf
                <input type="hidden" id="recrutementId">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Titre du poste -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Intitulé du poste <span
                                class="text-red-500">*</span></label>
                        <input type="text" id="title" name="title"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 @error('title') border-red-500 @enderror" value="{{ old('title') }}"
                            placeholder="Ex: Développeur Full Stack">
                            @error('title')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>

                    <!-- Département -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Département</label>
                        <select id="department" name="department_id"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 @error('department_id') border-red-500 @enderror" value="{{ old('department_id') }}">
                            <option value="">Choisir un département</option>
                                    @foreach($departements as $dep)
                                        <option value="{{ $dep->id }}">{{ $dep->name }}</option>
                                    @endforeach
                        </select>
                        @error('department_id')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                        @enderror
                    </div>

                    <!-- Localisation -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Localisation</label>
                        <input type="text" id="location" name="location"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 @error('location') border-red-500 @enderror" value="{{ old('location') }}"
                            placeholder="Abidjan, Paris, Remote">
                            @error('location')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>

                    <!-- Date limite -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Date limite <span
                                class="text-red-500">*</span></label>
                        <input type="date" id="deadline" name="deadline"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 @error('deadline') border-red-500 @enderror" value="{{ old('deadline') }}">
                            @error('deadline')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                    </div>

                    <!-- Statut -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Statut</label>
                        <select id="status" name="status"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20">
                            <option value="ouverte">🟢 Ouverte</option>
                            <option value="encours">🟡 En cours</option>
                            <option value="pourvue">🔵 Pourvue</option>
                            <option value="fermee">⚫ Fermée</option>
                        </select>
                    </div>

                    <!-- Description du poste -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description du poste</label>
                        <textarea id="description" name="description" rows="4"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 resize-none"
                            placeholder="Missions, responsabilités, avantages..."></textarea>
                    </div>

                    <!-- Prérequis -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Prérequis & compétences</label>
                        <textarea id="requirements" name="requirements" rows="4"
                            class="w-full px-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500/20 resize-none @error('requirements') border-red-500 @enderror" value="{{ old('requiremants') }}"
                            placeholder="- Bac+5 en informatique&#10;- 3 ans d&#39;expérience minimum&#10;- Maîtrise de React et Node.js&#10;- Anglais professionnel"></textarea>
                            @error('requirements')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        <p class="text-xs text-gray-400 mt-1">Séparez chaque prérequis par un retour à la ligne</p>
                    </div>
                </div>

                <!-- Boutons d'action -->
                <div class="flex justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('recrutement.index') }}"
                        class="px-4 py-2 text-gray-600 bg-white border border-gray-200 rounded-lg hover:bg-gray-50 transition">Annuler</a>
                    <button type="submit" id="submitBtn"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition shadow-sm">
                        <iconify-icon icon="solar:check-circle-linear" class="inline mr-2 text-base"></iconify-icon>
                        Créer l'offre
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection