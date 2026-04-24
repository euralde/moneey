@extends('layouts.app')

@section('title', 'Dashboard - AFRO\'PLUME')
@section('header-title', 'Tableau de bord')

@section('content')
<div class="max-w-7xl mx-auto pb-20 space-y-8">
    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-5 rounded-xl border shadow-sm">
            <div class="flex justify-between">
                <span class="text-xs font-semibold text-gray-400">CA Brut</span>
                <iconify-icon icon="solar:wallet-money-linear" class="text-2xl text-emerald-500"></iconify-icon>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold">12.5 M</span>
                <span class="text-xs text-gray-500 ml-1">FCFA</span>
                <div class="mt-1">
                    <span class="text-emerald-600 text-xs bg-emerald-50 px-2 py-0.5 rounded-full">+12%</span>
                </div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border shadow-sm">
            <div class="flex justify-between">
                <span class="text-xs font-semibold text-gray-400">Dépenses</span>
                <iconify-icon icon="solar:cart-large-minimalistic-linear" class="text-2xl text-rose-400"></iconify-icon>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold">8.2 M</span>
                <span class="text-xs text-gray-500 ml-1">FCFA</span>
                <div class="mt-1">
                    <span class="text-rose-600 text-xs bg-rose-50 px-2 py-0.5 rounded-full">-5%</span>
                </div>
            </div>
        </div>

        <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-5 rounded-xl shadow-lg text-white">
            <div class="flex justify-between">
                <span class="text-xs font-semibold text-blue-100">Trésorerie</span>
                <iconify-icon icon="solar:card-linear" class="text-2xl text-blue-200"></iconify-icon>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold">4.3 M</span>
                <span class="text-xs ml-1">FCFA</span>
                <div class="mt-1 text-[11px]">Solde disponible</div>
            </div>
        </div>

        <div class="bg-white p-5 rounded-xl border shadow-sm">
            <div class="flex justify-between">
                <span class="text-xs font-semibold text-gray-400">Tâches urgentes</span>
                <iconify-icon icon="solar:alarm-linear" class="text-2xl text-amber-500"></iconify-icon>
            </div>
            <div class="mt-3">
                <span class="text-2xl font-bold">3</span>
                <span class="text-xs ml-1">à traiter</span>
                <div class="mt-1">
                    <span class="text-rose-500 text-xs bg-rose-50 px-2 py-0.5 rounded-full">Priorité haute</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white rounded-xl border p-5">
            <div class="flex justify-between mb-4">
                <div>
                    <h3 class="font-semibold">Flux de trésorerie</h3>
                    <p class="text-xs text-gray-400">Jan - Mar 2026 (milliers FCFA)</p>
                </div>
                <div class="flex gap-3 text-xs">
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                        <span>Entrées</span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="w-3 h-3 rounded-full bg-rose-400"></span>
                        <span>Sorties</span>
                    </div>
                </div>
            </div>
            <canvas id="cashflowChart" height="250"></canvas>
        </div>

        <div class="bg-white rounded-xl border p-5">
            <h3 class="font-semibold mb-4">Répartition des dépenses</h3>
            <div class="flex justify-center">
                <canvas id="expenseDonutChart" width="200" height="200"></canvas>
            </div>
            <div class="mt-6 space-y-2">
                <div class="flex justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-blue-500"></span>Logistique
                    </div>
                    <span>32%</span>
                </div>
                <div class="flex justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-amber-500"></span>Salaires
                    </div>
                    <span>41%</span>
                </div>
                <div class="flex justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>Marketing
                    </div>
                    <span>18%</span>
                </div>
                <div class="flex justify-between text-xs">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-purple-500"></span>Divers
                    </div>
                    <span>9%</span>
                </div>
            </div>
        </div>
    </div>

    <!-- KPIs & Recommandation -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white rounded-xl border p-5">
            <div class="flex justify-between">
                <h3 class="font-semibold">Taux d'achèvement</h3>
                <iconify-icon icon="solar:graph-up-linear" class="text-2xl text-gray-400"></iconify-icon>
            </div>
            <div class="mt-4">
                <div class="flex justify-end">
                    <span class="text-2xl font-bold">74%</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2">
                    <div class="bg-indigo-500 h-2 rounded-full" style="width:74%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border p-5">
            <div class="flex justify-between">
                <h3 class="font-semibold">Rotation des stocks</h3>
                <iconify-icon icon="solar:refresh-linear" class="text-2xl text-gray-400"></iconify-icon>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-bold">4.2x</span>
                    <span class="text-xs text-gray-400">/mois</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2 mt-2">
                    <div class="bg-emerald-500 h-2 rounded-full" style="width:70%"></div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border p-5">
            <div class="flex justify-between">
                <h3 class="font-semibold">Score de santé</h3>
                <iconify-icon icon="solar:heart-angle-linear" class="text-2xl text-rose-400"></iconify-icon>
            </div>
            <div class="mt-4">
                <div class="flex items-baseline gap-2">
                    <span class="text-2xl font-bold">B+</span>
                    <span class="text-xs text-gray-400">Stable</span>
                </div>
                <div class="w-full bg-gray-100 rounded-full h-2 mt-2">
                    <div class="bg-amber-500 h-2 rounded-full" style="width:68%"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
        <div class="flex">
            <iconify-icon icon="solar:chat-square-check-linear" class="text-blue-600 text-xl mr-3"></iconify-icon>
            <div>
                <h4 class="font-semibold text-blue-800 text-sm">Recommandation IA</h4>
                <p class="text-blue-700 text-xs">Les dépenses logistiques sont maîtrisées (-5%). Pensez à renforcer le budget marketing digital pour soutenir la croissance des entrées (+12%).</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    new Chart(document.getElementById('cashflowChart'), {
        type: 'line',
        data: {
            labels: ['Janvier', 'Février', 'Mars'],
            datasets: [
                {
                    label: 'Entrées',
                    data: [10500, 11800, 12500],
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.05)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#10b981'
                },
                {
                    label: 'Sorties',
                    data: [7600, 8300, 8200],
                    borderColor: '#fb7185',
                    backgroundColor: 'rgba(251,113,133,0.05)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#fb7185'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    new Chart(document.getElementById('expenseDonutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Logistique', 'Salaires', 'Marketing', 'Divers'],
            datasets: [{
                data: [32, 41, 18, 9],
                backgroundColor: ['#3b82f6', '#f59e0b', '#10b981', '#a855f7'],
                borderWidth: 0,
                hoverOffset: 8
            }]
        },
        options: {
            cutout: '65%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush
