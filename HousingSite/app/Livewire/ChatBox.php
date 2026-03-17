<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component as ViewComponent;

class ChatBox extends Component
{
    public $messages = [];
    public $message;
    public $receiverId;

    public function mount($receiverId)
    {
        $this->receiverId = $receiverId;
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Message::where(function ($q) {
            $q->where('sender_id', Auth::id())
              ->where('receiver_id', $this->receiverId);
        })->orWhere(function ($q) {
            $q->where('sender_id', $this->receiverId)
              ->where('receiver_id', Auth::id());
        })->orderBy('created_at', 'asc')->get();
    }

    public function sendMessage()
    {
        $msg = Message::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $this->receiverId,
            'message' => $this->message,
        ]);

        $this->message = '';
        $this->loadMessages();

        // Optional: broadcast event
        broadcast(new \App\Events\MessageSent($msg))->toOthers();
    }

    public function render()
    {
        return view('livewire.chat-box');
    }
}
