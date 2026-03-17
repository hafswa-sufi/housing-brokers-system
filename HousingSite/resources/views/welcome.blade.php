@extends('layouts.app')

@section('title', 'CasaAmor - Find Verified Homes, Avoid Scams')

@section('styles')
<style>
    .hero-section {
        background: linear-gradient(135deg, #00c9a7, #92fe9d);
        min-height: 80vh;
        display: flex;
        align-items: center;
    }
    .feature-card {
        transition: transform 0.3s ease;
        border: none;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }
    .feature-card:hover {
        transform: translateY(-5px);
    }
    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #00bfa5;
    }
    .btn-primary { 
        background-color: #00bfa5; 
        border-color: #00bfa5;
    }
    .btn-primary:hover {
        background-color: #009688;
        border-color: #009688;
    }
    .text-primary { color: #00bfa5 !important; }
    .border-primary { border-color: #00bfa5 !important; }
    .trust-badge {
        background: rgba(0, 191, 165, 0.1);
        border: 2px solid #00bfa5;
        border-radius: 10px;
        padding: 15px;
        text-align: center;
    }
</style>
@endsection

@section('content')
<!-- Hero Section -->
<section class="hero-section py-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold text-white">Find Verified Homes, Avoid Scams</h1>
                <p class="lead text-white mb-4">CasaAmor verifies every agent and listing so you can rent with confidence. No more guessing, no more risks.</p>
                <!-- Trust badges -->
                <div class="row mt-4">
                    <div class="col-md-6 mb-3">
                        <div class="trust-badge">
                            <i class="fas fa-user-shield text-primary fa-2x mb-2"></i>
                            <h6 class="text-white mb-1">Verified Agents</h6>
                            <small class="text-white-50">ID-checked professionals</small>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="trust-badge">
                            <i class="fas fa-home text-primary fa-2x mb-2"></i>
                            <h6 class="text-white mb-1">Authentic Listings</h6>
                            <small class="text-white-50">Property verification</small>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="bg-white rounded p-4 shadow">
                    <h4 class="text-primary">🏠 Your Safe Home Awaits</h4>
                    <p class="text-primary" style="font-weight: 600; font-size: 1.1rem;">No scams. No stress. We verify so you don't worry.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">Why Trust CasaAmor?</h2>
                <p class="text-muted">We've built the safest housing platform for tenants and verified agents</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3">
                            <i class="fas fa-id-card" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Agent Identity Verification</h5>
                        <p class="text-muted">Every agent undergoes strict ID verification before they can list properties. No anonymous postings.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3">
                            <i class="fas fa-flag" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Report & Protect System</h5>
                        <p class="text-muted">See something suspicious? Report it instantly. We investigate every claim to keep the community safe.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card feature-card h-100">
                    <div class="card-body text-center p-4">
                        <div class="text-primary mb-3">
                            <i class="fas fa-ban" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Public Blacklist</h5>
                        <p class="text-muted">Transparent record of banned agents. Know who to avoid before you even contact them.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Stats Section -->
<section class="py-5 bg-white">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-number">500+</div>
                <p class="text-muted">Verified Properties</p>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-number">150+</div>
                <p class="text-muted">ID-Checked Agents</p>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-number">0</div>
                <p class="text-muted">Reported Scams</p>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-number">99%</div>
                <p class="text-muted">User Trust Score</p>
            </div>
        </div>
    </div>
</section>

<!-- How It Works -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="row text-center mb-5">
            <div class="col-12">
                <h2 class="fw-bold">How We Protect You</h2>
                <p class="text-muted">Our verification process ensures every interaction is safe and trustworthy</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px; border: 2px solid #00bfa5;">
                    <i class="fas fa-user-check text-primary"></i>
                </div>
                <h5>Agent Verification</h5>
                <p class="text-muted">Agents submit ID documents for thorough background checks before approval</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px; border: 2px solid #00bfa5;">
                    <i class="fas fa-home text-primary"></i>
                </div>
                <h5>Listing Validation</h5>
                <p class="text-muted">Every property listing is verified for authenticity and availability</p>
            </div>
            <div class="col-md-4 text-center mb-4">
                <div class="bg-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                     style="width: 80px; height: 80px; border: 2px solid #00bfa5;">
                    <i class="fas fa-shield-alt text-primary"></i>
                </div>
                <h5>Community Protection</h5>
                <p class="text-muted">Report suspicious activity and help us maintain a scam-free platform</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-5 bg-primary text-white">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h3 class="fw-bold">Ready to Rent with Confidence?</h3>
                <p class="mb-0">Join thousands who've found safe homes through our verified platform.</p>
            </div>
            <div class="col-lg-4 text-lg-end">
                <a href="{{ route('login.form') }}" class="btn btn-light btn-lg">
                    Find Safe Homes
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Security Promise -->
<section class="py-5 bg-light">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <i class="fas fa-shield-check text-primary fa-3x mb-3"></i>
                <h3 class="fw-bold">Our Security Promise</h3>
                <p class="lead">We verify so you don't have to worry. Every agent, every listing, every time.</p>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <i class="fas fa-id-badge text-primary fa-2x mb-2"></i>
                        <h6>Identity Verification</h6>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-home text-primary fa-2x mb-2"></i>
                        <h6>Property Authentication</h6>
                    </div>
                    <div class="col-md-4">
                        <i class="fas fa-ban text-primary fa-2x mb-2"></i>
                        <h6>Scam Prevention</h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection