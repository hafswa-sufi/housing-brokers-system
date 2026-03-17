<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AgentController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ListingController; // Use the Admin Listing Controller alias
use App\Http\Controllers\Admin\AgentController as AdminAgentController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

// --- Public Routes ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('password.request');

Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->name('password.reset');

// Session Debugging
Route::get('/check-session', function() {
    return response()->json([
        'authenticated' => Auth::check(),
        'user_id' => Auth::id(),
        'user_email' => Auth::check() ? Auth::user()->email : null,
        'session_id' => session()->getId(),
    ]);
});

// Agent Registration (Public)
Route::get('/agent/register', [AgentController::class, 'create'])->name('agent.register');
Route::post('/agent/register', [AgentController::class, 'store'])->name('agent.store');

// Public Property Routes
Route::get('/properties', [PropertyController::class, 'publicIndex'])->name('public.properties.index'); // Search Form Route
Route::get('/properties/{id}', [PropertyController::class, 'show'])->name('properties.show'); // Public Detail View

// Schedule Viewing Route
Route::get('/properties/{id}/schedule-viewing', [PropertyController::class, 'scheduleViewing'])->name('properties.schedule_viewing');
Route::post('/properties/{id}/schedule-viewing', [PropertyController::class, 'submitScheduleViewing'])->name('properties.schedule_viewing_submit');

// Public Agent Profiles
Route::get('/agents', [AgentController::class, 'publicIndex'])->name('agents.index');
Route::get('/agents/{id}', [AgentController::class, 'publicShow'])->name('agents.show');

// --- Agent Routes ---
Route::prefix('agent')->name('agent.')->middleware(['auth'])->group(function () {
    // Agent Dashboard
    Route::get('/dashboard', [AgentController::class, 'dashboard'])->name('dashboard');
    
    // Agent Profile Management
    Route::get('/profile', [AgentController::class, 'profile'])->name('profile');
    Route::get('/profile/complete', [AgentController::class, 'showCompleteProfile'])->name('profile.complete');
    Route::post('/profile/complete', [AgentController::class, 'completeProfile'])->name('profile.store');
    
    // Agent Property Management
    Route::get('/properties', [PropertyController::class, 'index'])->name('listings.index'); // List all
    Route::get('/properties/create', [PropertyController::class, 'create'])->name('listings.create'); // Create Form
    Route::post('/properties', [PropertyController::class, 'store'])->name('listings.store'); // Store Action
    Route::get('/properties/{id}/edit', [PropertyController::class, 'edit'])->name('listings.edit'); // Edit Form
    Route::put('/properties/{id}', [PropertyController::class, 'update'])->name('listings.update'); // Update Action
    Route::delete('/properties/{id}', [PropertyController::class, 'destroy'])->name('listings.destroy'); // Delete Action
    
    // Agent Listings Management (Alias)
    Route::get('/listings/manage', [PropertyController::class, 'manage'])->name('listings.manage');
});

// --- Admin Routes ---
Route::prefix('admin')->name('admin.')->middleware(['auth', 'is_admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin Agent Management
    Route::get('/agents', [AdminAgentController::class, 'index'])->name('agents.index');
    Route::get('/agents/{agent}', [AdminAgentController::class, 'show'])->name('agents.show');
    Route::post('/agents/{agent}/review', [AdminAgentController::class, 'review'])->name('agents.review');
    Route::post('/agents/{agent}/blacklist', [AdminAgentController::class, 'blacklist'])->name('agents.blacklist');

    // Admin Listings Management (Updated)
    Route::get('/listings', [ListingController::class, 'index'])->name('listings.index');
    Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
    Route::post('/listings/{listing}/verify', [ListingController::class, 'verify'])->name('listings.verify');
    Route::post('/listings/{listing}/reject', [ListingController::class, 'reject'])->name('listings.reject');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->name('listings.destroy');

    // Admin User Management
    Route::get('/users', [UserController::class, 'index'])->name('users.index');
});

// --- Tenant/User Routes ---
Route::prefix('user')->name('user.')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard.user');
    })->name('dashboard');
    
    // User Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
});

// --- Reviews, Chat & Reports ---
Route::post('/review', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/agents', [ChatController::class, 'agentIndex'])->name('chat.agent.index');
    Route::get('/chat/{userId}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{receiverId}', [ChatController::class, 'store'])->name('chat.store');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');
    
    // Admin report status update
    Route::middleware(['is_admin'])->group(function () {
        Route::post('/reports/{report}/status', [ReportController::class, 'updateStatus'])->name('reports.updateStatus');
    });
});

// --- Debugging & Tests (Safe to remove in production) ---
Route::get('/test-db', function () {
    try {
        DB::connection()->getPdo();
        return response()->json([
            'status' => 'success',
            'message' => '✅ MySQL connected successfully!',
            'database' => DB::connection()->getDatabaseName(),
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'status' => 'error',
            'message' => '❌ MySQL connection failed: ' . $e->getMessage(),
        ], 500);
    }
});

Route::get('/test-agent-create', function() {
    // [Code from your existing file for testing agent creation]
    // Omitted for brevity, but you can keep your existing test code here.
    return "Test route placeholder";
});