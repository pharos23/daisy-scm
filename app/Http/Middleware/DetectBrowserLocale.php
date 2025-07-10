<?php

// Middleware to detect the browser's language and set the app locale accordingly

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class DetectBrowserLocale
{
    // Supported locales in the application
    protected $supportedLocales = ['en', 'pt'];

    /**
     * Handle an incoming request and set the locale based on browser settings or session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // If no locale is already set in the session...
        if (!Session::has('locale')) {
            // Get the preferred language from the browser headers (e.g., "en-US", "pt-PT")
            $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

            // If the language is supported, use it
            if (in_array($browserLocale, $this->supportedLocales)) {
                Session::put('locale', $browserLocale);
                App::setLocale($browserLocale);
            } else {
                // If not supported, fallback to the default app locale
                Session::put('locale', config('app.locale'));
                App::setLocale(config('app.locale'));
            }
        } else {
            // If locale already exists in session, use it
            App::setLocale(Session::get('locale'));
        }

        // Continue processing the request
        return $next($request);
    }
}
