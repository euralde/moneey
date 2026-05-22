<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LeadController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Lead::with(['assignedTo.employee']);

        // =========================
        // RÔLES
        // =========================

        if ($user->profil === 'gerant') {
            // voit tout
        }

        elseif ($user->profil === 'manager') {

            $departementId = $user->employee?->department_id;

            $query->whereHas('assignedTo.employee', function ($q) use ($departementId) {
                $q->where('department_id', $departementId);
            });
        }

        else { // employé

            $query->where('assigned_to', $user->id);
        }

        // =========================
        // FILTRES
        // =========================

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%")
                ->orWhere('company', 'like', "%$search%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('source')) {
            $query->where('source', $request->source);
        }

        $leads = $query->latest()->get();

        // =========================
        // STATS
        // =========================

        $totallead = $leads->count();

        $totalnouveau = $leads->where('status', 'nouveau')->count();
        $totalcontacte = $leads->where('status', 'contacte')->count();
        $totalrdv = $leads->where('status', 'rdv')->count();
        $totalnegocation = $leads->where('status', 'negociation')->count();
        $totalgagne = $leads->where('status', 'gagne')->count();
        $totalperdu = $leads->where('status', 'perdu')->count();

        // employés visibles
        $users = User::all();

        return view('auth.leads.index', compact(
            'leads',
            'users',
            'totallead',
            'totalnouveau',
            'totalcontacte',
            'totalrdv',
            'totalnegocation',
            'totalgagne',
            'totalperdu'
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
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'source' => 'required',
            'status' => 'required',
            'assigned_to' => 'nullable',
            'notes' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lead.index')
                ->withErrors($validator)
                ->withInput();
        }

        $user = auth()->user();

        Lead::create([
            'name' => $request->name,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => $request->source,
            'status' => $request->status,

            // 👇 logique importante
            'assigned_to' => $user->profil === 'employe'
                ? $user->id
                : $request->assigned_to,

            'notes' => $request->notes,
        ]);

        return redirect()->route('lead.index')
            ->with('success', 'Lead ajouté avec succès');
    }
    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'phone' => 'required',
            'source' => 'required',
            'status' => 'required',
            'assigned_to' => 'nullable',
            'notes' => 'nullable',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lead.index')
                ->withErrors($validator, 'updateLead')
                ->withInput()
                ->with('edit_lead_id', $id);
        }

        $lead = Lead::findOrFail($id);
        $user = auth()->user();

        $lead->update([
            'name' => $request->name,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => $request->source,
            'status' => $request->status,

            // 👇 sécurité rôle
            'assigned_to' => $user->profil === 'employe'
                ? $user->id
                : $request->assigned_to,

            'notes' => $request->notes,
        ]);

        return redirect()->route('lead.index')
            ->with('success', 'Lead modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete($id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
                    
        return redirect()->route('lead.index')->with('success', 'Employé supprimé avec succès');
    }
}
