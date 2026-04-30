<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
            $tasks = Task::all();
        //liste des taches d'un utilisateur
        return view('auth.tasks.index', compact('tasks'));
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
        $task = Task::create([
            'user_id' => auth()->id(), // 🔥 important si tu as un user
            'title' => $request->title,
            'description' => $request->description,
            'priority' => $request->priority,
            'status' => 'a-faire', // valeur par défaut
            'start' => $request->start, // ✅
            'end' => $request->start, // ou null si tu veux
            'assignee' => null,
        ]);

        return redirect()->back()->with('success', 'Tâche ajoutée');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        $task->delete();
        return back();
    }
}
