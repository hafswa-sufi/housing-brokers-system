<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CasaAmor - Find Your Dream Home')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('favicon.ico') }}?v=2">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        :root {
            --primary-green: #1a936f;
            --dark-green: #114b47;
        }
        
        .bg-primary { background-color: var(--primary-green) !important; }
        .btn-primary { 
            background-color: var(--primary-green); 
            border-color: var(--primary-green);
        }
        .btn-primary:hover {
            background-color: var(--dark-green);
            border-color: var(--dark-green);
        }
        .btn-outline-primary {
            border-color: var(--primary-green);
            color: var(--primary-green);
        }
        .btn-outline-primary:hover {
            background-color: var(--primary-green);
            border-color: var(--primary-green);
            color: white;
        }
    </style>

    <!-- Livewire Styles -->
    

    @yield('styles')
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="Logo" style="height: 40px;">
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('public.properties.index') }}">Browse Properties</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('agents.index') }}">Find Agents</a>
                    </li>
                    @auth
                        @if(Auth::user()->role === 'tenant')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('chat.index') }}">Chat</a>
                            </li>
                        @elseif(Auth::user()->role === 'agent')
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('chat.agent.index') }}">Chat</a>
                            </li>
                        @endif
                    @endauth
                </ul>
                
                <ul class="navbar-nav">
                    @auth
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle me-1"></i> {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                @if(Auth::user()->isAgent())
                                    <li><a class="dropdown-item" href="{{ route('agent.dashboard') }}">
                                        <i class="fas fa-tachometer-alt me-2"></i>Agent Dashboard
                                    </a></li>
                                @elseif(Auth::user()->isAdmin())
                                    <li><a class="dropdown-item" href="{{ route('admin.dashboard') }}">
                                        <i class="fas fa-cog me-2"></i>Admin Dashboard
                                    </a></li>
                                @else
                                    <li><a class="dropdown-item" href="{{ route('user.dashboard') }}">
                                        <i class="fas fa-user me-2"></i>Dashboard
                                    </a></li>
                                @endif
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="btn btn-primary" href="{{ route('login.form') }}">
                                <i class="fas fa-user me-1"></i> Login / Register
                            </a>
                        </li>
                        <li class="nav-item ms-2">
                            <a class="btn btn-outline-primary" href="{{ route('agent.register') }}">
                                <i class="fas fa-user-tie me-1"></i> Become an Agent
                            </a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="container my-4">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container text-center">
            <img src="{{ asset('images/logo.png') }}?v={{ time() }}" alt="CasaAmor" style="height: 30px;" class="mb-3">
            <p class="mb-0">&copy; 2025 CasaAmor. All Rights Reserved.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Livewire Scripts -->
    @livewireScripts

    @yield('scripts')
</body>
</html>
