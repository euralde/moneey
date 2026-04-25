<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::orderBy('date', 'desc')->get();
        $totalEntrees = Finance::where('type', 'entree')->sum('montant');
        $totalSorties = Finance::where('type', 'sortie')->sum('montant');
        $solde = $totalEntrees - $totalSorties;
        
        return view('auth.finances.detail', compact('finances', 'totalEntrees', 'totalSorties', 'solde'));
    }

    public function create()
    {
        return view('auth.finances.create');
    }

    public function store(Request $request)
    {
        Finance::create($request->all());
        return redirect()->route('finances.index');
    }

    public function show($id)
    {
        $finance = Finance::findOrFail($id);
        return view('auth.finances.show', compact('finance'));
    }

    public function edit($id)
    {
        $finance = Finance::findOrFail($id);
        return view('auth.finances.edit', compact('finance'));
    }

    public function update(Request $request, $id)
    {
        $finance = Finance::findOrFail($id);
        $finance->update($request->all());
        return redirect()->route('finances.index');
    }

    public function destroy($id)
    {
        $finance = Finance::findOrFail($id);
        $finance->delete();
        return redirect()->route('finances.index');
    }
}