<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class DepartementController extends Controller
{
    //Page pour afficher la liste de departements
    public function index()
    {
        $departements = Departement::with('manager')->get();

        return view('auth.departments.show', ['departements' => $departements]);
    }

    //Page pour ajouter un departement
    public function create()
    {
        $users = User::where('profil', 'manager')
        ->whereNotIn('id', Departement::whereNotNull('manager_id')->pluck('manager_id'))
        ->get();

        return view('auth.departments.create', compact('users'));
    }

    //Page pour editer un departement
    public function edit($id)
    {
        $departement = Departement::find($id);

        if ($departement === null) {
            abort(404);
        }

        $users = User::where('profil', 'manager')
            ->where(function ($query) use ($departement) {

                // managers non affectés
                $query->whereNotIn('id',
                    Departement::whereNotNull('manager_id')
                        ->where('id', '!=', $departement->id)
                        ->pluck('manager_id')
                )

                // ou le manager actuel du département
                ->orWhere('id', $departement->manager_id);
            })
            ->get();

        return view('auth.departments.edit', compact('departement', 'users'));
    }

    //Function pour ajouter un departement dans la base de donnee
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departements|max:255',
            'description' => 'nullable',
            'status' => 'required|in:actif,inactif',
            'manager_id' => 'nullable|exists:users,id',
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

        $department = Departement::create($request->all());

        if ($request->manager_id) {
            $manager = Employee::where('user_id', $request->manager_id)->first();

            if ($manager) {
                $manager->update([
                    'department_id' => $department->id
                ]);
            }
        }
        return redirect()->route('departements.index')->with('success', 'Département ajouté avec succès');
    }

    //Function pour modifier un departement
    public function update(Request $request, $id)
    {

        $department = Departement::find($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:departements,name,' . $id,
            'description' => 'nullable',
            'status' => 'required|in:actif,inactif',
            'manager_id' => 'nullable|exists:users,id',
        ], [
            'name.required' => 'Nom est requis',
            'name.unique' => 'Nom doit etre unique',
            'status.required' => 'Statut est requis',
            'status.in' => 'Statut doit etre actif ou inactif',
        ]);

        if ($validator->fails()) {
            return redirect()->route('departements.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }
        $department->update($request->all());

        if ($request->manager_id) {
            $manager = Employee::where('user_id', $request->manager_id)->first();

            if ($manager) {
                $manager->update([
                    'department_id' => $department->id
                ]);
            }
        }
        return redirect()->route('departements.index')->with('success', 'Département modifié avec succès');
    }

    //Function pour supprimer un departement
    public function destroy($id)
    {
        $departement = Departement::find($id);
        $departement->delete();
        return redirect()->route('departements.index')->with('success', 'Département supprimé avec succès');
    }
}