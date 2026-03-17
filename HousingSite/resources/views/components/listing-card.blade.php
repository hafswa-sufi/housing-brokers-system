

<div class="card h-100">
    {{-- Thumbnail --}}
    @php
        // Adjust this depending on how you store images
        $thumb = $listing->image ?? ($listing->thumbnail ?? null);
    @endphp

    @if($thumb)
        <img src="{{ asset('storage/' . $thumb) }}" class="card-img-top" alt="{{ $listing->title }}">
    @else
        <img src="{{ asset('images/placeholder-listing.png') }}" class="card-img-top" alt="No image">
    @endif

    <div class="card-body d-flex flex-column">
        <h5 class="card-title mb-1">{{ $listing->title ?? 'Untitled listing' }}</h5>

        <p class="mb-1">
            <strong>KES {{ number_format($listing->price ?? 0) }}</strong>
            <small class="text-muted"> / month</small>
        </p>

        {{-- Viewing price (only show if set and > 0) --}}
        @if(!is_null($listing->viewing_price) && $listing->viewing_price !== '')
            <p class="text-muted mb-2 small">
                <i class="fas fa-eye me-1"></i>
                Viewing Fee: <strong>KES {{ number_format($listing->viewing_price) }}</strong>
            </p>
        @else
            <p class="text-muted mb-2 small">
                <i class="fas fa-eye me-1"></i>
                Viewing Fee: <em>Not set</em>
            </p>
        @endif

        {{-- Location / meta --}}
        <p class="text-muted mb-3 small">
            <i class="fas fa-map-marker-alt me-1"></i>
            {{ $listing->location ?? 'Location not specified' }}
        </p>

        <div class="mt-auto d-flex justify-content-between align-items-center">
           <a href="{{ route('properties.show', $listing->id) }}" class="btn btn-sm btn-outline-primary">
                 View
           </a>

            <small class="text-muted">{{ $listing->bedrooms ?? '-' }} bd • {{ $listing->bathrooms ?? '-' }} ba</small>
        </div>
    </div>
</div>
