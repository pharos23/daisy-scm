<?php

// Ficheiro para detetar a linguagem a ser usada no browser

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class DetectBrowserLocale
{
    protected $supportedLocales = ['en', 'pt'];

    public function handle($request, Closure $next)
    {
        if (!Session::has('locale')) {
            $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

            if (in_array($browserLocale, $this->supportedLocales)) {
                Session::put('locale', $browserLocale);
                App::setLocale($browserLocale);
            } else {
                Session::put('locale', config('app.locale'));
                App::setLocale(config('app.locale'));
            }
        } else {
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}
