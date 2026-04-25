@extends('layouts.app')

@section('title', 'Services IT - AFRO\'PLUME')
@section('header-title', 'Services & Infrastructures')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-6">
        <div>
            <h2 class="text-xl font-semibold text-gray-900">Liste des services</h2>
            <p class="text-sm text-gray-500 mt-0.5">Gérez vos services et leur statut</p>
        </div>
        <a href="{{ route('departements.create') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-all shadow-sm">
            <iconify-icon icon="solar:add-circle-linear" class="text-lg"></iconify-icon>
            Ajouter un service
        </a>
    </div>

    <!-- Datatable -->
    <div class="bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr class="text-xs font-semibold text-gray-500 uppercase tracking-wider">
                        <th class="px-6 py-4">Titre</th>
                        <th class="px-6 py-4">Description</th>
                        <th class="px-6 py-4">Statut</th>
                        <th class="px-6 py-4 text-center">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                     @foreach($departements as $departement)
                    <tr class="hover:bg-gray-50 transition">
                    <td class="px-6 py-4 font-medium text-gray-900">{{ $departement->title }}</td>
                    <td class="px-6 py-4 text-gray-500 max-w-xs truncate">{{ $departement->description }}</td>
                    <td class="px-6 py-4">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium">
                       {{ $departement->status == 'actif' ? 'Actif' : 'Inactif'}}
                    </span>
                </td>
                <td class="px-6 py-4 text-center">
                    <div class="flex items-center justify-center gap-2">
                        <button  class="text-blue-600 hover:bg-blue-50 p-1.5 rounded">
                            <iconify-icon icon="solar:pen-2-linear" class="text-base"></iconify-icon>
                        </button>
                        <button  class="text-rose-600 hover:bg-rose-50 p-1.5 rounded">
                            <iconify-icon icon="solar:trash-bin-trash-linear" class="text-base"></iconify-icon>
                        </button>
                    </div>
                </td>
            </tr>
                        @endforeach

                </tbody>
            </table>
        </div>
        <div id="emptyServices" class="text-center py-12 hidden">
            <iconify-icon icon="solar:server-square-linear" class="text-5xl text-gray-300 mx-auto mb-3"></iconify-icon>
            <p class="text-gray-400">Aucun service</p>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .modal-backdrop {
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(4px);
    }
</style>
@endpush
