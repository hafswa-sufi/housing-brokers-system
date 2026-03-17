@extends('layouts.app')

@section('title', 'Report a User')

@section('content')
<div class="container py-4">
    <h2>Report a User</h2>
    
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reports.store') }}" method="POST">
                @csrf
      
                
                <div class="form-group">
                    <label for="reported_user_id">Select User to Report</label>
                    <select name="reported_user_id" id="reported_user_id" class="form-control" required>
                        <option value="">Select a user...</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->email }})</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="form-group">
                    <label for="reason">Reason for Report</label>
                    <input type="text" name="reason" id="reason" class="form-control" placeholder="Brief reason for reporting..." required>
                </div>
                
                <div class="form-group">
                    <label for="description">Detailed Description</label>
                    <textarea name="description" id="description" class="form-control" rows="5" placeholder="Please provide detailed information about your report..." required></textarea>
                </div>
                
                <button type="submit" class="btn btn-primary">Submit Report</button>
                <a href="{{ route('reports.index') }}" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
@endsection
