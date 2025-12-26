<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class IsAdminorManagerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 1. Ensure the user is authenticated
        if (!Auth::check()) {
            abort(403, 'Access Denied');
        }

        $user = Auth::user();

        // 2. Check for the OR condition: Admin OR Manager
        // You MUST have isAdmin() and isManager() methods on your User model 
        // that return boolean true/false based on the user's role.
        if (Auth::user()->role == 'admin' || Auth::user()->role == 'manager') {
            return $next($request);
        }

        // 3. If neither role is met, deny access
        abort(403, 'Access Denied');
    }
}
