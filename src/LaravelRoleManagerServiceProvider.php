<?php

namespace AbdallahK\LaravelRoleManager;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Gate;

class LaravelRoleManagerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/role-manager.php', 'role-manager');
    }

    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'role-manager');
        
        $this->publishes([
            __DIR__.'/../config/role-manager.php' => config_path('role-manager.php'),
        ], 'role-manager-config');

        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/role-manager'),
        ], 'role-manager-views');

        $this->publishes([
            __DIR__.'/../public' => public_path('vendor/role-manager'),
        ], 'role-manager-assets');

        if (method_exists($this, 'loadMigrationsFrom')) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        }

        $this->publishes([
            __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'role-manager-migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\InstallCommand::class,
                Commands\PublishCommand::class,
            ]);
        }

        // Step 1: Add basic gate
        $this->registerGates();
        $this->registerRoutes();
    }

    /**
     * Register basic gates for role manager access
     */
    protected function registerGates()
    {
        Gate::define('access-role-manager', function ($user) {
            // Always allow in local environment
            if (app()->environment('local')) {
                // return true;
            }
            
            
            // Production environment - use config-based authorization
            return $this->checkConfigBasedAuthorization($user);
        });
    }

    /**
     * Check authorization using the config-based system.
     *
     * @param  $user
     * @return bool
     */
    protected function checkConfigBasedAuthorization($user)
    {
        // Check if user has the manage_roles permission (Spatie style)
        if ($user->can('manage_roles')) {
            return true;
        }

        // Check if user has specific role (Spatie style)
        $requiredRoles = config('role-manager.authorization.required_roles', ['admin', 'super-admin']);
        if (!empty($requiredRoles)) {
            foreach ($requiredRoles as $role) {
                if ($user->hasRole($role)) {
                    return true;
                }
            }
        }

        // Check specific user IDs
        $allowedUserIds = config('role-manager.authorization.allowed_user_ids', []);
        if (!empty($allowedUserIds) && in_array($user->id, $allowedUserIds)) {
            return true;
        }

        // Check user email domains
        $allowedDomains = config('role-manager.authorization.allowed_domains', []);
        if (!empty($allowedDomains)) {
            $userDomain = substr(strrchr($user->email, "@"), 1);
            if (in_array($userDomain, $allowedDomains)) {
                return true;
            }
        }

        // Check custom authorization callback if defined
        $customAuth = config('role-manager.authorization.custom_callback');
        if ($customAuth && is_callable($customAuth)) {
            return $customAuth($user);
        }

        return false;
    }

    protected static $routesRegistered = false;

    protected function registerRoutes()
    {
        // Prevent multiple route registrations
        if (static::$routesRegistered) {
            return;
        }
        
        static::$routesRegistered = true;
        
        // Step 1: Add environment-based middleware
        $middleware = config('role-manager.middleware', ['web', 'auth']);
        
        // TESTING: Force the middleware even in local to test the gate
        // if (!app()->environment('local')) {
            $middleware[] = 'can:access-role-manager';
        // }
        
        Route::group([
            'prefix' => config('role-manager.route_prefix', 'admin/roles'),
            'middleware' => $middleware,
            'as' => 'role-manager.',
        ], function () {
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        });

        // Register the main SPA route
        Route::group([
            'prefix' => config('role-manager.route_prefix', 'admin/roles'),
            'middleware' => $middleware,
        ], function () {
            Route::get('/{path?}', function () {
                return view('role-manager::app');
            })->where('path', '.*')->name('role-manager.spa');
        });
    }
}