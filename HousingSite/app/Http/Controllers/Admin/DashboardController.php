<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Agent;
use App\Models\Listing;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalAgents = Agent::count();
        $totalListings = Listing::count();
        $pendingVerifications = Agent::where('verification_status', 'pending')->count();

        return view('dashboard.admin.index', compact(
            'totalUsers',
            'totalAgents', 
            'totalListings',
            'pendingVerifications'
        ));
    }
}