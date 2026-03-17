@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <a href="{{ route('admin.listings.index') }}" class="btn btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left me-2"></i>Back to Listings
            </a>
            <h2 class="fw-bold">Property Details #{{ $listing->listing_id }}</h2>
        </div>
        
        <div class="d-flex gap-2">
            @if($listing->verification_status !== 'verified')
                <form action="{{ route('admin.listings.verify', $listing->listing_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check-circle me-2"></i>Verify Listing
                    </button>
                </form>
            @endif

            @if($listing->verification_status !== 'rejected')
                <form action="{{ route('admin.listings.reject', $listing->listing_id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning text-dark">
                        <i class="fas fa-times-circle me-2"></i>Reject
                    </button>
                </form>
            @endif

            <form action="{{ route('admin.listings.destroy', $listing->listing_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this listing?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash-alt me-2"></i>Delete
                </button>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body p-0">
                    <div id="listingCarousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner rounded">
                            @forelse($listing->images as $key => $image)
                                <div class="carousel-item {{ $key === 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/' . $image->image_url) }}" class="d-block w-100" style="height: 400px; object-fit: cover;" alt="Property Image">
                                </div>
                            @empty
                                <div class="carousel-item active">
                                    <div class="d-flex align-items-center justify-content-center bg-light" style="height: 400px;">
                                        <i class="fas fa-image fa-4x text-muted"></i>
                                        <p class="ms-2 text-muted mb-0">No images available</p>
                                    </div>
                                </div>
                            @endforelse
                        </div>
                        @if($listing->images->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#listingCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#listingCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Description</h5>
                </div>
                <div class="card-body">
                    <p class="mb-0">{{ $listing->description }}</p>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="card-title mb-3">Status & Verification</h5>
                    <div class="mb-3">
                        <label class="text-muted small">Verification Status</label>
                        <div>
                            @if($listing->verification_status === 'verified')
                                <span class="badge bg-success w-100 py-2">VERIFIED</span>
                            @elseif($listing->verification_status === 'rejected')
                                <span class="badge bg-danger w-100 py-2">REJECTED</span>
                            @else
                                <span class="badge bg-warning text-dark w-100 py-2">PENDING REVIEW</span>
                            @endif
                        </div>
                    </div>
                    <div>
                        <label class="text-muted small">Availability</label>
                        <div>
                            <span class="badge bg-{{ $listing->status === 'available' ? 'info' : 'secondary' }} w-100 py-2">
                                {{ strtoupper($listing->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Key Details</h5>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Price</span>
                            <span class="fw-bold text-success">KSh {{ number_format($listing->price) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Location</span>
                            <span class="fw-bold text-end">{{ $listing->location }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Type</span>
                            <span class="fw-bold">{{ ucfirst($listing->property_type) }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Bedrooms</span>
                            <span class="fw-bold">{{ $listing->bedrooms }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Bathrooms</span>
                            <span class="fw-bold">{{ $listing->bathrooms }}</span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between px-0">
                            <span class="text-muted">Size</span>
                            <span class="fw-bold">{{ $listing->size ? $listing->size . ' sq ft' : 'N/A' }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Agent Information</h5>
                </div>
                <div class="card-body text-center">
                    <div class="mb-3">
                        <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 80px; height: 80px;">
                            <i class="fas fa-user fa-3x text-secondary"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold">{{ $listing->agent->user->name }}</h5>
                    <p class="text-muted small mb-3">{{ $listing->agent->user->email }}</p>
                    
                    <a href="{{ route('admin.agents.show', $listing->agent->agent_id) }}" class="btn btn-outline-primary w-100">
                        View Agent Profile
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection