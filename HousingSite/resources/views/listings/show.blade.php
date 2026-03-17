@extends('layouts.app')

@section('title', $listing->title . ' - CasaAmor')

@section('content')
<div class="container py-5">
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h1 class="fw-bold mb-1">{{ $listing->title }}</h1>
            <p class="text-muted mb-0"><i class="fas fa-map-marker-alt me-2"></i>{{ $listing->location }}</p>
        </div>
        <div class="text-end">
            <h2 class="text-primary fw-bold mb-0">KES {{ number_format($listing->price) }}</h2>
            <span class="badge bg-{{ $listing->status === 'available' ? 'success' : 'secondary' }}">
                {{ ucfirst($listing->status) }}
            </span>
        </div>
    </div>

    <div class="row mb-5">
        <div class="col-md-8">
            <div id="propertyCarousel" class="carousel slide rounded overflow-hidden shadow-sm" data-bs-ride="carousel">
                <div class="carousel-inner">
                    @forelse($listing->images as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/' . $image->image_url) }}" class="d-block w-100" style="height: 500px; object-fit: cover;" alt="Property Image">
                        </div>
                    @empty
                        <div class="carousel-item active">
                            <div class="d-flex align-items-center justify-content-center bg-light" style="height: 500px;">
                                <i class="fas fa-home fa-5x text-muted"></i>
                            </div>
                        </div>
                    @endforelse
                </div>
                @if($listing->images->count() > 1)
                    <button class="carousel-control-prev" type="button" data-bs-target="#propertyCarousel" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#propertyCarousel" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    </button>
                @endif
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-4">Contact Agent</h5>
                    <div class="d-flex align-items-center mb-3">
                        <div class="bg-light rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                            <i class="fas fa-user text-primary"></i>
                        </div>
                        <div>
                            <h6 class="mb-0 fw-bold">{{ $listing->agent->user->name }}</h6>
                            <small class="text-muted">Verified Agent</small>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2">
                        @auth
                            <a href="{{ route('chat.show', $listing->agent->user_id) }}" class="btn btn-primary">
                                <i class="fas fa-comment me-2"></i>Send Message
                            </a>
                            <a href="{{ route('properties.schedule_viewing', $listing->listing_id) }}" class="btn btn-outline-primary">
                                <i class="fas fa-calendar-check me-2"></i>Schedule Viewing
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="btn btn-primary">Login to Contact</a>
                        @endauth
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body">
                    <h5 class="card-title fw-bold mb-3">Overview</h5>
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="border rounded p-2 text-center">
                                <i class="fas fa-bed text-primary mb-1"></i>
                                <div class="small fw-bold">{{ $listing->bedrooms }} Beds</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2 text-center">
                                <i class="fas fa-bath text-primary mb-1"></i>
                                <div class="small fw-bold">{{ $listing->bathrooms }} Baths</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2 text-center">
                                <i class="fas fa-ruler-combined text-primary mb-1"></i>
                                <div class="small fw-bold">{{ $listing->size ?? 'N/A' }} sq ft</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="border rounded p-2 text-center">
                                <i class="fas fa-home text-primary mb-1"></i>
                                <div class="small fw-bold">{{ ucfirst($listing->property_type) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h4 class="fw-bold mb-3">Description</h4>
                    <p class="text-muted">{{ $listing->description }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection