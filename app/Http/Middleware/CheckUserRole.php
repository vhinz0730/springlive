<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Check if the user's role is 0 or 1
        if (auth()->user()->role_id !== 0 && auth()->user()->role_id !== 1) {
            abort(403, 'Unauthorized');
        }
        return $next($request);
    }
}
