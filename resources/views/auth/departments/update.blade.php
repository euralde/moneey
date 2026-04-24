@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Modifier le département</h1>
    <form method="POST" action="{{ route('departements.update', $departement->id) }}">
        @csrf
        <input type="hidden" name="_method" value="PUT">

        <div class="mb-3">
            <label>Titre</label>
            <input type="text" name="title" value="{{ $departement->title }}" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control">{{ $departement->description }}</textarea>
        </div>
        <button type="submit" class="btn btn-success">Mettre à jour</button>
    </form>
</div>
@endsection