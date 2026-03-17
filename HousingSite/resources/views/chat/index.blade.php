@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm border-0">
        <div class="card-header bg-primary text-white p-3 rounded-top">
            <h4 class="mb-0">
                <i class="fas fa-user-tie me-2"></i> Available Verified Agents
            </h4>
        </div>
        <div class="card-body p-0">
            @if($agents->isEmpty())
                <div class="p-4 text-center text-muted">
                    <i class="fas fa-info-circle me-1"></i> No agents are currently available to chat with.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-striped table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th scope="col">Agent Name</th>
                                <th scope="col" class="d-none d-sm-table-cell">Email</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Rating</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($agents as $agent)
                                <tr>
                                    <td class="align-middle fw-bold">{{ $agent->user->name }}</td>
                                    <td class="align-middle d-none d-sm-table-cell">{{ $agent->user->email }}</td>
                                    <td class="align-middle text-center">
                                        @if($agent->verification_status === 'verified')
                                            <span class="badge bg-success py-2 px-3 rounded-pill">Verified</span>
                                        @elseif($agent->verification_status === 'pending')
                                            <span class="badge bg-warning text-dark py-2 px-3 rounded-pill">Pending</span>
                                        @else
                                            <span class="badge bg-danger py-2 px-3 rounded-pill">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="align-middle text-center">
                                        <span class="text-warning">
                                            @for ($i = 0; $i < floor($agent->rating_avg); $i++)
                                                <i class="fas fa-star"></i>
                                            @endfor
                                            @if ($agent->rating_avg - floor($agent->rating_avg) >= 0.5)
                                                <i class="fas fa-star-half-alt"></i>
                                            @endif
                                        </span>
                                        <small class="text-muted">({{ number_format($agent->rating_avg, 1) }})</small>
                                    </td>
                                    <td class="align-middle text-center">
                                        <a href="{{ route('chat.show', $agent->user->user_id) }}" class="btn btn-sm btn-info text-white">
                                            <i class="fas fa-comments me-1"></i> Chat Now
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @if($agents->hasPages())
                <div class="mt-3 d-flex justify-content-center">
                    {{ $agents->links('pagination::bootstrap-5') }}
                </div>
            @endif

            @endif
        </div>
    </div>
</div>
@endsection