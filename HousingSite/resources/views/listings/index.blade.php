<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browse Properties - CasaAmor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .property-card {
            transition: transform 0.3s ease;
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .property-card:hover {
            transform: translateY(-5px);
        }
        .verified-badge {
            background: #00bfa5;
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: bold;
        }
        .page-header {
            background: linear-gradient(135deg, #00c9a7, #92fe9d);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="CasaAmor" style="height: 40px;">
            </a>
            <div class="navbar-nav ms-auto">
                <a class="btn btn-primary" href="{{ route('user.dashboard') }}">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="display-6 fw-bold">🏠 Browse Verified Properties</h1>
            <p class="lead mb-0">Find your perfect home from our trusted listings</p>
        </div>

        <!-- Search & Filters -->
        <div class="row mb-4">
            <div class="col-12">
                <form method="GET" action="{{ url()->current() }}">
                    <div class="card">
                        <div class="card-body">
                            <div class="row g-2">
                                <div class="col-md-4">
                                    <input type="text" name="location" class="form-control" placeholder="📍 Search location..."
                                        value="{{ request('location') }}">
                                </div>
                                <div class="col-md-3">
                                    <select name="property_type" class="form-control">
                                        <option value="">🏠 Property Type</option>
                                        <option value="apartment" {{ request('property_type')=='apartment' ? 'selected' : '' }}>Apartment</option>
                                        <option value="house" {{ request('property_type')=='house' ? 'selected' : '' }}>House</option>
                                        <option value="studio" {{ request('property_type')=='studio' ? 'selected' : '' }}>Studio</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <select name="price_range" class="form-control">
                                        <option value="">💰 Price Range</option>
                                        <option value="0-10000" {{ request('price_range')=='0-10000' ? 'selected' : '' }}>0 - 10,000 KES</option>
                                        <option value="10000-30000" {{ request('price_range')=='10000-30000' ? 'selected' : '' }}>10,000 - 30,000 KES</option>
                                        <option value="30000-50000" {{ request('price_range')=='30000-50000' ? 'selected' : '' }}>30,000 - 50,000 KES</option>
                                        <option value="50000-100000" {{ request('price_range')=='50000-100000' ? 'selected' : '' }}>50,000 - 100,000 KES</option>
                                        <option value="100000+" {{ request('price_range')=='100000+' ? 'selected' : '' }}>100,000+ KES</option>
                                        

                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" class="btn btn-primary w-100">🔍 Search</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Properties Grid -->
        <div class="row">
            @forelse($listings as $listing)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card property-card h-100">
                        <div class="position-relative">
                            <img src="{{ $listing->images->first()->image_url ?? 'https://via.placeholder.com/300x200' }}" 
                                 class="card-img-top" alt="{{ $listing->title ?? 'Property Image' }}" style="height: 200px; object-fit: cover;">
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="verified-badge">✅ Verified</span>
                            </div>
                        </div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $listing->title }}</h5>
                            @if($listing->location)
                                <p class="card-text text-muted">
                                    <i class="fas fa-map-marker-alt"></i> {{ $listing->location }}
                                </p>
                            @endif
                            @if($listing->price)
                                <div class="mb-2">
                                    <strong class="text-primary">KES {{ number_format($listing->price) }}</strong>
                                </div>
                            @endif
                            <div class="d-flex justify-content-between align-items-center">
                                <small class="text-muted">
                                    @if($listing->bedrooms)
                                        <i class="fas fa-bed"></i> {{ $listing->bedrooms }} {{ Str::plural('bed', $listing->bedrooms) }}
                                    @endif
                                    @if($listing->bathrooms)
                                        @if($listing->bedrooms)
                                            &bull;
                                        @endif
                                        <i class="fas fa-bath"></i> {{ $listing->bathrooms }} {{ Str::plural('bath', $listing->bathrooms) }}
                                    @endif
                                </small>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Agent: {{ $listing->agent->user->name ?? 'Verified Agent' }}
                            </small>
                            <a href="{{ route('properties.show', $listing->listing_id) }}" class="btn btn-sm btn-primary">
                                View Details
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card text-center py-5">
                        <i class="fas fa-home fa-3x text-muted mb-3"></i>
                        <h4>No Properties Available Yet</h4>
                        <p class="text-muted">We're working on adding verified properties. Check back soon!</p>
                        <div class="mt-3">
                            <a href="{{ route('user.dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            @endforelse

            <!-- Pagination -->
            @if($listings->hasPages())
                <div class="col-12 mt-4">
                    {{ $listings->links() }}
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body> 
</html>
