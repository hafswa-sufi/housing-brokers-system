<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CasaAmor | Login</title>
    @vite(['resources/css/login.css', 'resources/js/login.js'])
</head>
<body>
    <div class="container" id="container">
        <!-- Sign Up Section -->
        <div class="form-container sign-up-container">
            <form action="{{ route('register') }}" method="POST" id="registrationForm">
                @csrf
                
                <!-- Success/Error Messages for Registration -->
                @if(session('success'))
                    <div class="alert alert-success" style="padding: 10px; margin-bottom: 15px; border-radius: 5px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                        {{ session('success') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger" style="padding: 10px; margin-bottom: 15px; border-radius: 5px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Dynamic Heading - No logo for more space -->
                <h1 id="formHeading">Create Account</h1>
                
                <!-- Common Fields -->
                <input type="text" name="name" placeholder="Full Name" required value="{{ old('name') }}">
                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                <input type="password" name="password" placeholder="Password" required>
                <input type="password" name="password_confirmation" placeholder="Confirm Password" required>
                <input type="text" name="phone" id="phoneInput" placeholder="Phone (07...)" required value="{{ old('phone') }}">

                <!-- Tenant-specific Fields (Default) -->
                <div id="tenantFields">
                    <!-- Simple tenant registration - no extra fields -->
                </div>

                <!-- Agent-specific Fields (Hidden by default) -->
                <div id="agentFields" style="display: none;">
                    <input type="text" name="id_number" placeholder="National ID Number" value="{{ old('id_number') }}">
                    <input type="text" name="kra_pin" placeholder="KRA PIN" value="{{ old('kra_pin') }}">
                    <small class="text-muted" style="font-size: 11px; display: block; text-align: center; margin: 5px 0;">
                        Required for agent verification in Kenya
                    </small>
                </div>

                <!-- Hidden role field -->
                <input type="hidden" name="role" id="userRole" value="tenant">

                <button type="submit" id="submitBtn">Sign Up</button>
            </form>
        </div>

        <!-- Sign In Section -->
        <div class="form-container sign-in-container">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                
                <!-- Success/Error Messages for Login -->
                @if(session('success'))
                    <div class="alert alert-success" style="padding: 10px; margin-bottom: 15px; border-radius: 5px; background: #d4edda; color: #155724; border: 1px solid #c3e6cb;">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger" style="padding: 10px; margin-bottom: 15px; border-radius: 5px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger" style="padding: 10px; margin-bottom: 15px; border-radius: 5px; background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb;">
                        <ul style="margin: 0; padding-left: 15px;">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Removed logo from login side too for consistency -->
                <h1>Sign In</h1>

                <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">
                <input type="password" name="password" placeholder="Password" required>

                <div class="options">
                    <label>
                        <input type="checkbox" name="remember"> Remember me
                    </label>
                    <a href="{{ route('password.request') }}">Forgot your password?</a>
                </div>

                <button type="submit">Login</button>
            </form>
        </div>

        <!-- Overlay Section -->
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1>New Here?</h1>
                    <p>Continue your housing search with trusted agents</p>
                    <button class="ghost" id="signIn">Sign In</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1>Welcome to safe renting!</h1>
                    <p>Join Kenya's trusted housing platform</p>
                    <button class="ghost" id="signUp">Sign Up</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Check user type when page loads and show appropriate form
        window.addEventListener('load', function() {
            const userType = sessionStorage.getItem('userType');
            console.log('Loaded user type:', userType);
            
            if (userType === 'agent') {
                showAgentForm();
                // Auto-show the registration side
                document.getElementById('container').classList.add("right-panel-active");
                sessionStorage.removeItem('userType');
            }
        });

        function showAgentForm() {
            document.getElementById('formHeading').textContent = 'Become Verified Agent';
            document.getElementById('tenantFields').style.display = 'none';
            document.getElementById('agentFields').style.display = 'block';
            document.getElementById('userRole').value = 'agent';
            document.getElementById('submitBtn').textContent = 'Apply as Agent';
        }
    </script>
</body>
</html>