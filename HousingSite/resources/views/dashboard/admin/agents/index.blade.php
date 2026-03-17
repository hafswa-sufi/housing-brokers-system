@extends('layouts.admin.app') {{-- Assumes you have an admin layout master --}}

@section('title', 'Agent Verification & Management')

@section('content')
<div class="container-fluid py-4">
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h2><i class="lni-users"></i> Agent Management</h2>
        <p class="text-muted">Review verification status and manage agent access.</p>
    </div>

    <a href="{{ route('chat.index') }}" class="btn btn-info mt-3">
        <i class="lni-comments"></i> Chat with Tenants
    </a>
</div>


    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    {{-- Search and Filter Form --}}
    <form action="{{ route('admin.agents.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-5">
                <input type="text" name="q" class="form-control" placeholder="Search by Name, Email, or License Number" value="{{ $q ?? '' }}">
            </div>
            <div class="col-md-4">
                <select name="status" class="form-control">
                    <option value="">All Statuses</option>
                    <option value="pending" {{ ($status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="verified" {{ ($status ?? '') == 'verified' ? 'selected' : '' }}>Verified</option>
                    <option value="rejected" {{ ($status ?? '') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary"><i class="lni-search"></i> Filter Agents</button>
                <a href="{{ route('admin.agents.index') }}" class="btn btn-secondary">Clear</a>
            </div>
        </div>
    </form>

    {{-- Agent Table --}}
    <div class="card">
        <div class="card-body">
            <table class="table table-striped table-hover">
                <thead class="thead-light">
                    <tr>
                        <th>Agent Name</th>
                        <th>Email</th>
                        <th>License</th>
                        <th>Status</th>
                        <th>Registered On</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($agents as $agent)
                        <tr>
                            <td>{{ $agent->user->name ?? 'N/A' }}</td>
                            <td>{{ $agent->user->email ?? 'N/A' }}</td>
                            <td>{{ $agent->license_number }}</td>
                            <td>
                                @if($agent->verification_status == 'verified')
                                    <span class="badge bg-success">Verified</span>
                                @elseif($agent->verification_status == 'pending')
                                    <span class="badge bg-warning text-dark">Pending</span>
                                @else
                                    <span class="badge bg-danger">Rejected</span>
                                @endif
                            </td>
                            <td>{{ $agent->created_at->format('Y-m-d') }}</td>
                            <td>
                                <a href="{{ route('admin.agents.show', $agent->agent_id) }}" class="btn btn-sm btn-primary">Review Details</a>

                                <a href="{{ route('chat.index', ['user' => $agent->user_id]) }}" class="btn btn-sm btn-info mt-1">
                                    Chat
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No agents found matching the criteria.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-3">
                {{ $agents->links() }}
            </div>
        </div>
    </div>
</div>
@endsection