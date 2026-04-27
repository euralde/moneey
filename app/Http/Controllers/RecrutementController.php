<?php

namespace App\Http\Controllers;

use App\Models\Recrutement;
use Illuminate\Http\Request;

class RecrutementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('auth.recrutements.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.recrutements.create');

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
    public function show(Recrutement $recrutement)
    {
        return view('auth.recrutements.details');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Recrutement $recrutement)
    {
        return view('auth.recrutements.edit');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Recrutement $recrutement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Recrutement $recrutement)
    {
        //
    }
}
