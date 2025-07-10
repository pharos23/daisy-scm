<?php

namespace App\Providers;

use App\Http\Middleware\DetectBrowserLocale;
use App\Http\Middleware\ForcePasswordChange;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

/**
 * AppServiceProvider
 *
 * This service provider is used to bootstrap and register application-level services.
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * This method is used to bind services into the service container.
     * It's useful for registering custom services, bindings, or class aliases.
     */
    public function register(): void
    {
        // No services are registered here for now.
    }

    /**
     * Bootstrap any application services.
     *
     * This method is used to configure services after all other services have been registered.
     * You typically use this method to perform actions like adding middleware, gates, or custom pagination views.
     */
    public function boot(): void
    {
        /**
         * Automatically grant all permissions to the "Super Admin" role.
         * This makes "Super Admin" bypass any explicit permission checks.
         */
        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        /**
         * Push custom middlewares to the "web" middleware group.
         * These will apply to all routes that use the "web" group.
         */
        $router = $this->app['router'];

        // Middleware to detect browser locale and set application language accordingly
        $router->pushMiddlewareToGroup('web', DetectBrowserLocale::class);

        // Middleware to force users to change password if required
        $router->pushMiddlewareToGroup('web', ForcePasswordChange::class);

        /**
         * Set the default pagination view to use a custom template compatible with DaisyUI.
         */
        Paginator::$defaultView = 'vendor.pagination.daisyui';
    }
}
