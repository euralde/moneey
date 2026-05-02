@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold mb-4">Nouvelle tâche</h2>

    <form method="POST" action="{{ route('tasks.store') }}" class="bg-white p-6 rounded-lg shadow">
        @csrf

        <div class="mb-4">
            <label class="block font-medium mb-1">Titre <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-3 py-2" required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded-lg px-3 py-2">{{ old('description') }}</textarea>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Priorité</label>
            <select name="priority" class="w-full border rounded-lg px-3 py-2">
                <option value="basse">Basse</option>
                <option value="moyenne" selected>Moyenne</option>
                <option value="haute">Haute</option>
                <option value="urgent">Urgent</option>
            </select>
        </div>

        <div class="mb-4">
            <label class="block font-medium mb-1">Date d'échéance</label>
            <input type="date" name="due_date" value="{{ old('due_date') }}" class="w-full border rounded-lg px-3 py-2">
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg">Enregistrer</button>
            <a href="{{ route('tasks.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg">Annuler</a>
        </div>
    </form>
</div>
@endsection