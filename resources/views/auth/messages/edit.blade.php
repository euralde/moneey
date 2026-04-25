@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-6">
        <h2 class="text-xl font-semibold">Modifier le message</h2>
    </div>

    <form method="POST" action="{{ route('messages.update', $message->id) }}">
        @csrf
        @method('PUT')
        
        <div class="space-y-4">
            <div>
                <label class="block mb-1 font-medium">Titre</label>
                <input type="text" name="titre" class="w-full px-3 py-2 border rounded-lg" value="{{ $message->titre }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Contenu</label>
                <textarea name="contenu" rows="5" class="w-full px-3 py-2 border rounded-lg">{{ $message->contenu }}</textarea>
            </div>

            <div>
                <label class="block mb-1 font-medium">Expéditeur</label>
                <input type="text" name="expediteur" class="w-full px-3 py-2 border rounded-lg" value="{{ $message->expediteur }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Destinataire</label>
                <input type="text" name="destinataire" class="w-full px-3 py-2 border rounded-lg" value="{{ $message->destinataire }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Statut</label>
                <select name="status" class="w-full px-3 py-2 border rounded-lg">
                    <option value="non_lu" @if($message->status == 'non_lu') selected @endif>Non lu</option>
                    <option value="lu" @if($message->status == 'lu') selected @endif>Lu</option>
                </select>
            </div>
        </div>

        <div class="mt-6 flex gap-3">
            <button type="submit" class="px-4 py-2 bg-yellow-600 text-white rounded-lg">Mettre à jour</button>
            <a href="{{ route('messages.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded-lg">Retour</a>
        </div>
    </form>
</div>
@endsection