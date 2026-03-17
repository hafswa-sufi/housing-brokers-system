<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Agent Dashboard - CasaAmor')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary-teal: #00bfa5;
            --dark-teal: #009688;
            --light-teal: #c0f4f1;
            --gradient-teal: linear-gradient(135deg, #00c9a7, #92fe9d);
        }
        
        .bg-primary { 
            background: var(--gradient-teal) !important; 
        }
        
        .btn-primary { 
            background: var(--gradient-teal);
            border: none;
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, #00897b, #00a896);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 150, 136, 0.3);
        }
        
        .btn-outline-primary {
            border: 2px solid var(--primary-teal);
            color: var(--primary-teal);
            border-radius: 25px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-primary:hover {
            background: var(--primary-teal);
            color: white;
            transform: translateY(-2px);
        }
        
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }
        
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
        }
        
        .text-primary { color: var(--primary-teal) !important; }
        .text-teal { color: var(--primary-teal) !important; }
        
        .badge.bg-primary { background: var(--gradient-teal) !important; }
        
        .navbar-brand { 
            font-weight: 700;
            font-family: 'Poppins', sans-serif;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #c0f4f1, #a8edea);
            min-height: 100vh;
        }
    </style>
    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}" alt="CasaAmor" style="height: 40px;">
                CasaAmor
            </a>
            <div class="navbar-nav ms-auto">
                <a class="btn btn-outline-primary me-2" href="{{ route('agent.dashboard') }}">
                    <i class="fas fa-tachometer-alt me-1"></i> Dashboard
                </a>
                <a class="btn btn-primary" href="{{ route('agent.listings.create') }}">
                    <i class="fas fa-plus me-1"></i> Post Property
                </a>
            </div>
        </div>
    </nav>

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @yield('scripts')
</body>
</html>