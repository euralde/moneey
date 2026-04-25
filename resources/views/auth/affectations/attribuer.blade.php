@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Affecter un département</h2>
            </div>
        </div>
            <form action="{{ route('affectations.store') }}" method="post">
                @csrf
                <div class="p-5 space-y-4">
                                <!-- ID caché -->
                <input type="hidden" name="user_id" value="{{ $users->id }}">

                <!-- Infos personnel -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nom</label>
                        <input type="text" id="lastname" name="lastname" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500" value="{{ $users->lastname }}">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Departement</label>
                        <select class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500/20" name="departement_id" required>
                            @foreach($departements as $d)
                                <option value="{{ $d->id }}">
                                    {{ $d->title }}
                                </option>
                            @endforeach
                        </select>                
                    <div>
                <div class="flex justify-end gap-3 p-5 border-t bg-gray-50/50 rounded-b-xl">      
                    <a href="{{ route('users.index') }}"
                    class="px-4 py-2 text-blue-600 rounded-lg hover:bg-white border border-blue-600">Retour</a>  
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">Affecter</button>
                </div>
            </form>

</div>
@endsection