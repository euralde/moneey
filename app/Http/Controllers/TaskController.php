<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    // AFFICHAGE (vue calendrier)
    public function index()
    {
      $tasks = Task::all();   
        return view('auth.tasks.index');
    }

    // API : récupérer toutes les tâches de l'utilisateur
    public function apiIndex()
    {
        $tasks = Task::where('user_id', Auth::id())->get();
        return response()->json($tasks);
    }

    // API : créer une tâche
    public function apiStore(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:basse,moyenne,haute,urgent',
            'date' => 'required|date',
        ]);

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->date,
            'user_id' => Auth::id(),
        ]);

        return response()->json($task);
    }

    // API : modifier une tâche
    public function apiUpdate(Request $request, $id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'required|in:basse,moyenne,haute,urgent',
            'date' => 'required|date',
        ]);

        $task->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'due_date' => $request->date,
        ]);

        return response()->json($task);
    }

    // API : supprimer une tâche
    public function apiDestroy($id)
    {
        $task = Task::where('user_id', Auth::id())->findOrFail($id);
        $task->delete();
        return response()->json(['success' => true]);
    }

    // Méthodes CRUD classiques (si encore utilisées ailleurs)
    public function create()
    {
        return view('auth.taches.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:urgent,haute,moyenne,basse',
            'due_date' => 'nullable|date',
        ]);

        Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority ?? 'moyenne',
            'due_date' => $request->due_date,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('task.index')->with('success', 'Tâche ajoutée');
    }

    public function edit($id)
    {
        $tache = Task::findOrFail($id);
        if ($tache->user_id !== Auth::id()) abort(403);
        return view('auth.taches.edit', compact('tache'));
    }

    public function update(Request $request, $id)
    {
        $tache = Task::findOrFail($id);
        if ($tache->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'priority' => 'nullable|in:urgent,haute,moyenne,basse',
            'due_date' => 'nullable|date',
        ]);

        $tache->update([
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority ?? $tache->priority,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('taches.index')->with('success', 'Tâche modifiée');
    }

    public function destroy($id)
    {
        $tache = Task::findOrFail($id);
        if ($tache->user_id !== Auth::id()) abort(403);
        $tache->delete();
        return redirect()->route('taches.index')->with('success', 'Tâche supprimée');
    }

    public function complete($id)
    {
        $tache = Task::findOrFail($id);
        if ($tache->user_id !== Auth::id()) abort(403);
        $tache->update(['is_completed' => true]);
        return redirect()->route('taches.index')->with('success', 'Tâche terminée');
    }

    public function uncomplete($id)
    {
        $tache = Task::findOrFail($id);
        if ($tache->user_id !== Auth::id()) abort(403);
        $tache->update(['is_completed' => false]);
        return redirect()->route('taches.index')->with('success', 'Tâche remise en cours');
    }
}