<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with(['agent'])->latest()->get();
        return view('dashboard.admin.users.index', compact('users'));
    }
}