@extends('layouts.app')

@section('title', 'Chat with ' . $receiver->name)

@section('styles')
<style>
    .chat-container {
        display: flex;
        flex-direction: column;
        height: 70vh;
        border: 1px solid #ddd;
        border-radius: 8px;
        padding: 15px;
        background-color: #f8f9fa;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        margin-bottom: 15px;
    }

    .chat-message {
        padding: 8px 12px;
        border-radius: 20px;
        margin-bottom: 8px;
        max-width: 70%;
    }

    .chat-message.sender {
        background-color: var(--primary-green);
        color: #fff;
        margin-left: auto;
    }

    .chat-message.receiver {
        background-color: #e9ecef;
        color: #000;
        margin-right: auto;
    }

    .chat-input {
        display: flex;
        gap: 10px;
    }
</style>
@endsection

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Chat with {{ $receiver->name }}</h4>
        <a href="{{ auth()->user()->role === 'agent' ? route('chat.agent.index') : route('chat.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Back to List
        </a>
    </div>

    <div class="chat-container">
        <!-- Livewire chat box -->
        @livewire('chat-box', ['receiverId' => $receiver->user_id])

    </div>
</div>
@endsection
