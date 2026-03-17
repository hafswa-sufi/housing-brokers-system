@extends('layouts.app')

@section('title', 'Schedule Viewing for ' . ($listing->title ?? 'Listing'))

@section('content')
<div class="container py-4">
    <h2>Schedule Viewing for: {{ $listing->title }}</h2>

    <p><strong>Location:</strong> {{ $listing->location }}</p>
    <p><strong>Price:</strong> KES {{ number_format($listing->price) }}</p>

    <form action="{{ route('properties.schedule_viewing_submit', $listing->listing_id) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="preferred_date" class="form-label">Preferred Date</label>
            <input type="date" class="form-control" id="preferred_date" name="preferred_date" required>
        </div>
        <div class="mb-3">
            <label for="preferred_time" class="form-label">Preferred Time</label>
            <input type="time" class="form-control" id="preferred_time" name="preferred_time" required>
        </div>
        <div class="mb-3">
            <label for="message" class="form-label">Additional Message (optional)</label>
            <textarea class="form-control" id="message" name="message" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit Viewing Request</button>
        <a href="{{ route('properties.show', $listing->listing_id) }}" class="btn btn-secondary">Back to Listing</a>
    </form>
</div>
@endsection
