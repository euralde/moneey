<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConversationController extends Controller
{
    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();

        foreach ($users as $user) {
            $conversation = Conversation::where(function ($q) use ($user) {
                $q->where('sender_id', Auth::id())->where('receiver_id', $user->id);
            })->orWhere(function ($q) use ($user) {
                $q->where('sender_id', $user->id)->where('receiver_id', Auth::id());
            })->first();

            $user->unread_count = 0;
            if ($conversation) {
                $user->unread_count = Message::where('conversation_id', $conversation->id)
                    ->where('sender_id', $user->id)
                    ->where('is_read', false)
                    ->count();
            }
        }

        $conversations = Conversation::where('sender_id', Auth::id())
            ->orWhere('receiver_id', Auth::id())
            ->with(['sender', 'receiver', 'messages' => function ($q) {
                $q->latest()->limit(1);
            }])
            ->get();

        return view('auth.messages.index', compact('users', 'conversations'));
    }

    public function show($id)
    {
        $conversation = Conversation::with('messages.sender')->findOrFail($id);

        foreach ($conversation->messages as $msg) {
            if ($msg->sender_id !== Auth::id() && !$msg->is_read) {
                $msg->update(['is_read' => true]);
            }
        }

        return response()->json($conversation);
    }

    public function unreadCount()
    {
        $userId = auth()->id();

        $count = Message::where('receiver_id', $userId)
            ->where('is_read', false)
            ->count();

        return response()->json(['unread' => $count]);
    }
}