@extends('layouts.agent')

@section('title', 'My Listings - CasaAmor')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 fw-bold text-gray-800">My Property Listings</h1>
        <a href="{{ route('agent.listings.create') }}" class="btn btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50 me-1"></i> Add New Property
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="ps-4 py-3" style="width: 100px;">Image</th>
                            <th class="py-3">Property Details</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Verification</th>
                            <th class="py-3">Price</th>
                            <th class="pe-4 py-3 text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($listings as $listing)
                        <tr>
                            <td class="ps-4">
                                @if($listing->images->count() > 0)
                                    <img src="{{ asset('storage/' . $listing->images->first()->image_url) }}" 
                                         class="rounded" 
                                         style="width: 80px; height: 60px; object-fit: cover;" 
                                         alt="Property">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center text-muted" 
                                         style="width: 80px; height: 60px;">
                                        <i class="fas fa-home"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <h6 class="mb-1 fw-bold text-dark">{{ $listing->title }}</h6>
                                <small class="text-muted"><i class="fas fa-map-marker-alt me-1"></i>{{ $listing->location }}</small>
                            </td>
                            <td>
                                <span class="badge bg-{{ $listing->status === 'available' ? 'success' : 'secondary' }}">
                                    {{ ucfirst($listing->status) }}
                                </span>
                            </td>
                            <td>
                                <span class="badge bg-{{ $listing->verification_status === 'verified' ? 'primary' : 'warning' }}">
                                    {{ ucfirst($listing->verification_status) }}
                                </span>
                            </td>
                            <td class="fw-bold">KES {{ number_format($listing->price) }}</td>
                            <td class="pe-4 text-end">
                                <div class="btn-group">
                                    {{-- View Button --}}
                                    <a href="{{ route('properties.show', $listing->listing_id) }}" 
                                       class="btn btn-sm btn-outline-secondary" 
                                       title="View Listing" target="_blank">
                                        <i class="fas fa-eye"></i>
                                    </a>

                                    {{-- Edit Button --}}
                                    <a href="{{ route('agent.listings.edit', $listing->listing_id) }}" 
                                       class="btn btn-sm btn-outline-primary" 
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    {{-- Delete Button --}}
                                    <form action="{{ route('agent.listings.destroy', $listing->listing_id) }}" 
                                          method="POST" 
                                          class="d-inline" 
                                          onsubmit="return confirm('Are you sure you want to delete this property?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-home fa-3x mb-3"></i>
                                    <p class="mb-0">No properties found.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $listings->links() }}
    </div>
</div>
@endsection