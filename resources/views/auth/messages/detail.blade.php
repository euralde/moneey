@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-semibold">Liste des messages</h2>
        <a href="{{ route('messages.create') }}" class="px-4 py-2 bg-blue-600 text-white rounded-lg">+ Nouveau message</a>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-2">Titre</th>
                    <th class="px-4 py-2">Expéditeur</th>
                    <th class="px-4 py-2">Destinataire</th>
                    <th class="px-4 py-2">Statut</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $message)
                <tr>
                    <td class="px-4 py-2">{{ $message->titre }}</td>
                    <td class="px-4 py-2">{{ $message->expediteur }}</td>
                    <td class="px-4 py-2">{{ $message->destinataire }}</td>
                    <td class="px-4 py-2">
                        @if($message->status == 'lu')
                            <span class="text-green-600">Lu</span>
                        @else
                            <span class="text-orange-600">Non lu</span>
                        @endif
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('messages.show', $message->id) }}" class="text-blue-600 mr-2">Voir</a>
                        <a href="{{ route('messages.edit', $message->id) }}" class="text-yellow-600 mr-2">Modifier</a>
                        <form action="{{ route('messages.destroy', $message->id) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" class="text-red-600">Supprimer</button>
                        </form>
                    </td>
                </table>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection