<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Departement;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'password' => 'required',
        ],[
            'email.required' => 'Email est requis',
            'password.required' => 'Mot de passe est requis',
        ]);

        if ($validator->fails()) {
            return redirect('/')
                ->withErrors($validator)
                ->withInput();
        }

        //$validated = $request->validated();

        $credentails = $request->only('email','password');
        //Recherche sur la documentation de laravel notion de validation validator
        if (Auth::attempt($credentails)) {
            //connexion reussie->redirection
            return redirect()->route('dashboard');
        }

        //echec->retour avec message
        return back()->withErrors(['email'=>'Identifiants incorrects']);
    }

    
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }

    //afficher les utilisateurs
    public function index()
    {
        $users = User::all();
        $users = User::with('departements')->get();

        //récupère les utilisateurs
        return view('auth.utilisateurs.users', compact('users'));
    }

    public function creatusers()
    {
        return view('auth.utilisateurs.create_users');
    }

    //insertion des utilisateurs dans la base de données
    public function store(Request $request)
    {
        $request->validate([
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);

        User::create([
            'lastname' => $request->lastname,
            'firstname' => $request->firstname,
            'email' => $request->email,
            'password' => Hash::make($request->email),
            'status' => $request->status,
            'profil' => $request->profil
        ]);

        Alert::success('Utilisateur ajouté avec succès');
        return redirect()->route('users.index');
    }

    // ✏️ afficher formulaire
    public function edit($id)
    {
        $user = User::find($id);
        if ($user === null) {
            abort(404);
        }
        return view('auth.utilisateurs.edit_users', ['user' => $user]);
    }

    // ✏️ modifier
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->lastname = $request->lastname;
        $user->firstname = $request->firstname;
        $user->email = $request->email;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->status = $request->status;
        $user->profil = $request->profil;

        $user->save();

        return redirect()->route('users')->with('success', 'Utilisateur modifié');
    }

    // 🗑️ supprimer
    public function destroy($id)
    {
        $user = User::find($id);

        $user->delete();
        Alert::success('Utilisateurs supprimé avec succès');
        return redirect()->route('users.index');
    }

    public function attribuer($id)
    {
        $user = User::find($id);
        $departements = Departement::all();
        if ($user === null) {
            abort(404);
        }
        return view('auth.affectations.attribuer', ['user' => $user,'departements' => $departements]);
    }
}
