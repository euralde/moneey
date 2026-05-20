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
        $user = auth()->user();

        $role = strtolower(trim($user->profil));

        $departmentId = optional($user->employee)->department_id;

        if ($role === 'gerant') {

            // 👔 Gérant = toutes les tâches
            $tasks = Task::with('user.employee')
                ->orderBy('start', 'asc')
                ->get();

        } elseif ($role === 'manager') {

            // 👨‍💼 Manager = ses tâches + celles du département
            $tasks = Task::with('user.employee')
                ->where(function ($query) use ($user, $departmentId) {

                    $query->where('user_id', $user->id)

                        ->orWhereHas('user.employee', function ($q) use ($departmentId) {
                            $q->where('department_id', $departmentId);
                        });
                })
                ->orderBy('start', 'asc')
                ->get();

        } else {

            // 👤 Employé = ses tâches uniquement
            $tasks = Task::with('user.employee')
                ->where('user_id', $user->id)
                ->orderBy('start', 'asc')
                ->get();
        }

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
        $user = auth()->user();

        // 👔 gérant peut tout supprimer
        if ($user->role === 'gerant') {
            $task->delete();
            return back()->with('success', 'Tâche supprimée');
        }

        // 👨‍💼 manager : ses tâches + département
        if ($user->role === 'manager') {

            $departmentId = optional($user->employee)->department_id;

            $sameDepartment = optional($task->user->employee)->department_id === $departmentId;

            if ($task->user_id === $user->id || $sameDepartment) {
                $task->delete();
                return back()->with('success', 'Tâche supprimée');
            }

            abort(403);
        }

        // 👤 employé : uniquement ses tâches
        if ($task->user_id !== $user->id) {
            abort(403);
        }

        $task->delete();

        return back()->with('success', 'Tâche supprimée');
    }
}
