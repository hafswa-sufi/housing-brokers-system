<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class AgentController extends Controller
{
    /**
     * Show the agent registration form
     */
    public function create()
    {
        return view('auth.agent-register');
    }

    /**
     * Store a newly created agent registration
     */
  public function store(Request $request)
{
    Log::info('=== AGENT REGISTRATION STARTED ===');
    
    // Start timing
    $startTime = microtime(true);

    try {
        // ✅ VALIDATE WITHOUT DATABASE CHECKS FIRST
        $validated = $request->validate([
            // User fields
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:20',
            'password' => 'required|min:8|confirmed',
            
            // Agent fields
            'id_number' => 'required|string|max:20',
            'kra_pin' => 'required|string|max:20',
            'id_document' => 'required|file|mimes:jpeg,png,jpg,pdf|max:1024', // 1MB max
            'selfie_id' => 'sometimes|file|mimes:jpeg,png,jpg|max:1024', // 1MB max
            
            // Professional details
            'company_name' => 'nullable|string|max:255',
            'business_reg_number' => 'nullable|string|max:50',
            'business_address' => 'required|string|max:500',
            'experience' => 'required|string',
            'bio' => 'nullable|string|max:1000',
            'terms' => 'required|accepted',
        ]);

        Log::info('Validation passed', ['time' => microtime(true) - $startTime]);

        // ✅ MANUAL UNIQUE CHECKS WITH TIMEOUT HANDLING
        if (\App\Models\User::where('email', $request->email)->exists()) {
            return back()->withErrors(['email' => 'Email already exists.'])->withInput();
        }

        if (\App\Models\Agent::where('id_number', $request->id_number)->exists()) {
            return back()->withErrors(['id_number' => 'ID number already registered.'])->withInput();
        }

        if (\App\Models\Agent::where('kra_pin', $request->kra_pin)->exists()) {
            return back()->withErrors(['kra_pin' => 'KRA PIN already registered.'])->withInput();
        }

        Log::info('Unique checks passed', ['time' => microtime(true) - $startTime]);

        // ✅ PROCESS FILE UPLOADS FIRST
        $idDocumentPath = null;
        $selfiePath = null;

        if ($request->hasFile('id_document')) {
            $idDocumentPath = $request->file('id_document')->store('id_documents', 'public');
            Log::info('ID document uploaded', ['path' => $idDocumentPath]);
        }

        if ($request->hasFile('selfie_id')) {
            $selfiePath = $request->file('selfie_id')->store('selfies', 'public');
            Log::info('Selfie uploaded', ['path' => $selfiePath]);
        }

        Log::info('Files processed', ['time' => microtime(true) - $startTime]);

        // ✅ CREATE USER
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password_hash' => \Illuminate\Support\Facades\Hash::make($request->password),
            'role' => 'agent',
        ]);

        Log::info('User created', ['user_id' => $user->user_id, 'time' => microtime(true) - $startTime]);

        // ✅ CREATE AGENT PROFILE
        $agent = \App\Models\Agent::create([
            'user_id' => $user->user_id,
            'id_number' => $request->id_number,
            'kra_pin' => $request->kra_pin,
            'id_document_url' => $idDocumentPath,
            'selfie_url' => $selfiePath,
            'company_name' => $request->company_name,
            'business_reg_number' => $request->business_reg_number,
            'business_address' => $request->business_address,
            'experience' => $request->experience,
            'bio' => $request->bio,
            'verification_status' => 'pending',
        ]);

        Log::info('Agent profile created', ['agent_id' => $agent->agent_id, 'total_time' => microtime(true) - $startTime]);

        // ✅ SEND SUCCESS RESPONSE
        return redirect()->route('agent.register')
            ->with('success', 'Agent registration submitted successfully! Your application is under review.');

    } catch (\Exception $e) {
        Log::error('Agent registration failed: ' . $e->getMessage(), [
            'trace' => $e->getTraceAsString(),
            'total_time' => microtime(true) - $startTime
        ]);

        return back()->withErrors(['error' => 'Registration failed. Please try again.'])->withInput();
    }
}
    public function dashboard()
    {
        $user = Auth::user();
        $agent = $user->agent; // Use relationship
        
        // Check if agent exists and get their listings
        $listings = [];
        if ($agent) {
            $listings = Listing::where('agent_id', $agent->agent_id)->get(); // Use agent_id
        }

        return view('dashboard.agent.index', compact('user', 'agent', 'listings'));
    }

    public function profile()
    {
        $user = Auth::user();
        $agent = $user->agent; // Use relationship
        
        return view('dashboard.agent.profile', compact('user', 'agent'));
    }

    public function showCompleteProfile()
    {
        $user = Auth::user();
        $agent = $user->agent; // Use relationship
        
        return view('dashboard.agent.complete-profile', compact('user', 'agent'));
    }

    public function completeProfile(Request $request)
    {
        $user = Auth::user();
        $agent = $user->agent; // Use relationship
        
        if (!$agent) {
            return redirect()->route('agent.register')->with('error', 'Please complete agent registration first.');
        }

        $request->validate([
            'license_number' => 'required|string|max:50|unique:agents,license_number,' . $agent->agent_id . ',agent_id',
            'bio' => 'nullable|string',
            'id_document' => 'sometimes|file|mimes:pdf,jpg,png|max:5120',
        ]);

        try {
            $updateData = [
                'license_number' => $request->license_number,
                'bio' => $request->bio,
            ];

            // Handle file upload if provided
            if ($request->hasFile('id_document')) {
                $documentPath = $request->file('id_document')->store('agent_documents', 'public');
                $updateData['id_document_url'] = $documentPath;
            }

            // Update agent profile
            $agent->update($updateData);

            return redirect()->route('agent.dashboard')->with('success', 'Profile updated successfully!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Failed to update profile: ' . $e->getMessage()]);
        }
    }

    /**
     * Public agent listings
     */
   public function publicIndex()
{
    try {
        // Get verified agents with their user data
        $agents = \App\Models\Agent::with(['user'])
            ->where('verification_status', 'verified')
            ->get();
            
        // Debug: Check what data we're getting
        Log::info('Agents found: ' . $agents->count());
        
        return view('agents.index', compact('agents'));
        
    } catch (\Exception $e) {
        Log::error('Agents index error: ' . $e->getMessage());
        return view('agents.index')->with('agents', collect([]));
    }
}

    /**
     * Public agent profile
     */
    public function publicShow($id)
    {
        $agent = Agent::where('agent_id', $id)
                    ->where('verification_status', 'verified')
                    ->with(['user', 'listings', 'reviews']) // <-- add reviews here
                    ->firstOrFail();

        $listings = $agent->listings;
        $reviews  = $agent->reviews ?? collect(); // always return a collection

        return view('agents.show', compact('agent', 'listings', 'reviews'));
    }

   
}