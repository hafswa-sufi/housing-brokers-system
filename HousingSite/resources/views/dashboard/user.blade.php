<!-- View: dashboard/user -->
 @extends('layouts.app')

@section('title', 'Tenant Dashboard - CasaAmor')

@section('styles')
<style>
    .dashboard-card {
        background: white;
        border-radius: 10px;
        padding: 25px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        margin-bottom: 20px;
    }
    .welcome-section {
        background: linear-gradient(135deg, #00c9a7, #92fe9d);
        color: white;
        padding: 30px;
        border-radius: 10px;
        margin-bottom: 30px;
    }
</style>
@endsection

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h1 class="display-5 fw-bold">Welcome, {{ Auth::user()->name }}! 👋</h1>
                <p class="lead mb-0">Start your journey to find your perfect home with verified agents.</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="bg-white text-dark rounded p-3">
                    <small class="text-muted">Account Status</small>
                    <div class="fw-bold text-success">✅ Active Tenant</div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions (Left Column) -->
        <div class="col-md-8">
            <div class="dashboard-card">
                <h4>🚀 Get Started</h4>
                <p>Begin your housing search with our verified properties and trusted agents.</p>

                <div class="row mt-4">
                    {{-- 1. Browse Properties Card --}}
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-search fa-2x text-primary mb-3"></i>
                                <h5>Browse Properties</h5>
                                <p>Explore verified listings</p>
                                <a href="{{ route('public.properties.index') }}" class="btn btn-primary">Start Searching</a>
                            </div>
                        </div>
                    </div>

                    {{-- 2. Find Agents Card --}}
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-user-tie fa-2x text-primary mb-3"></i>
                                <h5>Find Agents</h5>
                                <p>Connect with verified professionals</p>
                                <a href="{{ route('agents.index') }}" class="btn btn-outline-primary">View Agents</a>
                            </div>
                        </div>
                    </div>

                    {{-- 3. Chat Button Card (The one that was misplaced) --}}
                    <div class="col-md-6 mb-3">
                        <div class="card border-0 bg-light h-100">
                            <div class="card-body text-center">
                                <i class="fas fa-comments fa-2x text-primary mb-3"></i>
                                <h5>Chat With Agents</h5>
                                <p>Get real-time help from verified agents</p>
                                <a href="{{ route('chat.index') }}" class="btn btn-info">Chat with Agents</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div> <!-- Closes .dashboard-card for Quick Actions -->
        </div> <!-- Closes col-md-8 for Quick Actions -->

        <!-- Account Info (Right Column) -->
        <div class="col-md-4">
            <div class="dashboard-card">
                <h4>📋 Your Profile</h4>
                <div class="mb-3">
                    <strong>Name:</strong> {{ Auth::user()->name }}
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> {{ Auth::user()->email }}
                </div>
                <div class="mb-3">
                    <strong>Phone:</strong> {{ Auth::user()->phone }}
                </div>
                <div class="mb-3">
                    <strong>Role:</strong>
                    <span class="badge bg-success">Tenant</span>
                </div>

                <div class="mt-4">
                    <a href="{{ route('user.profile.edit') }}" class="btn btn-outline-primary btn-sm">Edit Profile</a>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="dashboard-card">
                <h4>📊 Quick Stats</h4>
                <div class="text-center">
                    <div class="display-6 fw-bold text-primary">0</div>
                    <small class="text-muted">Properties Saved</small>
                </div>
                <div class="text-center mt-3">
                    <div class="display-6 fw-bold text-success">0</div>
                    <small class="text-muted">Agents Contacted</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="dashboard-card">
                <h4>📝 Recent Activity</h4>
                <p class="text-muted">Your activity will appear here as you use the platform.</p>
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p>No recent activity yet</p>
                <a href="{{ route('public.properties.index') }}" class="btn btn-primary">Start Exploring Properties</a>                </div>
            </div>
        </div>
    </div>
</div>
@endsection