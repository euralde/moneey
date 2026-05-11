<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\Departement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::with(['user', 'departement']);

        // 🔎 Recherche
        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('user', function ($q) use ($search) {

                $q->where('firstname', 'like', "%$search%")
                ->orWhere('lastname', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
            });
        }

        // 🟢 Statut
        if ($request->filled('status')) {

            $query->where('status', $request->status);
        }

        // 🏢 Département
        if ($request->filled('department')) {

            $query->whereHas('user', function ($q) use ($request) {

                $q->where('department_id', $request->department);
            });
        }

        // employés filtrés
        $employees = $query->get();

        // 📊 statistiques filtrées
        $totalEmployes = $employees->count();

        $totalActifs = $employees
            ->where('status', 'actif')
            ->count();

        $totalConge = $employees
            ->where('status', 'conge')
            ->count();

        $totalTeletravail = $employees
            ->where('status', 'teletravail')
            ->count();

        $totalDepartements = $employees->count();

        $departements = Departement::all();

        return view('auth.employes.index', compact(
            'employees',
            'departements',
            'totalEmployes',
            'totalActifs',
            'totalConge',
            'totalTeletravail',
            'totalDepartements'
        ));
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
        
        $validator = Validator::make($request->all(), [
            'lastname' => 'required',
            'firstname' => 'required',
            'email' => 'required|email|unique:users',
            'department_id' => 'required',
            'hire_date' => 'required',
            'poste' => 'required',
            'phone' => 'required',
        ], [
            'lastname.required' => 'Nom est requis',
            'firstname.required' => 'Prénom est requis',
            'email.required' => 'Email requis',
            'department_id.required' => 'Département requis',
            'poste.required' => 'Poste requis',
            'phone.required' => 'Numéro de téléphone requis',
            'hire_date.required' => 'Date d\'embauche requis',
        ]);

        if ($validator->fails()) {
            return redirect()->route('employes.index')
                ->withErrors($validator)
                ->withInput();
        }

        DB::beginTransaction();

            // 1️⃣ USER
            $user = User::create([
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'email' => $request->email,
                'phone' => $request->phone,
                'profil' => $request->profil,
                'password' => Hash::make($request->email), // temporaire
            ]);

            // 2️⃣ EMPLOYEE (LIÉ AU USER 🔥)
            Employee::create([
                'user_id' => $user->id,
                'department_id' => $request->department_id,
                'status' => 'actif',
                'hire_date' => $request->hire_date,
                'poste' => $request->poste,
                'skills' => $request->skills,
            ]);

            DB::commit();

            return back()->with('success', 'Employé ajouté');
    }

    /**
     * Display the specified resource.
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */

    // Dans EmployeeController.php

    public function update(Request $request, $id)
    { 
        
        $employee = Employee::with('user')->findOrFail($id);
        DB::beginTransaction();

        
            // Mettre à jour l'utilisateur
            $employee->user->update([
                'lastname' => $request->lastname,
                'firstname' => $request->firstname,
                'email' => $request->email,
                'phone' => $request->phone,
                'profil' => $request->profil,
                'password' => Hash::make($request->password), // temporaire
            ]);

            // Mettre à jour l'employé
            $employee->update([
                'department_id' => $request->department_id,
                'status' => $request->status,
                'poste' => $request->poste,
                'skills' => $request->skills,
            ]);

        DB::commit();

            return redirect()->route('employes.index')->with('success', 'Employé modifié avec succès');
    }

    public function destroy(Employee $employee, $id)
    {
            $employee = Employee::findOrFail($id);
            $user = $employee->user;

            $employee->delete();

            if ($user) {
                $user->delete();
            }

            
            return redirect()->route('employes.index')->with('success', 'Employé supprimé avec succès');
    }
}
