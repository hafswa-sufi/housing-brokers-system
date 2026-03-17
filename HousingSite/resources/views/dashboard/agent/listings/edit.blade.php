@extends('layouts.agent')

@section('title', 'Edit Listing - CasaAmor')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h1 class="h3 mb-1 fw-bold"><i class="fas fa-edit me-2"></i>Edit Listing</h1>
                    <p class="text-muted">Update your property details</p>
                </div>
                <a href="{{ route('agent.listings.index') }}" class="btn btn-outline-secondary">
                    <i class="fas fa-arrow-left me-1"></i> Back to Listings
                </a>
            </div>

            <form action="{{ route('agent.listings.update', $listing->listing_id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-info-circle text-primary me-2"></i>Basic Information</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Property Title *</label>
                                    <input type="text" class="form-control" name="title" value="{{ old('title', $listing->title) }}" required>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="property_type" class="form-label">Property Type *</label>
                                    <select class="form-control" name="property_type" required>
                                        @foreach(['apartment', 'house', 'studio', 'bungalow', 'villa'] as $type)
                                            <option value="{{ $type }}" {{ old('property_type', $listing->property_type) == $type ? 'selected' : '' }}>
                                                {{ ucfirst($type) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="description" class="form-label">Description *</label>
                            <textarea class="form-control" name="description" rows="4" required>{{ old('description', $listing->description) }}</textarea>
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-images text-primary me-2"></i>Manage Images</h5>
                    </div>
                    <div class="card-body">
                        @if($listing->images->count() > 0)
                            <label class="form-label d-block fw-bold text-muted mb-2">Current Images (Check box to remove)</label>
                            <div class="row g-3 mb-4">
                                @foreach($listing->images as $img)
                                    <div class="col-6 col-md-3 text-center">
                                        <div class="border rounded p-2 h-100 bg-light">
                                            <img src="{{ asset('storage/' . $img->image_url) }}" class="img-fluid rounded mb-2" style="height: 100px; object-fit: cover;">
                                            <div class="form-check form-switch d-flex justify-content-center align-items-center">
                                                <input class="form-check-input bg-danger border-danger" type="checkbox" 
                                                       name="remove_images[]" 
                                                       value="{{ $img->image_id }}" 
                                                       id="img-{{ $img->image_id }}">
                                                <label class="form-check-label ms-2 small text-danger fw-bold" for="img-{{ $img->image_id }}">Delete</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif

                        <div class="mb-3">
                            <label for="images" class="form-label">Upload New Images</label>
                            <input type="file" class="form-control" name="images[]" multiple accept="image/*">
                        </div>
                    </div>
                </div>

                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white">
                        <h5 class="mb-0"><i class="fas fa-tag text-primary me-2"></i>Details</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bedrooms</label>
                                <input type="number" class="form-control" name="bedrooms" value="{{ old('bedrooms', $listing->bedrooms) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Bathrooms</label>
                                <input type="number" class="form-control" name="bathrooms" value="{{ old('bathrooms', $listing->bathrooms) }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label">Size (sq ft)</label>
                                <input type="number" class="form-control" name="square_feet" value="{{ old('square_feet', $listing->size) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Price (KES)</label>
                                <input type="number" class="form-control" name="price" value="{{ old('price', $listing->price) }}" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" required>
                                    <option value="available" {{ $listing->status == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="rented" {{ $listing->status == 'rented' ? 'selected' : '' }}>Rented</option>
                                    <option value="removed" {{ $listing->status == 'removed' ? 'selected' : '' }}>Removed</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Location</label>
                                <input type="text" class="form-control" name="location" value="{{ old('location', $listing->location) }}" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('agent.listings.index') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection