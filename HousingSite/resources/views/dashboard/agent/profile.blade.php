@extends('layouts.agent')

@section('content')
<div class="container mt-4">

    <h2 class="mb-3">{{ $agent->user->name }}'s Profile</h2>

    {{-- Agent Info --}}
    <p><strong>Company:</strong> {{ $agent->company_name }}</p>
    <p><strong>Experience:</strong> {{ $agent->experience }}</p>

    <hr>

    {{-- ⭐ Show Average Rating --}}
    <h4>Rating</h4>
    <p>
        <strong>{{ number_format($agent->rating_avg, 1) }}</strong> / 5  
        ({{ $agent->reviews->count() }} reviews)
    </p>

    <hr>

    {{-- ⭐ Allow users to submit a review --}}
    <h4>Leave a Review</h4>

    <form action="{{ route('reviews.store', $agent->agent_id) }}" method="POST">
        @csrf

        <label>Rating (1–5):</label>
        <select name="rating" class="form-control" required>
            <option value="1">⭐ 1</option>
            <option value="2">⭐ 2</option>
            <option value="3">⭐ 3</option>
            <option value="4">⭐ 4</option>
            <option value="5">⭐ 5</option>
        </select>

        <label class="mt-3">Your Comment</label>
        <textarea name="comment" class="form-control" rows="3"></textarea>

        <button type="submit" class="btn btn-primary mt-3">Submit Review</button>
    </form>

    <hr>

    {{-- ⭐ Show All Reviews --}}
    <h4>Reviews</h4>

    @foreach ($agent->reviews as $review)
        <div class="border p-3 mb-2">
            <strong>{{ $review->rating }} ⭐</strong>
            <p>{{ $review->comment }}</p>
            <small>By: {{ $review->user->name ?? 'Anonymous' }}</small>
        </div>
    @endforeach

</div>
@endsection
