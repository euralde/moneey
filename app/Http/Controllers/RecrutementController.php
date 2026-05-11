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
    public function index(Request $request)
    {
        $query = Recrutement::with(['user', 'departement', 'candidatures']);

        // Filtre par statut
        if ($request->filled('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Recherche
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Département
        if ($request->filled('department')) {

            $query->whereHas('user', function ($q) use ($request) {

                $q->where('department_id', $request->department);
            });
        }

        $recrutements = $query->latest()->get();

        // Statistiques
        $departements = Departement::all();
        $candidatures = Candidature::all();

        $totalOffres = Recrutement::count();
        $totalOuvertes = Recrutement::where('status', 'ouverte')->count();
        $totalEncours = Recrutement::where('status', 'encours')->count();
        $totalPourvue = Recrutement::where('status', 'pourvue')->count();
        $totalFermee = Recrutement::where('status', 'fermee')->count();
        $totalCandidatures = Candidature::count();

        return view('auth.recrutements.index', compact(
            'recrutements',
            'departements',
            'candidatures',
            'totalOffres',
            'totalOuvertes',
            'totalEncours',
            'totalPourvue',
            'totalFermee',
            'totalCandidatures'
        ));
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
