<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index()
    {
        // 💰 Totaux
        $totalEntrees = Transaction::where('type', 'entree')->sum('montant');
        $totalSorties = Transaction::where('type', 'sortie')->sum('montant');
        $tresorerie = $totalEntrees - $totalSorties;

        // ⚡ Tâches urgentes
        $tachesUrgentes = Task::where('status', 'pending')
            ->where('priority', 'high')
            ->count();

        // 📊 Graph (3 derniers mois)
        $entreesParMois = Transaction::selectRaw('MONTH(date) as mois, SUM(montant) as total')
            ->where('type', 'entree')
            ->groupBy('mois')
            ->pluck('total');

        $sortiesParMois = Transaction::selectRaw('MONTH(date) as mois, SUM(montant) as total')
            ->where('type', 'sortie')
            ->groupBy('mois')
            ->pluck('total');

        return view('auth.dashboard', compact(
            'totalEntrees',
            'totalSorties',
            'tresorerie',
            'tachesUrgentes',
            'entreesParMois',
            'sortiesParMois'
        ));
    }
}
