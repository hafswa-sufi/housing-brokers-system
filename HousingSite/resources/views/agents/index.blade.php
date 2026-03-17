@extends('layouts.app')

@section('title', 'Verified Agents - CasaAmor')

@section('styles')
<style>
    .agent-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .agent-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 4px 15px rgba(0,0,0,0.1) !important;
    }
    /* Custom style for the black border if not using Bootstrap's default .border-dark */
    .card-black-outline {
        border: 1px solid #212529 !important; /* Bootstrap's dark color */
    }
</style>
@endsection

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-dark">Verified Real Estate Agents</h1>
            <p class="lead text-muted">Connect with our trusted real estate professionals</p>
        </div>
    </div>

    <div class="row mt-4">
        @forelse($agents as $agent)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card agent-card h-100 shadow-sm card-black-outline"> {{-- Added card-black-outline --}}
                    <div class="card-body text-center d-flex flex-column">
                        <div class="mb-3">
                            <i class="fas fa-user-tie fa-3x text-dark"></i> {{-- Changed text-primary to text-dark --}}
                        </div>
                        <h5 class="card-title fw-bold">{{ $agent->user->name ?? 'Agent' }}</h5>
                        <p class="text-success small fw-semibold">
                            <i class="fas fa-shield-alt me-1"></i>
                            Verified Agent
                        </p>

                        {{-- Details --}}
                        <div class="text-start mx-auto mb-3" style="max-width: 250px;">
                            @if(isset($agent->experience))
                                <p class="mb-1 small">
                                    <i class="fas fa-briefcase me-2 text-muted"></i>
                                    Experience: **{{ $agent->experience }}** years
                                </p>
                            @endif

                            @if(isset($agent->company_name))
                                <p class="mb-1 small">
                                    <i class="fas fa-building me-2 text-muted"></i>
                                    Works at: {{ $agent->company_name }}
                                </p>
                            @endif

                            @if(isset($agent->user->phone))
                                <p class="mb-0 small">
                                    <i class="fas fa-phone me-2 text-muted"></i>
                                    {{ $agent->user->phone }}
                                </p>
                            @endif
                        </div>

                        {{-- Action Button --}}
                        <div class="mt-auto pt-3">
                            <a href="{{ route('agents.show', $agent->agent_id) }}" class="btn btn-primary w-100">
                                <i class="fas fa-eye me-1"></i>View Profile
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center py-4 border-0 shadow-sm">
                    <i class="fas fa-info-circle fa-2x mb-3"></i>
                    <h4>No Verified Agents Available</h4>
                    <p class="mb-0">We're currently verifying our agent network. Please check back soon.</p>
                </div>
            </div>
        @endforelse
    </div>
</div>
@endsection