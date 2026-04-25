<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use Illuminate\Http\Request;

class DepartementController extends Controller
{
    public function index()
    {
        $departements = Departement::all();
        return view('auth.departments.show',['departements'=>$departements]);
    }

    public function create()
    {
        return view('auth.departments.create');
    }

    public function store(Request $request)
    {
        Departement::create($request->all());
        return redirect()->route('departements.index');
    }
}