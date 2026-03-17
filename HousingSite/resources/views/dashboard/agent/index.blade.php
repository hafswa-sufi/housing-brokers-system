@extends('layouts.app')

@section('title', 'Agent Dashboard - CasaAmor')

@section('styles')
<style>
    :root {
        --primary-teal: #00bfa5;
        --dark-teal: #009688;
        --light-teal: #c0f4f1;
        --gradient-teal: linear-gradient(135deg, #00c9a7, #92fe9d);
    }
    
    .bg-primary { background: var(--gradient-teal) !important; }
    .btn-primary { 
        background: var(--gradient-teal);
        border: none;
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #00897b, #00a896);
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 150, 136, 0.3);
    }
    .btn-outline-primary {
        border: 2px solid var(--primary-teal);
        color: var(--primary-teal);
        border-radius: 25px;
        font-weight: 600;
        transition: all 0.3s ease;
    }
    .btn-outline-primary:hover {
        background: var(--primary-teal);
        color: white;
        transform: translateY(-2px);
    }
    .card {
        border: none;
        border-radius: 20px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
    }
    .text-teal { color: var(--primary-teal) !important; }
    .badge.bg-primary { background: var(--gradient-teal) !important; }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-3 border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-check-circle me-2"></i>
                <span>{{ session('success') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mt-3 border-0 shadow-sm">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span>{{ session('error') }}</span>
                <button type="button" class="btn-close ms-auto" data-bs-dismiss="alert"></button>
            </div>
        </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-0 fw-bold"><i class="fas fa-tachometer-alt me-2"></i>Agent Dashboard</h1>
            <p class="text-muted">Welcome back, {{ Auth::user()->name }}</p>
        </div>
        <div class="d-flex gap-2">
            {{-- ✅ FIX: Link points to index (list) instead of show (single item) --}}
            <a href="{{ route('agent.listings.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-list-check me-1"></i>Manage Properties
            </a>

            @if($agent && $agent->verification_status === 'verified')
                <a href="{{ route('agent.listings.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Post Property
                </a>
            @else
                <button class="btn btn-secondary" disabled title="Wait for verification">
                    <i class="fas fa-lock me-1"></i>Post Property
                </button>
            @endif

            <a href="{{ route('agent.profile') }}" class="btn btn-outline-primary">
                <i class="fas fa-user me-1"></i>Profile
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted mb-2">Agent Status</h6>
                            <h4 class="mb-0">
                                <span class="badge bg-{{ $agent && $agent->verification_status === 'verified' ? 'primary' : 'warning' }}">
                                    {{ $agent ? ucfirst($agent->verification_status) : 'Not Registered' }}
                                </span>
                            </h4>
                        </div>
                        <div class="text-teal"><i class="fas fa-id-card fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted mb-2">Total Listings</h6>
                            <h2 class="mb-0 fw-bold">{{ $listings ? $listings->count() : 0 }}</h2>
                        </div>
                        <div class="text-success"><i class="fas fa-home fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted mb-2">Available</h6>
                            <h2 class="mb-0 fw-bold">{{ $listings ? $listings->where('status', 'available')->count() : 0 }}</h2>
                        </div>
                        <div class="text-info"><i class="fas fa-check-circle fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card border-0 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <h6 class="card-title text-muted mb-2">Pending</h6>
                            <h2 class="mb-0 fw-bold">{{ $listings ? $listings->where('verification_status', 'pending')->count() : 0 }}</h2>
                        </div>
                        <div class="text-warning"><i class="fas fa-clock fa-2x"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection