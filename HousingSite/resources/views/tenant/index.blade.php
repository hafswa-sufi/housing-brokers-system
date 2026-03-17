<!-- View: agents/index -->
 <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verified Agents - CasaAmor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .page-header {
            background: linear-gradient(135deg, #00c9a7, #92fe9d);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .agent-card {
            border: none;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .agent-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="CasaAmor" style="height: 40px;">
            </a>
            <div class="navbar-nav ms-auto">
                <a class="btn btn-primary" href="{{ route('user.dashboard') }}">
                    <i class="fas fa-arrow-left me-1"></i> Back to Dashboard
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid py-4">
        <!-- Page Header -->
        <div class="page-header">
            <h1 class="display-6 fw-bold">👔 Find Verified Agents</h1>
            <p class="lead mb-0">Connect with trusted real estate professionals in Kenya</p>
        </div>

        <!-- Agents Grid -->
        <div class="row">
            @if(isset($agents) && $agents->count() > 0)
                @foreach($agents as $agent)
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card agent-card h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-user-tie fa-3x text-primary"></i>
                            </div>
                            <h5 class="card-title">{{ $agent->user->name ?? 'Verified Agent' }}</h5>
                            <p class="card-text text-muted">
                                <i class="fas fa-building"></i> 
                                {{ $agent->company ?? 'Independent Agent' }}
                            </p>
                            <div class="mb-3">
                                <span class="badge bg-success">✅ Verified</span>
                                <span class="badge bg-info">Kenya</span>
                            </div>
                            <p class="card-text small text-muted">
                                {{ $agent->bio ?? 'Professional real estate agent with verified credentials.' }}
                            </p>
                        </div>
                        <div class="card-footer bg-transparent">
                            <div class="d-grid">
                                <button class="btn btn-outline-primary">Contact Agent</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="col-12">
                    <div class="card text-center py-5">
                        <i class="fas fa-user-tie fa-3x text-muted mb-3"></i>
                        <h4>Verified Agents Directory</h4>
                        <p class="text-muted">We're currently verifying our agent network.</p>
                        <p>All agents undergo strict ID verification before joining our platform.</p>
                        <div class="mt-3">
                            <a href="{{ route('properties.index') }}" class="btn btn-primary me-2">Browse Properties</a>
                            <a href="{{ route('user.dashboard') }}" class="btn btn-outline-primary">Back to Dashboard</a>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>