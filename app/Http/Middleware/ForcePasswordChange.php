<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForcePasswordChange
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->force_password_change) {
            $allowedRoutes = ['forcepassword.change', 'forcepassword.update', 'logout'];

            if (!in_array($request->route()?->getName(), $allowedRoutes)) {
                return redirect()->route('forcepassword.change')
                    ->with('message', 'You must change your password before continuing.');
            }
        }

        return $next($request);
    }
}
