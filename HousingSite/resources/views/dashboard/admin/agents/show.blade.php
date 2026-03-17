@extends('layouts.admin.app')

@section('title', "Review Agent: {{ $agent->user->name ?? 'N/A' }}")

@section('content')
<div class="container-fluid py-4">
    <a href="{{ route('admin.agents.index') }}" class="btn btn-secondary mb-3">
        <i class="fas fa-arrow-left"></i> Back to Agents
    </a>
    
    @if(!$agent)
        <div class="alert alert-danger">
            Agent not found!
        </div>
    @else
        <h2>Review Agent: {{ $agent->user->name ?? 'N/A' }}</h2>

        @if (session('success'))
            <div class="alert alert-success mt-3">{{ session('success') }}</div>
        @endif
        
        @if (session('verified_notification'))
           <div class="alert alert-info mt-3">
                 The agent has been successfully verified!
           </div>
        @endif

        <div class="row">
            {{-- Agent Details Card --}}
            <div class="col-md-6 mb-4">
                <div class="card h-100">
                    <div class="card-header bg-info text-white">
                        Agent Profile (Status: <span class="font-weight-bold">{{ ucfirst($agent->verification_status ?? 'unknown') }}</span>)
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $agent->user->name ?? 'N/A' }}</p>
                        <p><strong>Email:</strong> {{ $agent->user->email ?? 'N/A' }}</p>
                        <p><strong>Phone:</strong> {{ $agent->user->phone ?? 'N/A' }}</p>
                        <p><strong>License Number:</strong> {{ $agent->license_number ?? 'N/A' }}</p>
                        <p><strong>Agency:</strong> {{ $agent->company ?? 'N/A' }}</p>
                        <p><strong>Address:</strong> {{ $agent->business_address ?? 'N/A' }}</p>
                        <p><strong>Bio:</strong> {{ $agent->bio ?? 'N/A' }}</p>

                        <h5 class="mt-4">ID Document</h5>
                        @if ($agent->id_document_url)
                            <a href="{{ asset('storage/' . $agent->id_document_url) }}" target="_blank" class="btn btn-sm btn-warning">
                                <i class="fas fa-download"></i> View Document
                            </a>
                        @else
                            <p class="text-danger">Document not uploaded.</p>
                        @endif
                        
                        <h5 class="mt-4">Agent Listings ({{ $agent->listings->count() ?? 0 }})</h5>
                        <ul class="list-unstyled">
                            @forelse ($agent->listings ?? [] as $listing)
<li><a href="{{ route('admin.listings.show', $listing->listing_id) }}" target="_blank">{{ Str::limit($listing->title, 40) }} ({{ ucfirst($listing->status) }})</a></li>                            @empty
                                <li>No listings posted yet.</li>
                            @endforelse
                    </div>
                </div>
            </div>

            {{-- Verification & Blacklist Actions Card --}}
            <div class="col-md-6 mb-4">
                {{-- 1. Verification Actions --}}
                <div class="card mb-4">
                    <div class="card-header bg-success text-white">Verification Action</div>
                    <div class="card-body">
                        <form action="{{ route('admin.agents.review', $agent->agent_id) }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label for="note">Admin Note (Required for Rejection)</label>
                                <textarea name="note" id="note" class="form-control" rows="3" placeholder="Explain the reason for rejection or a confirmation note."></textarea>
                            </div>
                            <button type="submit" name="action" value="approve" class="btn btn-success" {{ ($agent->verification_status ?? '') == 'verified' ? 'disabled' : '' }}>
                                <i class="fas fa-check-circle"></i> Approve
                            </button>
                            <button type="submit" name="action" value="reject" class="btn btn-danger" {{ ($agent->verification_status ?? '') == 'rejected' ? 'disabled' : '' }}>
                                <i class="fas fa-times"></i> Reject
                            </button>
                        </form>
                    </div>
                </div>

                {{-- 2. Blacklist Actions --}}
                <div class="card">
                    <div class="card-header bg-danger text-white">Blacklist Management</div>
                    <div class="card-body">
                        @if ($agent->blacklist && $agent->blacklist->blacklisted_at)
                            <div class="alert alert-danger">
                                Agent is currently **BLACKLISTED** (Since: {{ $agent->blacklist->blacklisted_at->format('Y-m-d') }}).
                                <p class="mt-2">Reason: {{ $agent->blacklist->reason ?? 'No reason provided.' }}</p>
                            </div>
                            <form action="{{ route('admin.agents.blacklist', $agent->agent_id) }}" method="POST">
                                @csrf
                                <input type="hidden" name="blacklist" value="0">
                                <button type="submit" class="btn btn-warning"><i class="fas fa-unlock"></i> Remove from Blacklist</button>
                            </form>
                        @else
                            <p>Blacklisting will prevent the agent from logging in and hide all their listings.</p>
                            <form action="{{ route('admin.agents.blacklist', $agent->agent_id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="reason">Blacklist Reason</label>
                                    <textarea name="reason" id="reason" class="form-control" rows="3" required></textarea>
                                </div>
                                <input type="hidden" name="blacklist" value="1">
                                <button type="submit" class="btn btn-danger"><i class="fas fa-ban"></i> Blacklist Agent</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
@endsection