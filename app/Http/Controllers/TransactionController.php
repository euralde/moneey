<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        // récupérer le département du user connecté
        $departmentId = optional($user->employee)->department_id;

        // Base query
        $query = Transaction::with('departement');

        /*
        |--------------------------------------------------------------------------
        | FILTRAGE PAR ROLE
        |--------------------------------------------------------------------------
        */

        if ($user->profil === 'gerant') {

            // 👔 Le gérant voit tout
            // aucun filtre

        } elseif ($user->profil === 'manager') {

            // 👨‍💼 Le manager voit seulement son département
            $query->where('department_id', $departmentId);

        } else {

            // 👤 Employé
            $query->where('department_id', $departmentId);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTRES DU FORMULAIRE
        |--------------------------------------------------------------------------
        */

        // filtre type
        if ($request->type && $request->type !== 'all') {
            $query->where('type', $request->type);
        }

        // filtre département
        if ($request->departement_id) {

            // empêcher manager/employé de voir un autre département
            if ($user->profil === 'gerant') {
                $query->where('department_id', $request->departement_id);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | RECUPERATION DES TRANSACTIONS
        |--------------------------------------------------------------------------
        */

        $transactions = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | STATISTIQUES
        |--------------------------------------------------------------------------
        */

        $totalEntrees = (clone $query)
            ->where('type', 'entree')
            ->sum('montant');

        $totalSorties = (clone $query)
            ->where('type', 'sortie')
            ->sum('montant');

        $solde = $totalEntrees - $totalSorties;

        $departements = Departement::all();

        return view('auth.finances.transactions.index', compact(
            'transactions',
            'totalEntrees',
            'totalSorties',
            'solde',
            'departements'
        ));
    }

    
    public function create()
    {
        return view('auth.finances.transactions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'type' => 'required',
            'department_id' => auth()->user()->profil === 'gerant'
                ? 'required'
                : 'nullable',
            'montant' => 'required|numeric|min:1',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ], [
            'label.required' => 'Veuillez remplir le champ label',
            'type.required' => 'Veuillez sélectionner un type',
            'department_id.required' => 'Veuillez sélectionner un département',
            'montant.required' => 'Veuillez saisir un montant',
            'montant.numeric' => 'Le montant doit être un nombre valide',
            'montant.min' => 'Le montant doit être au moins 1 FCFA',
            'date.required' => 'Veuillez sélectionner une date'
        ]);

        $user = auth()->user();

        $departmentId = optional($user->employee)->department_id;

        // 👔 gérant peut choisir
        if ($user->profil === 'gerant') {
            $departementId = $request->department_id;
        } else {
            // 👨‍💼 manager/employé forcé à son département
            $departementId = $departmentId;
        }

        Transaction::create([
            'user_id' => auth()->id(),
            'label' => $request->label,
            'date' => $request->date,
            'montant' => $request->montant,
            'type' => $request->type,
            'description' => $request->description,
            'department_id' => $departementId,
        ]);
        return redirect()->route('transactions.index')->with('success', 'Transaction ajoutée avec succès');
    }

    public function show($id)
    {
        $transaction = Transaction::findOrFail($id);
        return view('auth.finances.show', compact('transaction'));
    }

    public function edit($id)
    {
        $departements = Departement::all();
        $transaction = Transaction::findOrFail($id);
        return view('auth.finances.edit', compact('transaction','departements'));
    }

    public function update(Request $request, Transaction $transaction, $id)
    {
        Validator::make([
            'title'=>'',
        ],[
            'title'=>'required',
        ]);

        $transaction = Transaction::find($id);
            //    dd($transaction); 

        $transaction->update([
                'type' => $request->type ,
                'label' => $request->label,
                'department_id' => $request->department_id,
                'montant' => $request->montant,
                'description' => $request->description,
            ]);
        return redirect()->route('transactions.index')->with('success', 'Transaction ajoutée avec succès');
    }

    public function destroy($id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        return redirect()->route('transactions.index')->with('success', 'Transaction supprimée avec succès');
    }
}