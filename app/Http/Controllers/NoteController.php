<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get();
        return view('auth.notes.index', compact('notes'));
    }

    public function create()
    {
        return view('auth.notes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string'
        ]);

        Note::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id()
        ]);

        return redirect()->route('notes.index')->with('success', 'Note ajoutée');
    }

    public function edit($id)
    {
        $note = Note::findOrFail($id);

        if ($note->user_id !== Auth::id()) abort(403);
        return view('auth.notes.edit', compact('note'));
    }

    public function update(Request $request, $id)
    {
        $note = Note::findOrFail($id);

        if ($note->user_id !== Auth::id()) abort(403);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string'
        ]);

        $note->update([
            'title' => $request->title,
            'content' => $request->content
        ]);

        return redirect()->route('notes.index')->with('success', 'Note modifiée');
    }

    public function destroy($id)
    {
        $note = Note::findOrFail($id);

        if ($note->user_id !== Auth::id()) abort(403);
        $note->delete();
        return redirect()->route('notes.index')->with('success', 'Note supprimée');
    }
}