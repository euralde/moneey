<?php

namespace App\Http\Controllers;

use App\Models\candidature;
use App\Models\Candidature as ModelsCandidature;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Can;
use RealRashid\SweetAlert\Facades\Alert;

class CandidatureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Candidature $candidature, $id)
    {
        $candidature = Candidature::find($id);
        return view('auth.candidatures.show', compact('candidature'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(candidature $candidature)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, candidature $candidature)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidature $candidature, $id)
    {
        $candidature = Candidature::find($id);
        $candidature->delete();
        Alert::success('Candidature supprimé avec succès');
        return redirect()->route('recrutement.show', $id);
    }
}
