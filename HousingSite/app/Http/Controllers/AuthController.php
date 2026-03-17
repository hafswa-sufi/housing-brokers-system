<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Agent; // ✅ ADD THIS IMPORT
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        Log::info('Registration attempt:', $request->all());

        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            'role' => 'required|in:tenant,agent',
        ]);

        Log::info('Validation passed:', $validated);

        try {
            // Create the user with password_hash field
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'password_hash' => Hash::make($validated['password']),
                'role' => $validated['role'],
            ]);

            Log::info('User created successfully:', ['user_id' => $user->user_id, 'email' => $user->email]);

            Auth::login($user);
            Log::info('User logged in successfully');

            // ✅ CHECK IF THERE'S PENDING AGENT REGISTRATION (FROM AGENT FORM)
            if (session('pending_agent')) {
                Log::info('🔍 Completing pending agent registration for NEW user: ' . $user->user_id);
                
                try {
                    $pendingAgent = session('pending_agent');
                    
                    // Create agent profile
                    $agent = Agent::create([
                        'user_id' => $user->user_id,
                        'id_number' => $pendingAgent['id_number'],
                        'kra_pin' => $pendingAgent['kra_pin'],
                        'id_document_url' => $pendingAgent['id_document_url'],
                        'selfie_id_path' => $pendingAgent['selfie_id_path'],
                        'company_name' => $pendingAgent['company_name'],
                        'business_reg_number' => $pendingAgent['business_reg_number'],
                        'business_address' => $pendingAgent['business_address'],
                        'experience' => $pendingAgent['experience'],
                        'bio' => $pendingAgent['bio'],
                        'verification_status' => 'pending',
                    ]);

                    Log::info('✅ Agent profile created for new user', ['agent_id' => $agent->agent_id]);

                    // Update user role to agent (override the selected role)
                    $user->role = 'agent';
                    $user->save();

                    // Clear pending agent session
                    session()->forget('pending_agent');

                    Log::info('✅ User role updated to agent');

                    return redirect()->route('agent.dashboard')
                        ->with('success', 'Account created and agent registration completed! Your application is under review.');

                } catch (\Exception $e) {
                    Log::error('❌ Failed to complete agent registration for new user: ' . $e->getMessage());
                    return redirect()->route('user.dashboard')
                        ->with('error', 'Account created but agent registration failed. Please contact support.');
                }
            }

            // Normal registration success (no pending agent)
            if ($user->role === 'agent') {
                return redirect()->route('agent.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }

        } catch (\Exception $e) {
            Log::error('Registration failed:', ['error' => $e->getMessage()]);
            
            return redirect()->back()
                ->with('error', 'Registration failed: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Your existing validation
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // ✅ CHECK IF THERE'S PENDING AGENT REGISTRATION
            if (session('pending_agent')) {
                Log::info('🔍 Completing pending agent registration for user: ' . Auth::id());
                
                try {
                    $pendingAgent = session('pending_agent');
                    
                    // Create agent profile
                    $agent = Agent::create([
                        'user_id' => Auth::id(),
                        'id_number' => $pendingAgent['id_number'],
                        'kra_pin' => $pendingAgent['kra_pin'],
                        'id_document_url' => $pendingAgent['id_document_url'],
                        'selfie_id_path' => $pendingAgent['selfie_id_path'],
                        'company_name' => $pendingAgent['company_name'],
                        'business_reg_number' => $pendingAgent['business_reg_number'],
                        'business_address' => $pendingAgent['business_address'],
                        'experience' => $pendingAgent['experience'],
                        'bio' => $pendingAgent['bio'],
                        'verification_status' => 'pending',
                    ]);

                    Log::info('✅ Agent profile created after login', ['agent_id' => $agent->agent_id]);

                    // Update user role
                    $user = User::find(Auth::id());
                    if ($user) {
                        $user->role = 'agent';
                        $user->save();
                    }

                    // Clear pending agent session
                    session()->forget('pending_agent');

                    Log::info('✅ User role updated to agent, redirecting to agent dashboard');

                    return redirect()->route('agent.dashboard')
                        ->with('success', 'Agent registration completed! Your application is under review.');

                } catch (\Exception $e) {
                    Log::error('❌ Failed to complete agent registration after login: ' . $e->getMessage());
                    // Continue to normal dashboard but show error
                    return redirect()->route('agent.dashboard')
                        ->with('error', 'Agent registration incomplete. Please contact support.');
                }
            }

            // Normal login redirect (based on user role)
            $user = Auth::user();
            if ($user->role === 'agent') {
                return redirect()->route('agent.dashboard');
            } elseif ($user->role === 'admin') {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('user.dashboard');
            }
        }

        // If authentication fails
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}