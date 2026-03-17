<div>
    <div class="messages" style="height:300px; overflow-y:auto;">
        @foreach($messages as $msg)
            <div class="{{ $msg->sender_id == auth()->id() ? 'text-end' : 'text-start' }}">
                <strong>{{ $msg->sender->name }}:</strong> {{ $msg->message }}
            </div>
        @endforeach
    </div>

    <form wire:submit.prevent="sendMessage" class="mt-2 chat-input">
        <input type="hidden" wire:model="receiverId">

        <input type="text" wire:model="message" placeholder="Type a message..." class="form-control" />
        <button type="submit" class="btn btn-primary mt-1">Send</button>
    </form>
</div>