<?php

namespace App\Http\Controllers;

use App\Models\Tache;
use Illuminate\Http\Request;

class TacheController extends Controller
{
    public function index()
    {
        $taches = Tache::all();
     return view('auth.Tâches.detail', compact('taches'));
    }

    public function create()
    {
        return view('auth.Tâches.create');
    }

    public function store(Request $request)
    {
        Tache::create($request->all());
        return redirect()->route('taches.index');
    }

    public function show($id)
    {
        $tache = Tache::findOrFail($id);
        return view('auth.Tâches.detail', compact('tache'));
    }

    public function edit($id)
    {
        $tache = Tache::findOrFail($id);
        return view('auth.Tâches.edit', compact('tache'));
    }

    public function update(Request $request, $id)
    {
        $tache = Tache::findOrFail($id);
        $tache->update($request->all());
        return redirect()->route('taches.index');
    }

    public function destroy($id)
    {
        $tache = Tache::findOrFail($id);
        $tache->delete();
        return redirect()->route('taches.index');
    }
}