<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::orderBy('date', 'desc')->get();
        $totalEntrees = Transaction::where('type', 'entree')->sum('montant');
        $totalSorties = Transaction::where('type', 'sortie')->sum('montant');
        $solde = $totalEntrees - $totalSorties;
        $transactions = Transaction::with('user', 'departement')->get();
        $departements = Departement::all();

        
        return view('auth.finances.transactions.index', compact('transactions','departements', 'totalEntrees', 'totalSorties', 'solde'));
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
            'departement_id' => 'required',
            'montant' => 'required|numeric|min:1',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ], [
            'label.required' => 'Veuillez remplir le champ label',
            'type.required' => 'Veuillez sélectionner un type',
            'departement_id.required' => 'Veuillez sélectionner un département',
            'montant.required' => 'Veuillez saisir un montant',
            'montant.numeric' => 'Le montant doit être un nombre valide',
            'montant.min' => 'Le montant doit être au moins 1 FCFA',
            'date.required' => 'Veuillez sélectionner une date'
        ]);

        Transaction::create([
                'user_id' => auth()->id(), // ← RÉCUPÈRE L'ID DE L'UTILISATEUR CONNECTÉ
                'type' => $request->type ,
                'label' => $request->label,
                'departement_id' => $request->departement_id,
                'montant' => $request->montant,
                'date'=> $request->date,
                'description' => $request->description,
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
                'departement_id' => $request->departement_id,
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