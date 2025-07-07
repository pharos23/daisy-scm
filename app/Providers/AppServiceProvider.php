<?php

namespace App\Providers;

use App\Http\Middleware\DetectBrowserLocale;
use App\Http\Middleware\ForcePasswordChange;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        $router = $this->app['router'];
        $router->pushMiddlewareToGroup('web', \App\Http\Middleware\DetectBrowserLocale::class);
        $router->pushMiddlewareToGroup('web', \App\Http\Middleware\ForcePasswordChange::class);

        Paginator::$defaultView = 'vendor.pagination.daisyui';
    }
}
