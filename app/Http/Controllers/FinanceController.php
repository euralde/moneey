<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::orderBy('date', 'desc')->get();
        $totalEntrees = Finance::where('type', 'entree')->sum('montant');
        $totalSorties = Finance::where('type', 'sortie')->sum('montant');
        $solde = $totalEntrees - $totalSorties;
        
        return view('auth.finances.transactions.detail', compact('finances', 'totalEntrees', 'totalSorties', 'solde'));
    }

    public function create()
    {
        return view('auth.finances.transactions.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titre' => 'required|unique:departements|max:255',
            'description' => 'nullable',
            'type' => 'required|in:actif,inactif',
        ], [
            'montant.required' => 'Nom est requis',
            'categorie.unique' => 'Nom doit etre unique',
            'date.required' => 'Statut est requis',
            'status.in' => 'Statut doit etre actif ou inactif',
        ]);

        if ($validator->fails()) {
            return redirect()->route('departements.create')
                ->withErrors($validator)
                ->withInput();
        };

        Finance::create($request->all());
        return redirect()->route('finances.index')->with('success', 'Transaction ajoutée avec succès');
    }

    public function show($id)
    {
        $finance = Finance::findOrFail($id);
        return view('auth.finances.transactions.show', compact('finance'));
    }

    public function edit($id)
    {
        $finance = Finance::findOrFail($id);
        return view('auth.finances.transactions.edit', compact('finance'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'type' => 'required',
            'categorie' => 'required',
            'montant' => 'required|numeric|min:1',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ], [
            'titre.required' => 'Veuillez remplir le champ Titre',
            'type.required' => 'Veuillez sélectionner un type',
            'categorie.required' => 'Veuillez sélectionner un département',
            'montant.required' => 'Veuillez saisir un montant',
            'montant.numeric' => 'Le montant doit être un nombre valide',
            'montant.min' => 'Le montant doit être au moins 1 FCFA',
            'date.required' => 'Veuillez sélectionner une date'
        ]);

        $finance = Finance::findOrFail($id);
        $finance->update($request->all());
        return redirect()->route('finances.index')->with('success', 'Transaction modifiée avec succès');
    }

    public function destroy($id)
    {
        $finance = Finance::findOrFail($id);
        $finance->delete();
        return redirect()->route('finances.index')->with('success', 'Transaction supprimée avec succès');
    }
}