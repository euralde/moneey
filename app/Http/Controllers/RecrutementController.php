<?php

namespace App\Http\Controllers;

use App\Models\Candidature;
use App\Models\Departement;
use App\Models\Recrutement;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class RecrutementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $recrutements = Recrutement::with(['user', 'departement', 'candidatures'])->get();
        $departements = Departement::all();
        $candidatures = Candidature::all();

        // Statistiques
        $totalOffres = Recrutement::count();
        $totalOuvertes = Recrutement::where('status', 'ouverte')->count();
        $totalencours = Recrutement::where('status', 'encours')->count();
        $totalpourvue = Recrutement::where('status', 'pourvue')->count();
        $totalfermée = Recrutement::where('status', 'fermee')->count();
        
        return view('auth.recrutements.index', compact('recrutements', 'candidatures', 
            'departements', 
            'totalOffres', 
            'totalOuvertes', 
            'totalencours', 
            'totalpourvue', 
            'totalfermée'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $departements = Departement::all();

        return view('auth.recrutements.create', compact('departements'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'deadline' => 'required',
            'department_id' => 'required',
            'requirements' => 'required',
            'location' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:ouverte, encours, pourvue, fermee',
        ], [
            'title.required' => 'Titre est requis',
            'deadline.required' => 'Date limite est requis',
            'department_id.required' => 'Département est requis',
            'requirements.required' => 'Compétences est requis',
            'location.required' => 'Localisation est requis',
            'status.required' => 'Statut est requis',
            'status.in' => 'Statut doit etre ouverte, encours, pourvue ou fermee',
        ]);

        if ($validator->fails()) {
            return redirect()->route('recrutement.create')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

            Recrutement::create([
                'user_id' => auth()->id(),
                'department_id' => $request->department_id,
                'title' => $request->title,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'location' => $request->location,
                'status' => $request->status,
                'deadline' => $request->deadline
            ]);

            DB::commit();

            return redirect()->route('recrutement.index')->with('success', 'Recrutement crée avec succès');
    }

    /**
     * Display the specified resource.
     */
    public function show(Recrutement $recrutement, $id)
    {
        $recrutement = Recrutement::find($id);
        $departements = Departement::all();
        $candidatures = Candidature::all();
        $totalCandidatures = Candidature::count();
        return view('auth.recrutements.details', compact('recrutement', 'departements','candidatures','totalCandidatures'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recrutement $recrutement, $id)
    {
        $recrutement = Recrutement::find($id);
        $departements = Departement::all();
        return view('auth.recrutements.edit', compact('recrutement','departements'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recrutement $recrutement, $id)
    {

        $recrutement = Recrutement::find($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'deadline' => 'required',
            'department_id' => 'required',
            'requirements' => 'required',
            'location' => 'required',
            'description' => 'nullable',
            'status' => 'required|in:ouverte, encours, pourvue, fermee',
        ], [
            'title.required' => 'Titre est requis',
            'deadline.required' => 'Date limite est requis',
            'department_id.required' => 'Département est requis',
            'requirements.required' => 'Compétences est requis',
            'location.required' => 'Localisation est requis',
            'status.required' => 'Statut est requis',
            'status.in' => 'Statut doit etre ouverte, encours, pourvue ou fermee',
        ]);

        if ($validator->fails()) {
            return redirect()->route('recrutement.edit', $id)
                ->withErrors($validator)
                ->withInput();
        }

        $recrutement->update($request->all());

        Alert::success('Recrutement modifié avec succès');

        return redirect()->route('recrutement.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recrutement $recrutement, $id)
    {
        $recrutement = Recrutement::find($id);
        $recrutement->delete();
        Alert::success('Recrutement supprimé avec succès');
        return redirect()->route('recrutement.index');
    }
}
