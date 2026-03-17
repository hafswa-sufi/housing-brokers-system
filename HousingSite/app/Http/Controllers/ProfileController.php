<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class ProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->user_id . ',user_id',
            'phone' => 'nullable|string|max:20',
        ]);

        try {
            // Use raw SQL update to avoid any Eloquent issues
            DB::update(
                'UPDATE users SET name = ?, email = ?, phone = ?, updated_at = ? WHERE user_id = ?',
                [
                    $request->name,
                    $request->email,
                    $request->phone,
                    now(),
                    $user->user_id
                ]
            );

            return redirect()->route('user.dashboard')->with('success', 'Profile updated successfully!');
            
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to update profile: ' . $e->getMessage());
        }
    }
}