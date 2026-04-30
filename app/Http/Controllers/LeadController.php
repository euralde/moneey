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
    public function index()
    {
        $leads = Lead::with('assignedTo')->latest()->get();
        $users = User::all();

        // Statistiques
        $totallead = Lead::count();
        $totalnouveau = Lead::where('status', 'nouveau')->count();
        $totalcontacte = Lead::where('status', 'contacte')->count();
        $totalrdv = Lead::where('status', 'rdv')->count();
        $totalnegocation = Lead::where('status', 'negocation')->count();
        $totalgagne = Lead::where('status', 'gagne')->count();
        $totalperdu = Lead::where('status', 'perdu')->count();

        return view('auth.leads.index', compact('leads', 'users', 'totallead', 'totalnouveau', 'totalcontacte', 'totalrdv', 'totalnegocation', 'totalgagne', 'totalperdu'));
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
            'assigned_to' => 'required',
            'notes' => 'nullable',
        ], [
            'name.required' => 'Nom est requis',
            'name.unique' => 'Nom doit etre unique',
            'email.required' => 'Email requis',
            'phone.required' => 'Numéro de téléphone requis',
            'assigned_to.required' => 'Utilisateur assigné requis',
            'source.required' => 'Source requise',
            'status.required' => 'requis',
        ]);

        if ($validator->fails()) {
            return redirect()->route('lead.index')
                ->withErrors($validator)
                ->withInput();
        }

        Lead::create([
            'name' => $request->name,
            'company' => $request->company,
            'email' => $request->email,
            'phone' => $request->phone,
            'source' => $request->source,
            'status' => $request->status,
            'assigned_to' => $request->assigned_to,
            'notes' => $request->notes,
        ]);

        return redirect()
            ->route('lead.index')
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
    public function update(Request $request, Lead $lead, $id)
    {
            $lead = Lead::findorfail($id);
            
                // Mettre à jour l'utilisateur
                $lead->update([
                    'name' => $request->name,
                    'company' => $request->company,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'source' => $request->source,
                    'status' => $request->status,
                    'assigned_to' => $request->assigned_to,
                    'notes' => $request->notes,
                ]);

                return redirect()->route('lead.index')->with('success', 'Employé modifié avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Lead $lead, $id)
    {
        $lead = Lead::findOrFail($id);
        $lead->delete();
                    
        return redirect()->route('lead.index')->with('success', 'Employé supprimé avec succès');
    }
}
