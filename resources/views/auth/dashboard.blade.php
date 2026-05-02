@extends('layouts.app')

@section('title', 'Dashboard - AFRO\'PLUME')
@section('header-title', 'Tableau de bord')

@section('content')
<div class="max-w-7xl mx-auto pb-20 space-y-8">

    <!-- ===================== STATS ===================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-5">

        <!-- CA BRUT -->
        <div class="bg-white p-5 rounded-xl border shadow-sm">
            <div class="flex justify-between">
                <span class="text-xs font-semibold text-gray-400">CA Brut</span>
                <iconify-icon icon="solar:wallet-money-linear" class="text-2xl text-emerald-500"></iconify-icon>
            </div>

            <div class="mt-3">
                <span class="text-2xl font-bold">
                    {{ number_format($totalEntrees, 0, ',', ' ') }}
                </span>
                <span class="text-xs text-gray-500 ml-1">FCFA</span>
            </div>
        </div>

        <!-- DÉPENSES -->
        <div class="bg-white p-5 rounded-xl border shadow-sm">
            <div class="flex justify-between">
                <span class="text-xs font-semibold text-gray-400">Dépenses</span>
                <iconify-icon icon="solar:cart-large-minimalistic-linear" class="text-2xl text-rose-400"></iconify-icon>
            </div>

            <div class="mt-3">
                <span class="text-2xl font-bold">
                    {{ number_format($totalSorties, 0, ',', ' ') }}
                </span>
                <span class="text-xs text-gray-500 ml-1">FCFA</span>
            </div>
        </div>

        <!-- TRÉSORERIE -->
        <div class="bg-gradient-to-br from-blue-600 to-blue-700 p-5 rounded-xl shadow-lg text-white">
            <div class="flex justify-between">
                <span class="text-xs font-semibold text-blue-100">Trésorerie</span>
                <iconify-icon icon="solar:card-linear" class="text-2xl text-blue-200"></iconify-icon>
            </div>

            <div class="mt-3">
                <span class="text-2xl font-bold">
                    {{ number_format($tresorerie, 0, ',', ' ') }}
                </span>
                <span class="text-xs ml-1">FCFA</span>
            </div>
        </div>

        <!-- TÂCHES URGENTES -->
        <div class="bg-white p-5 rounded-xl border shadow-sm">
            <div class="flex justify-between">
                <span class="text-xs font-semibold text-gray-400">Tâches urgentes</span>
                <iconify-icon icon="solar:alarm-linear" class="text-2xl text-amber-500"></iconify-icon>
            </div>

            <div class="mt-3">
                <span class="text-2xl font-bold">
                    {{ $tachesUrgentes }}
                </span>
                <span class="text-xs ml-1">à traiter</span>
            </div>
        </div>

    </div>

    <!-- ===================== GRAPHIQUES ===================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- CASHFLOW -->
        <div class="lg:col-span-2 bg-white rounded-xl border p-5">
            <div class="flex justify-between mb-4">
                <div>
                    <h3 class="font-semibold">Flux de trésorerie</h3>
                    <p class="text-xs text-gray-400">Evolution mensuelle</p>
                </div>
            </div>

            <canvas id="cashflowChart" height="250"></canvas>
        </div>

        <!-- DONUT -->
        <div class="bg-white rounded-xl border p-5">
            <h3 class="font-semibold mb-4">Analyse rapide</h3>

            <div class="flex justify-center">
                <canvas id="expenseDonutChart" width="200" height="200"></canvas>
            </div>

            <div class="mt-6 space-y-2 text-xs">

                <div class="flex justify-between">
                    <span>Entrées</span>
                    <span class="text-emerald-500 font-semibold">
                        {{ number_format($totalEntrees, 0, ',', ' ') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span>Sorties</span>
                    <span class="text-rose-500 font-semibold">
                        {{ number_format($totalSorties, 0, ',', ' ') }}
                    </span>
                </div>

                <div class="flex justify-between">
                    <span>Solde</span>
                    <span class="text-blue-600 font-semibold">
                        {{ number_format($tresorerie, 0, ',', ' ') }}
                    </span>
                </div>

            </div>
        </div>

    </div>

    <!-- ===================== KPIs ===================== -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="bg-white rounded-xl border p-5">
            <h3 class="font-semibold">Performance</h3>
            <p class="text-2xl font-bold mt-2">74%</p>
            <div class="w-full bg-gray-100 rounded-full h-2 mt-2">
                <div class="bg-indigo-500 h-2 rounded-full" style="width:74%"></div>
            </div>
        </div>

        <div class="bg-white rounded-xl border p-5">
            <h3 class="font-semibold">Santé financière</h3>
            <p class="text-2xl font-bold mt-2">B+</p>
            <div class="w-full bg-gray-100 rounded-full h-2 mt-2">
                <div class="bg-amber-500 h-2 rounded-full" style="width:68%"></div>
            </div>
        </div>

        <div class="bg-white rounded-xl border p-5">
            <h3 class="font-semibold">Croissance</h3>
            <p class="text-2xl font-bold mt-2">+12%</p>
            <div class="w-full bg-gray-100 rounded-full h-2 mt-2">
                <div class="bg-emerald-500 h-2 rounded-full" style="width:72%"></div>
            </div>
        </div>

    </div>

    <!-- ===================== RECOMMANDATION ===================== -->
    <div class="bg-blue-50 border-l-4 border-blue-500 rounded-lg p-4">
        <div class="flex">
            <iconify-icon icon="solar:chat-square-check-linear" class="text-blue-600 text-xl mr-3"></iconify-icon>

            <div>
                <h4 class="font-semibold text-blue-800 text-sm">Recommandation système</h4>
                <p class="text-blue-700 text-xs">
                    Analyse automatique : vos entrées dépassent les sorties, la trésorerie est positive.
                    Pensez à renforcer le marketing pour accélérer la croissance.
                </p>
            </div>
        </div>
    </div>

</div>
@endsection

{{-- ===================== SCRIPTS CHART ===================== --}}
@push('scripts')
<script>
    const entrees = @json($entreesParMois);
    const sorties = @json($sortiesParMois);

    new Chart(document.getElementById('cashflowChart'), {
        type: 'line',
        data: {
            labels: ['Jan', 'Fév', 'Mar'],
            datasets: [
                {
                    label: 'Entrées',
                    data: entrees,
                    borderColor: '#10b981',
                    backgroundColor: 'rgba(16,185,129,0.05)',
                    tension: 0.4,
                    fill: true
                },
                {
                    label: 'Sorties',
                    data: sorties,
                    borderColor: '#fb7185',
                    backgroundColor: 'rgba(251,113,133,0.05)',
                    tension: 0.4,
                    fill: true
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            }
        }
    });

    new Chart(document.getElementById('expenseDonutChart'), {
        type: 'doughnut',
        data: {
            labels: ['Entrées', 'Sorties'],
            datasets: [{
                data: [{{ $totalEntrees }}, {{ $totalSorties }}],
                backgroundColor: ['#10b981', '#fb7185'],
                borderWidth: 0
            }]
        },
        options: {
            cutout: '70%',
            plugins: {
                legend: { display: false }
            }
        }
    });
</script>
@endpush