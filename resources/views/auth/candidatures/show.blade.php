@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto py-8 px-4">

    <!-- HEADER -->
    <div class="flex items-center justify-between mb-6">
        <a href="{{ url()->previous() }}" class="text-gray-500 hover:text-gray-700">
            <iconify-icon icon="solar:arrow-left-linear" class="text-2xl"></iconify-icon>
        </a>

        <h1 class="text-2xl font-bold text-gray-900">
            Détails de la candidature
        </h1>
    </div>

    <!-- CARD -->
    <div class="bg-white rounded-xl shadow p-6 space-y-6">

        <!-- INFO CANDIDAT -->
        <div class="border-b pb-4">
            <h2 class="text-lg font-semibold text-gray-800">
                {{ $candidature->name }}
            </h2>
            <p class="text-gray-500 text-sm">
                {{ $candidature->email }} • {{ $candidature->phone }}
            </p>
        </div>

        <!-- POSTE -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Poste</h3>
            <p class="text-gray-600">
                {{ $candidature->recrutement->title }}
            </p>
        </div>

        <!-- STATUT -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Statut</h3>
            <span class="px-3 py-1 text-sm rounded-full bg-blue-100 text-blue-700">
                {{ $candidature->status }}
            </span>
        </div>

        <!-- CV -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-1">CV</h3>

            @if($candidature->cv_url)
                <a href="{{ asset('storage/' . $candidature->cv_url) }}" 
                target="_blank"
                class="text-blue-600 hover:underline">
                    📄 Voir le CV
                </a>
            @else
                <p class="text-gray-400">Aucun CV disponible</p>
            @endif
        </div>

        <!-- LETTRE -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Lettre de motivation</h3>

            @if($candidature->lettre_motivation)
                <a href="{{ asset('storage/' . $candidature->lettre_motivation) }}" 
                target="_blank"
                class="text-blue-600 hover:underline">
                    📝 Voir la lettre
                </a>
            @else
                <p class="text-gray-400">Aucune lettre fournie</p>
            @endif
        </div>

        <!-- DATE -->
        <div>
            <h3 class="text-sm font-semibold text-gray-700 mb-1">Date de candidature</h3>
            <p class="text-gray-600">
                {{ $candidature->created_at->format('d/m/Y H:i') }}
            </p>
        </div>

    </div>
</div>
@endsection