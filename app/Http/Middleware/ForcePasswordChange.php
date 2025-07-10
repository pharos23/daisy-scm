<?php

// Middleware to force a user to change their password before accessing other parts of the application

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * This middleware checks if the authenticated user is required to change their password.
     * If so, it redirects them to the forced password change page unless they are already on
     * an allowed route (such as the password change or logout routes).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Get the currently authenticated user
        $user = $request->user();

        // Check if user is logged in and the "force_password_change" flag is set to true
        if ($user && $user->force_password_change) {
            // Define routes that should be accessible even if password change is required
            $allowedRoutes = ['forcepassword.change', 'forcepassword.update', 'logout'];

            // If the current route is not one of the allowed routes, redirect to password change form
            if (!in_array($request->route()?->getName(), $allowedRoutes)) {
                return redirect()->route('forcepassword.change')
                    ->with('message', 'You must change your password before continuing.');
            }
        }

        // If everything is fine, continue processing the request
        return $next($request);
    }
}
