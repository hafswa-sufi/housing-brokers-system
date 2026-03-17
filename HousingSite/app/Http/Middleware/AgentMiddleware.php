<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AgentMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login.form');
        }

        // Check if user is an agent
        if (!Auth::user()->isAgent()) {
            return redirect()->route('home')->with('error', 'Access denied. Agent privileges required.');
        }

        return $next($request);
    }
}