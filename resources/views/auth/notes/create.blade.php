@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto px-4 py-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4">Nouvelle note</h2>

    <form method="POST" action="{{ route('notes.store') }}" class="bg-white p-6 rounded-lg shadow-sm border">
        @csrf

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Titre <span class="text-red-500">*</span></label>
            <input type="text" name="title" value="{{ old('title') }}" class="w-full border rounded-lg px-3 py-2" required>
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label class="block font-medium text-gray-700 mb-1">Contenu</label>
            <textarea name="content" rows="6" class="w-full border rounded-lg px-3 py-2">{{ old('content') }}</textarea>
            @error('content') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="flex gap-3">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Enregistrer</button>
            <a href="{{ route('notes.index') }}" class="bg-gray-500 text-white px-4 py-2 rounded-lg hover:bg-gray-600">Annuler</a>
        </div>
    </form>
</div>
@endsection