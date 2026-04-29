@extends('layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h2 class="text-2xl font-bold text-gray-800">Mes notes</h2>
            <p class="text-sm text-gray-500 mt-0.5">Organisez vos idées et suivis</p>
        </div>
        <a href="{{ route('notes.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition shadow-sm">
            + Nouvelle note
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded-lg mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($notes as $note)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition p-5 flex flex-col">
                <h3 class="font-bold text-lg text-gray-900 mb-2">{{ $note->title }}</h3>
                <p class="text-gray-600 text-sm mb-4 line-clamp-3">{{ $note->content ?? 'Aucun contenu' }}</p>
                <div class="text-xs text-gray-400 mt-auto flex justify-between items-center">
                    <span>{{ $note->created_at->format('d M Y') }}</span>
                    <div class="flex gap-3">
                        <a href="{{ route('notes.edit', $note) }}" class="text-yellow-600 hover:underline text-sm">Modifier</a>
                        <form action="{{ route('notes.destroy', $note) }}" method="POST" class="inline" onsubmit="return confirm('Supprimer cette note ?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline text-sm">Supprimer</button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center text-gray-400 py-12">
                Aucune note. Cliquez sur "+ Nouvelle note" pour commencer.
            </div>
        @endforelse
    </div>
</div>
@endsection