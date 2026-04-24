 @extends('layouts.app')

@section('content')
<div class="container">
    <h1>Ajouter un département</h1>
    <form method="POST" action="{{ route('departements.store') }}">
        @csrf
        <div class="mb-3">
            <label>Titre</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-success">Enregistrer</button>
    </form>
</div>
@endsection