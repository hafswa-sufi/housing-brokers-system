<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    /**
     * Show chat users for tenants (list of agents).
     */
    public function index()
    {
        // ✅ FIX: Get agents with their user details. 
        // We filter out the current user just in case they are also an agent.
        $agents = Agent::with('user')
            ->whereHas('user', function($q) {
                $q->where('user_id', '!=', Auth::id());
            })
            ->paginate(8);
            
        return view('chat.index', compact('agents'));
    }

    /**
     * Show chat users for agents (list of tenants/users).
     */
    public function agentIndex()
    {
        // ✅ FIX: Get users who are not the current agent
        $users = User::where('user_id', '!=', Auth::id())
            ->where('role', 'tenant') // Optional: Only show tenants
            ->paginate(10);
            
        return view('chat.agent', compact('users'));
    }

    /**
     * Show the chat with a specific user.
     */
    public function show($userId)
    {
        $authId = Auth::id();

        // Get messages between authenticated user and the selected user
        $messages = Message::where(function ($q) use ($userId, $authId) {
            $q->where('sender_id', $authId)
              ->where('receiver_id', $userId);
        })->orWhere(function ($q) use ($userId, $authId) {
            $q->where('sender_id', $userId)
              ->where('receiver_id', $authId);
        })->orderBy('created_at', 'asc')->get();

        $receiver = User::findOrFail($userId);

        return view('chat.show', compact('messages', 'receiver'));
    }

    /**
     * Store a new message (Fallback for non-Livewire).
     */
    public function store(Request $request, $receiverId)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $receiverId,
            'message' => $request->message,
        ]);

        return redirect()->route('chat.show', $receiverId);
    }
}