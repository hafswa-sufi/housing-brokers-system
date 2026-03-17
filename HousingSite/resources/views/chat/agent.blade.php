@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Tenants</h2>
    <ul class="list-group">
        @foreach($users as $user)
            @if($user->role === 'tenant')
            <li class="list-group-item">
                <a href="{{ route('chat.show', $user->user_id) }}">
                    {{ $user->name }} ({{ $user->email }})
                </a>
            </li>
            @endif
        @endforeach
    </ul>
</div>
@endsection
