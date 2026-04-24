<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
}
