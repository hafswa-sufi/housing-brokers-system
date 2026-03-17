<?php

namespace App\Http\Controllers;

use App\Models\Agent;
use App\Models\Listing;
use App\Models\User;
use App\Models\Reports;
use App\Models\Bookings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Routing\Controller as BaseController;

class AnalyticsReportController extends \App\Http\Controllers\Controller
{
    public function __construct()
    {
        // Apply middleware to ensure only authenticated Admins can access
        // This relies on your existing 'is_admin' middleware
        //$this->middleware(['auth', 'is_admin']); 
    }

    /**
     * Display the Admin Analytics Dashboard.
     * Route: admin.analytics (GET /admin/analytics)
     */
    public function index()
    {
        // 1. Core Totals
        $totalAgents = Agent::count();
        $totalListings = Listing::count();
        // Tenants are users where role = 'tenant'
        $totalTenants = User::where('role', 'tenant')->count(); 
        
        // 2. Pending Items
        $pendingReports = Reports::where('status', 'pending')->count();
        $pendingAgentVerifications = Agent::where('verification_status', 'pending')->count();
        $pendingListingVerifications = Listing::where('verification_status', 'pending')->count();
        $pendingBookings = Bookings::where('status', 'pending')->count();
                                     
        // 3. Status Breakdown (for charts/details)
        $verificationStatuses = Agent::select('verification_status', DB::raw('count(*) as total'))
                                     ->groupBy('verification_status')
                                     ->pluck('total', 'verification_status')
                                     ->all();

        // Pass all aggregated data to the view
        return view('admin.analytics', compact(
            'totalAgents', 
            'totalListings', 
            'totalTenants', 
            'pendingReports',
            'pendingAgentVerifications',
            'pendingListingVerifications',
            'pendingBookings',
            'verificationStatuses'
        ));
    }
}