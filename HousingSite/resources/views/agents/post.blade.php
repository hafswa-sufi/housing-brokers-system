@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Post a Property</h2>

    @if ($errors->any())
      <div class="alert alert-danger">
         <ul>@foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach</ul>
      </div>
    @endif

    <form action="{{ route('agent.listings.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Price</label>
            <input type="number" name="price" value="{{ old('price') }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Location</label>
            <input type="text" name="location" value="{{ old('location') }}" class="form-control" required>
        </div>

        <div class="row">
            <div class="col">
                <label>Bedrooms</label>
                <input type="number" name="bedrooms" value="{{ old('bedrooms') }}" class="form-control" required>
            </div>
            <div class="col">
                <label>Bathrooms</label>
                <input type="number" name="bathrooms" value="{{ old('bathrooms') }}" class="form-control" required>
            </div>
            <div class="col">
                <label>Garage</label>
                <input type="number" name="garage" value="{{ old('garage') }}" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Description</label>
            <textarea name="description" class="form-control" rows="5" required>{{ old('description') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Images (max 5)</label>
            <input type="file" name="images[]" multiple accept="image/*" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Post Property</button>
    </form>
</div>
@endsection
