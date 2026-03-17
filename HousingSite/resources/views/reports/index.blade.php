@extends('layouts.app')

@section('title', 'Reports')

@section('content')
<div class="container py-4">
    <h2>Reports</h2>
    
    @if(auth()->user()->role === 'admin')
        <div class="card">
            <div class="card-header">
                <h5>All Reports</h5>
      
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Reporter</th>
                            <th>Reported User</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports as $report)
                            <tr>
                                <td>{{ $report->reporter->name }}</td>
                                <td>{{ $report->reportedUser->name }}</td>
                                <td>{{ Str::limit($report->reason, 50) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($report->status == 'pending') badge-warning
                                        @elseif($report->status == 'approved') badge-success
                                        @else badge-danger @endif">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td>{{ $report->created_at->format('M d, Y') }}</td>
                                <td>
                                    @if($report->status == 'pending')
                                        <form action="{{ route('reports.updateStatus', $report) }}" method="POST" class="d-inline">
                                            @csrf
                                            <button type="submit" name="status" value="approved" class="btn btn-success btn-sm">Approve</button>
                                            <button type="submit" name="status" value="rejected" class="btn btn-danger btn-sm">Reject</button>
                                        </form>
                                    @endif
                                    <a href="#" class="btn btn-info btn-sm">View</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No reports found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <a href="{{ route('reports.create') }}" class="btn btn-primary mb-3">Report a User</a>
        
        <div class="card">
            <div class="card-header">
                <h5>My Reports</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Reported User</th>
                            <th>Reason</th>
                            <th>Status</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($reports->where('reporter_id', auth()->id()) as $report)
                            <tr>
                                <td>{{ $report->reportedUser->name }}</td>
                                <td>{{ Str::limit($report->reason, 50) }}</td>
                                <td>
                                    <span class="badge 
                                        @if($report->status == 'pending') badge-warning
                                        @elseif($report->status == 'approved') badge-success
                                        @else badge-danger @endif">
                                        {{ ucfirst($report->status) }}
                                    </span>
                                </td>
                                <td>{{ $report->created_at->format('M d, Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">You haven't submitted any reports yet.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection
