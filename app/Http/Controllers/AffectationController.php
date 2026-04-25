<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Departement;



class AffectationController extends Controller
{
    public function store(Request $request)
    {
        $user = User::findOrFail($request->user_id);

        $user->departements()->sync([$request->departement_id]);

        Alert::success('Département affecté avec succès');
        return redirect()->route('users.index');
    }

    
    public function create($id)
    {
        $users = User::findOrFail($id);
        $departements = Departement::all();

        return view('auth.affectations.attribuer', ['users' => $users, 'departements' => $departements]);
    }
}
