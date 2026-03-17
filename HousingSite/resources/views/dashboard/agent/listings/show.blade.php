@extends('layouts.app')

@section('title', $listing->title ?? 'Listing')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-lg-8">
            {{-- Main image / gallery --}}
            @php
                $main = $listing->image ?? ($listing->thumbnail ?? null);
            @endphp

            @if($main)
                <img src="{{ asset('storage/' . $main) }}" class="img-fluid rounded mb-3" alt="{{ $listing->title }}">
            @else
                <img src="{{ asset('images/placeholder-listing.png') }}" class="img-fluid rounded mb-3" alt="No image">
            @endif

            <h2>{{ $listing->title ?? 'Untitled listing' }}</h2>

            <div class="mb-3">
                <strong>Price:</strong>
                KES {{ number_format($listing->price ?? 0) }} <small class="text-muted">/ month</small>
            </div>

            {{-- Viewing Price --}}
            <div class="mb-3">
                <strong>Viewing Price:</strong>
                @if(!is_null($listing->viewing_price) && $listing->viewing_price !== '')
                    KES {{ number_format($listing->viewing_price) }}
                @else
                    <span class="text-muted">Not set</span>
                @endif
            </div>

            {{-- Other meta --}}
            <div class="mb-3">
                <strong>Location:</strong> {{ $listing->location ?? 'Not specified' }}
            </div>

            <div class="mb-3">
                <strong>Bedrooms:</strong> {{ $listing->bedrooms ?? '-' }} &nbsp;
                <strong>Bathrooms:</strong> {{ $listing->bathrooms ?? '-' }}
            </div>

            <hr>

            <h5>Description</h5>
            <p>{{ $listing->description ?? 'No description provided.' }}</p>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Quick actions</h5>

                    <p class="mb-2">
                        <strong>Status:</strong>
                        <span class="badge bg-{{ $listing->is_published ? 'success' : 'secondary' }}">
                            {{ $listing->is_published ? 'Published' : 'Draft' }}
                        </span>
                    </p>

                    <p class="mb-2">
                        <strong>Viewing Fee:</strong><br>
                        @if(!is_null($listing->viewing_price) && $listing->viewing_price !== '')
                            <span class="fs-5">KES {{ number_format($listing->viewing_price) }}</span>
                        @else
                            <span class="text-muted">Not set</span>
                        @endif
                    </p>

                    <a href="{{ route('agent.listings.edit', $listing->id) }}" class="btn btn-primary btn-sm w-100 mb-2">
                        Edit Listing
                    </a>

                    <form action="{{ route('agent.listings.destroy', $listing->id) }}" method="POST" onsubmit="return confirm('Delete this listing?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-outline-danger btn-sm w-100">Delete</button>
                    </form>
                </div>
            </div>

            {{-- Contact / schedule viewing CTA --}}
            <div class="card">
                <div class="card-body text-center">
                    <p class="mb-2"><strong>Schedule a viewing</strong></p>
                    @if(!is_null($listing->viewing_price) && $listing->viewing_price !== '')
                        <p class="small text-muted">Viewing Fee: KES {{ number_format($listing->viewing_price) }}</p>
                    @endif

                    <a href="{{ route('properties.schedule_viewing', $listing->id) }}" class="btn btn-success w-100">
                        <i class="fas fa-calendar-check me-1"></i> Request Viewing
                    </a>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
