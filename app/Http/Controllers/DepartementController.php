<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DepartementController extends Controller
{
    //Page pour afficher la liste de departements
    public function index()
    {
        $departements = Departement::all();

        return view('auth.departments.show', ['departements' => $departements]);
    }

    //Page pour ajouter un departement
    public function create()
    {
        return view('auth.departments.create');
    }

    //Page pour editer un departement
    public function edit($id)
    {
        $departement = Departement::find($id);
        if ($departement === null) {
            abort(404);
        }
        return view('auth.departments.edit', ['departement' => $departement]);
    }

    //Function pour ajouter un departement dans la base de donnee
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departements|max:255',
            'description' => 'nullable',
            'status' => 'required|in:actif,inactif',
        ], [
            'name.required' => 'Nom est requis',
            'name.unique' => 'Nom doit etre unique',
            'status.required' => 'Statut est requis',
            'status.in' => 'Statut doit etre actif ou inactif',
        ]);

        if ($validator->fails()) {
            return redirect()->route('departements.create')
                ->withErrors($validator)
                ->withInput();
        }

        Departement::create($request->all());

        Alert::success('Département ajouté avec succès');
        return redirect()->route('departements.index');
    }

    //Function pour modifier un departement
    public function update(Request $request, $id)
    {
        $departement = Departement::find($id);
        $departement->update($request->all());

        Alert::success('Département modifié avec succès');

        return redirect()->route('departements.index');
    }

    //Function pour supprimer un departement
    public function destroy($id)
    {
        $departement = Departement::find($id);
        $departement->delete();
        Alert::success('Département supprimé avec succès');
        return redirect()->route('departements.index');
    }
}