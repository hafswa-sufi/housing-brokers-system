@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-home me-2"></i>Manage Property Listings</h4>
                    <div>
                        <span class="badge bg-primary">{{ $listings->count() }} Total Listings</span>
                    </div>
                </div>
                <div class="card-body">
                    @if($listings->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead class="table-dark">
                                    <tr>
                                        <th>ID</th>
                                        <th>Property Details</th>
                                        <th>Agent</th>
                                        <th>Price</th>
                                        <th>Type</th>
                                        <th>Bed/Bath</th>
                                        <th>Size</th>
                                        <th>Status</th>
                                        <th>Verification</th>
                                        <th>Bookings</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($listings as $listing)
                                    <tr>
                                        <td><strong>#{{ $listing->listing_id }}</strong></td>                                        <td>
                                            <div class="d-flex align-items-start">
                                                <div class="flex-grow-1">
                                                    <strong class="d-block">{{ $listing->title }}</strong>
                                                    <small class="text-muted">
                                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $listing->location }}
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">
                                                        Created: {{ $listing->created_at->format('M d, Y') }}
                                                    </small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <strong>{{ $listing->agent->user->name ?? 'N/A' }}</strong>
                                                <br>
                                                <small class="text-muted">
                                                    <i class="fas fa-envelope me-1"></i>{{ $listing->agent->user->email ?? 'N/A' }}
                                                </small>
                                                <br>
                                                <small class="text-muted">
                                                    ID: {{ $listing->agent_id }}
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <strong class="text-success">KSh {{ number_format($listing->price, 2) }}</strong>
                                            @if($listing->price > 10000000)
                                                <br><small class="text-warning"><i class="fas fa-crown"></i> Premium</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-info text-dark">
                                                <i class="fas fa-building me-1"></i>{{ ucfirst($listing->property_type) }}
                                            </span>
                                        </td>
                                        <td>
                                            <div class="text-center">
                                                <div class="fw-bold">{{ $listing->bedrooms }} <i class="fas fa-bed text-primary"></i></div>
                                                <div class="fw-bold">{{ $listing->bathrooms }} <i class="fas fa-bath text-info"></i></div>
                                            </div>
                                        </td>
                                        <td>
                                            {{ $listing->size ?? 'N/A' }} sqft
                                            @if($listing->garage)
                                                <br><small class="text-muted"><i class="fas fa-car"></i> Garage</small>
                                            @endif
                                        </td>
                                        <td>
                                            @php
                                                $statusColors = [
                                                    'available' => 'success',
                                                    'rented' => 'info', 
                                                    'sold' => 'secondary',
                                                    'removed' => 'danger',
                                                    'flagged' => 'warning'
                                                ];
                                                $color = $statusColors[$listing->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $color }}">
                                                <i class="fas fa-circle me-1"></i>{{ ucfirst($listing->status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $verificationColors = [
                                                    'verified' => 'success',
                                                    'pending' => 'warning',
                                                    'rejected' => 'danger'
                                                ];
                                                $vColor = $verificationColors[$listing->verification_status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $vColor }}">
                                                @if($listing->verification_status === 'verified')
                                                    <i class="fas fa-check-circle me-1"></i>
                                                @elseif($listing->verification_status === 'pending')
                                                    <i class="fas fa-clock me-1"></i>
                                                @else
                                                    <i class="fas fa-times-circle me-1"></i>
                                                @endif
                                                {{ ucfirst($listing->verification_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            @php
                                                $bookingCount = $listing->bookings_count ?? 0;
                                            @endphp
                                            @if($bookingCount > 0)
                                                <span class="badge bg-warning text-dark">
                                                    <i class="fas fa-calendar-check me-1"></i>{{ $bookingCount }} Bookings
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    <i class="fas fa-calendar me-1"></i>No Bookings
                                                </span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="btn-group btn-group-sm">
                                                <a href="{{ route('admin.listings.show', $listing->listing_id) }}" 
                                                   class="btn btn-outline-primary" 
                                                   title="View Details">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <button class="btn btn-outline-info" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-outline-danger" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Summary Statistics -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white">
                                    <div class="card-body text-center">
                                        <h5>{{ $listings->where('status', 'available')->count() }}</h5>
                                        <small>Available</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white">
                                    <div class="card-body text-center">
                                        <h5>{{ $listings->where('verification_status', 'verified')->count() }}</h5>
                                        <small>Verified</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-dark">
                                    <div class="card-body text-center">
                                        <h5>{{ $listings->where('status', 'rented')->count() }}</h5>
                                        <small>Rented</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white">
                                    <div class="card-body text-center">
                                        <h5>KSh {{ number_format($listings->sum('price'), 2) }}</h5>
                                        <small>Total Value</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-home fa-4x text-muted mb-3"></i>
                            <h4>No Property Listings Found</h4>
                            <p class="text-muted mb-4">There are no property listings in the system yet.</p>
                            <a href="#" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Add First Listing
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection