<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Transaction;
use App\Models\Task;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // =========================
        // VARIABLES
        // =========================
        $departmentId = null;
        $departementsData = [];

        // =========================
        // GÉRANT
        // =========================
        if ($user->profil === 'gerant') {

            $totalEntrees = Transaction::where('type', 'entree')
                ->sum('montant');

            $totalSorties = Transaction::where('type', 'sortie')
                ->sum('montant');

            // =========================
            // GRAPHE PAR DÉPARTEMENT
            // =========================
            $departements = Departement::all();

            foreach ($departements as $departement) {

                $entrees = Transaction::where(
                        'department_id',
                        $departement->id
                    )
                    ->where('type', 'entree')
                    ->sum('montant');

                $sorties = Transaction::where(
                        'department_id',
                        $departement->id
                    )
                    ->where('type', 'sortie')
                    ->sum('montant');

                $departementsData[] = [

                    'name' => $departement->name,

                    'entrees' => $entrees,

                    'sorties' => $sorties
                ];
            }
        }

        // =========================
        // EMPLOYÉ / MANAGER
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
        }

        // =========================
        // TÂCHES
        // =========================
        $tachesUrgentes = Task::where('status', 'a-faire')
            ->whereIn('priority', ['urgent', 'urgente'])
            ->count();

        // =========================
        // TRANSACTIONS
        // =========================
        $transactionsQuery = Transaction::select(
                DB::raw("
                    DATE(
                        CONVERT_TZ(
                            created_at,
                            '+00:00',
                            '+01:00'
                        )
                    ) as jour
                "),
                'type',
                DB::raw('SUM(montant) as total')
            );

        // FILTRE SI EMPLOYÉ
        if ($departmentId) {

            $transactionsQuery->where(
                'department_id',
                $departmentId
            );
        }

        $transactions = $transactionsQuery
            ->groupBy('jour', 'type')
            ->orderBy('jour')
            ->get();

        // =========================
        // FORMATAGE DATA
        // =========================
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

            $entreesParJour[] =
                $entree ? $entree->total : 0;

            $sortiesParJour[] =
                $sortie ? $sortie->total : 0;
        }

        // =========================
        // TRÉSORERIE
        // =========================
        $tresorerie =
            $totalEntrees - $totalSorties;

        // =========================
        // VIEW
        // =========================
        return view('auth.dashboard', compact(

            'totalEntrees',
            'totalSorties',
            'tresorerie',
            'tachesUrgentes',

            'entreesParJour',
            'sortiesParJour',
            'jours',

            'departementsData'
        ));
    }
}