@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Détail du message</h2>
    </div>

    <div class="bg-white rounded-lg shadow p-6">
        <div class="mb-4">
            <label class="block font-medium mb-1">Titre</label>
            <p class="text-lg">{{ $message->titre }}</p>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Contenu</label>
            <p class="text-gray-700">{{ $message->contenu }}</p>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Expéditeur</label>
            <p>{{ $message->expediteur }}</p>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Destinataire</label>
            <p>{{ $message->destinataire }}</p>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Statut</label>
            @if($message->status == 'lu')
                <span class="text-green-600">Lu</span>
            @else
                <span class="text-orange-600">Non lu</span>
            @endif
        </div>

        <div class="mt-6">
            <a href="{{ route('messages.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg">Retour</a>
        </div>
    </div>
</div>
@endsection