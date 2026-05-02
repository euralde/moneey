@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Modifier la tâche</h2>

    <form method="POST" action="{{ route('tasks.update', $task->id) }}" class="bg-white p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label class="block font-medium mb-1">Titre <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title', $task->title) }}" class="w-full border rounded-lg px-3 py-2" required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2">{{ old('description', $task->description) }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Priorité</label>
            <select name="priority" class="w-full border rounded-lg px-3 py-2">
                <option value="basse" @if($task->priority == 'basse') selected @endif>Basse</option>
                <option value="moyenne" @if($task->priority == 'moyenne') selected @endif>Moyenne</option>
                <option value="haute" @if($task->priority == 'haute') selected @endif>Haute</option>
                <option value="urgent" @if($task->priority == 'urgent') selected @endif>Urgent</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Date d'échéance</label>
            <input type="date" name="due_date" value="{{ old('due_date', $task->due_date) }}" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-yellow-600 text-white px-4 py-2 rounded-lg">Modifier</button>
            <a href="{{ route('tasks.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Retour</a>
        </div>
    </form>
</div>
@endsection