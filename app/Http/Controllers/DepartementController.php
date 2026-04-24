<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::all();
        return view('departements.show', compact('departements'));
    }

    public function create()
    {
        return view('departements.create');
    }

    public function store(Request $request)
    {
        Departement::create($request->all());
        return redirect()->route('departements.index');
    }

    public function edit($id)
    {
        $departement = Departement::findOrFail($id);
        return view('departements.update', compact('departement'));
    }

    public function update(Request $request, $id)
    {
        $departement = Departement::findOrFail($id);
        $departement->update($request->all());
        return redirect()->route('departements.index');
    }

    public function destroy($id)
    {
        $departement = Departement::findOrFail($id);
        $departement->delete();
        return redirect()->route('departements.index');
    }

    public function show($id)
    {
        $departement = Departement::findOrFail($id);
        return view('departements.detail', compact('departement'));
    }
}