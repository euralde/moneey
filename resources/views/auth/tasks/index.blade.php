@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold">Mes tâches</h2>
            <p class="text-sm text-gray-500">Gérez vos tâches</p>
        </div>
        <a href="{{ route('tasks.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            + Nouvelle tâche
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Titre</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Description</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Priorité</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Date</th>
                    <th class="px-4 py-3 text-left text-sm font-semibold text-gray-600">Statut</th>
                    <th class="px-4 py-3 text-center text-sm font-semibold text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                <tr class="border-t hover:bg-gray-50">
                    <td class="px-4 py-3">{{ $task->title }}</td>
                    <td class="px-4 py-3">{{ $task->description ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($task->priority == 'urgent')
                            <span class="text-red-600 font-medium">Urgent</span>
                        @elseif($task->priority == 'haute')
                            <span class="text-orange-600 font-medium">Haute</span>
                        @elseif($task->priority == 'moyenne')
                            <span class="text-blue-600 font-medium">Moyenne</span>
                        @else
                            <span class="text-gray-500">Basse</span>
                        @endif
                    </td>
                    <td class="px-4 py-3">{{ $task->due_date ?? '-' }}</td>
                    <td class="px-4 py-3">
                        @if($task->is_completed)
                            <span class="text-green-600">✔ Terminée</span>
                        @else
                            <span class="text-yellow-600">⏳ En cours</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-center">
                        <a href="{{ route('tasks.edit', $task->id) }}" class="text-yellow-600 hover:text-yellow-800 mr-3">Modifier</a>
                        <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline-block">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-800" onclick="return confirm('Supprimer cette tâche ?')">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-8 text-gray-400">
                        Aucune tâche. Cliquez sur "+ Nouvelle tâche" pour en créer une.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection