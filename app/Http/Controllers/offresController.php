<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Departement;
use App\Models\Recrutement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class offresController extends Controller
{
    public function index(Recrutement $recrutements)
    {
        $recrutements = Recrutement::with(['user', 'departement'])->get();
        return view('auth.offres.index',compact('recrutements'));
    }

    public function show(Recrutement $recrutement)
    {
        return view('auth.offres.show', compact('recrutement'));
    }

    public function store(Request $request, Recrutement $recrutement)
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:255',
            'email' => 'required',
            'phone' => 'required',
            'cv_url' => 'required|mimes:pdf,doc,docx|max:2048',
            'lettre_motivation' => 'nullable|mimes:pdf,doc,docx|max:2048',
        ], [
            'name.required' => 'Nom est requis',
            'email.required' => 'Email est requis',
            'phone.required' => 'Numéro de téléphone requis',
            'cv_url.required' => 'CV requis',
            'lettre_motivation.required' => 'Lettre de motivation requis',
        ]);

        if ($validator->fails()) {
            return redirect()->route('offres.show', $recrutement)
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

            Candidature::create([
                'recrutement_id' => $recrutement->id,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'cv_url' => $request->file('cv_url')->store('cvs', 'public'),
                'lettre_motivation' => $request->file('lettre_motivation')?$request->file('lettre_motivation')->store('lettres', 'public'): null,
                'status' => 'nouvelle',
            ]);

            DB::commit();

            return redirect()->route('offres.show', $recrutement)->with('success', 'Recrutement crée avec succès');
    }

}
