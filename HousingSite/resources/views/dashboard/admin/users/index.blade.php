@extends('layouts.admin.app')

@section('title', 'Manage Users')
@section('page-title', 'User Management')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card shadow">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">All Users ({{ $users->count() }})</h5>
                <span class="badge bg-primary">{{ $users->count() }} Total Users</span>
            </div>
            <div class="card-body">
                @if($users->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>User Details</th>
                                    <th>Contact</th>
                                    <th>Role</th>
                                    <th>Agent Profile</th>
                                    <th>Status</th>
                                    <th>Registered</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
                                <tr>
                                    <td><strong>#{{ $user->user_id }}</strong></td>
                                    <td>
                                        <div class="d-flex align-items-start">
                                            <div class="flex-grow-1">
                                                <strong class="d-block">{{ $user->name }}</strong>
                                                <small class="text-muted">
                                                    User ID: {{ $user->user_id }}
                                                </small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div>
                                            <strong><i class="fas fa-envelope me-1"></i>{{ $user->email }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                <i class="fas fa-phone me-1"></i>{{ $user->phone ?? 'Not provided' }}
                                            </small>
                                        </div>
                                    </td>
                                    <td>
                                        @php
                                            $roleColors = [
                                                'admin' => 'danger',
                                                'agent' => 'info',
                                                'tenant' => 'success'
                                            ];
                                            $color = $roleColors[$user->role] ?? 'secondary';
                                        @endphp
                                        <span class="badge bg-{{ $color }}">
                                            <i class="fas fa-user me-1"></i>{{ ucfirst($user->role) }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($user->agent)
                                            <span class="badge bg-success">
                                                <i class="fas fa-user-tie me-1"></i>Agent Profile
                                            </span>
                                            <br>
                                            <small class="text-muted">
                                                Status: {{ $user->agent->verification_status }}
                                            </small>
                                        @else
                                            <span class="badge bg-secondary">No Agent Profile</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-success">
                                            <i class="fas fa-check-circle me-1"></i>Active
                                        </span>
                                    </td>
                                    <td>
                                        {{ $user->created_at->format('M d, Y') }}
                                        <br>
                                        <small class="text-muted">
                                            {{ $user->created_at->diffForHumans() }}
                                        </small>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Statistics -->
                    <div class="row mt-4">
                        <div class="col-md-3">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Tenants
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('role', 'tenant')->count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                                Agents
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('role', 'agent')->count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-user-tie fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-danger shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                                Admins
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('role', 'admin')->count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-crown fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                With Agent Profiles
                                            </div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $users->where('agent')->count() }}</div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-id-card fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-5">
                        <i class="fas fa-users fa-4x text-gray-300 mb-3"></i>
                        <h4 class="text-gray-500">No Users Found</h4>
                        <p class="text-gray-500 mb-4">There are no users in the system yet.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection