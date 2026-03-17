<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index()
    {
        try {
            $users = User::with(['agent'])
                ->latest()
                ->get();

            return view('dashboard.admin.users.index', compact('users'));
            
        } catch (\Exception $e) {
            Log::error('Admin users index error: ' . $e->getMessage());
            return view('dashboard.admin.users.index')->with('users', []);
        }
    }
}