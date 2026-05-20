<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // =========================
        // 🔵 GÉRANT (users uniquement)
        // =========================
        if ($user->profil === 'gerant') {

            $totalEntrees = Transaction::where('type', 'entree')->sum('montant');
            $totalSorties = Transaction::where('type', 'sortie')->sum('montant');

            $tachesUrgentes = Task::where('status', 'a-faire')
                ->where('priority', 'urgent')
                ->count();

            $transactions = Transaction::select(
                    DB::raw("DATE(CONVERT_TZ(created_at, '+00:00', '+01:00')) as jour"),
                    'type',
                    DB::raw('SUM(montant) as total')
                )
                ->groupBy('jour', 'type')
                ->orderBy('jour')
                ->get();

            $jours = $transactions
                ->pluck('jour')
                ->unique()
                ->values();

            $entreesParJour = [];
            $sortiesParJour = [];

            foreach ($jours as $jour) {

                $entree = $transactions
                    ->where('jour', $jour)
                    ->where('type', 'entree')
                    ->first();

                $sortie = $transactions
                    ->where('jour', $jour)
                    ->where('type', 'sortie')
                    ->first();

                $entreesParJour[] = $entree ? $entree->total : 0;

                $sortiesParJour[] = $sortie ? $sortie->total : 0;
            }
        }

        // =========================
        // 🟢 EMPLOYÉ / MANAGER
        // =========================
        else {

            $employe = $user->employee;

            if (!$employe) {
                abort(403);
            }

            $departmentId = $employe->department_id;

            $totalEntrees = Transaction::where('type', 'entree')
                ->where('department_id', $departmentId)
                ->sum('montant');

            $totalSorties = Transaction::where('type', 'sortie')
                ->where('department_id', $departmentId)
                ->sum('montant');

            $tachesUrgentes = Task::where('status', 'a-faire')
                ->where('priority', 'urgente')
                ->count();

            $transactions = Transaction::select(
                    DB::raw("DATE(CONVERT_TZ(created_at, '+00:00', '+01:00')) as jour"),
                    'type',
                    DB::raw('SUM(montant) as total')
                )
                ->where('department_id', $departmentId)
                ->groupBy('jour', 'type')
                ->orderBy('jour')
                ->get();

            $jours = $transactions
                ->pluck('jour')
                ->unique()
                ->values();

            $entreesParJour = [];
            $sortiesParJour = [];

            foreach ($jours as $jour) {

                $entree = $transactions
                    ->where('jour', $jour)
                    ->where('type', 'entree')
                    ->first();

                $sortie = $transactions
                    ->where('jour', $jour)
                    ->where('type', 'sortie')
                    ->first();

                $entreesParJour[] = $entree ? $entree->total : 0;

                $sortiesParJour[] = $sortie ? $sortie->total : 0;
            }
        }

        $tresorerie = $totalEntrees - $totalSorties;

        return view('auth.dashboard', compact(
            'totalEntrees',
            'totalSorties',
            'tresorerie',
            'tachesUrgentes',
            'entreesParJour',
            'sortiesParJour',
            'jours'
        ));
    }
}
