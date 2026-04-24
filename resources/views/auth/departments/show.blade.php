@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Départements</h1>
    <a href="{{ route('departements.create') }}" class="btn btn-primary mb-3">Ajouter</a>

    <table class="table">
        <thead>
            <tr><th>Titre</th><th>Description</th><th>Actions</th></tr>
        </thead>
        <tbody>
            @foreach($departements as $d)
            <tr>
                <td>{{ $d->title }}</td>
                <td>{{ $d->description }}</td>
                <td>
                    <a href="{{ route('departements.edit', $d->id) }}" class="btn btn-warning">Modifier</a>
                    <form action="{{ route('departements.destroy', $d->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Supprimer</button>
                    </form>
                    <a href="{{ route('departements.show', $d->id) }}" class="btn btn-info">Détail</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection