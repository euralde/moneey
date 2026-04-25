<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::all();
        return view('auth.messages.chat', compact('messages'));
    }

    public function create()
    {
        return view('auth.messages.create');
    }

    public function store(Request $request)
    {
        Message::create([
            'titre' => $request->titre ?? 'Message',
            'contenu' => $request->contenu,
            'expediteur' => 'Admin',
            'destinataire' => $request->destinataire,
            'status' => 'non_lu'
        ]);
        
        return redirect()->route('messages.index');
    }

    public function show($id)
    {
        $message = Message::findOrFail($id);
        $message->update(['status' => 'lu']);
        return view('auth.messages.show', compact('message'));
    }

    public function edit($id)
    {
        $message = Message::findOrFail($id);
        return view('auth.messages.edit', compact('message'));
    }

    public function update(Request $request, $id)
    {
        $message = Message::findOrFail($id);
        $message->update($request->all());
        return redirect()->route('messages.index');
    }

    public function destroy($id)
    {
        $message = Message::findOrFail($id);
        $message->delete();
        return redirect()->route('messages.index');
    }

    // Envoyer un message (AJAX)
    public function send(Request $request)
    {
        $message = Message::create([
            'titre' => 'Message',
            'contenu' => $request->contenu,
            'expediteur' => $request->expediteur ?? 'Admin',
            'destinataire' => $request->destinataire,
            'status' => 'non_lu'
        ]);
        
        return response()->json($message);
    }

    // Récupérer les messages d'une conversation (AJAX)
    public function getConversation($user)
    {
        $messages = Message::where('expediteur', $user)
            ->orWhere('destinataire', $user)
            ->orderBy('created_at', 'asc')
            ->get();
            
        return response()->json($messages);
    }
    
    // Récupérer la liste des utilisateurs (AJAX)
    public function getUsers()
    {
        $users = Message::select('expediteur')
            ->distinct()
            ->pluck('expediteur')
            ->filter(fn($u) => $u !== 'Admin')
            ->values()
            ->toArray();
            
        $destinataires = Message::select('destinataire')
            ->distinct()
            ->pluck('destinataire')
            ->filter(fn($u) => $u !== 'Admin')
            ->values()
            ->toArray();
            
        $allUsers = array_unique(array_merge($users, $destinataires));
        
        return response()->json(array_values($allUsers));
    }
}