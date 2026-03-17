<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if the user is logged in
        if (!Auth::check()) {
            return redirect('/login'); // Redirect to login if not authenticated
        }

        $user = Auth::user();
        
        // 2. Check if the user's role matches the required role
        // The $role parameter comes from the route definition, e.g., 'agent' or 'admin'
        if ($user->role === $role) {
            return $next($request); // Allow access
        }

        // 3. Deny access (e.g., redirect to home or show a 403 page)
        return abort(403, 'Unauthorized action.'); 
    }
}