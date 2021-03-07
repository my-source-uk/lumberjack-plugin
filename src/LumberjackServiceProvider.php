<?php

namespace Lumberjack;

use Illuminate\Support\ServiceProvider;
use Lumberjack\Http\Middleware\LumberjackLogger;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Config;

class LumberjackServiceProvider extends ServiceProvider
{
    use ServiceBindings;
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        /*
         * Optional methods to load your package assets
         */

        if (true === $this->app->runningInConsole()) {
            $this->publishes(
                [
                    __DIR__.'/../config/config.php' => config_path('lumberjack.php'),
                ],
                'lumberjack-config'
            );
        }//end if
        Config::set('database.connections.lumberjack', Config::get('lumberjack.database.connections.lumberjack'));
        
        $this->publishes(
            [
            __DIR__.'/../public' => public_path('vendor/lumberjack'),
            ],
            'lumberjack-assets'
        );

        $this->configureMiddleware();
        $this->registerRoutes();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'lumberjack');

        // Register the main class to use with the facade
        $this->app->singleton(
            'lumberjack',
            function () {
                return new Lumberjack;
            }
        );

        $this->registerServices();
    }

    /**
     * Register the services in the container.
     *
     * @return void
     */
    protected function registerServices()
    {
        foreach ($this->serviceBindings as $key => $value) {
            (true === is_numeric($key)) ? $this->app->singleton($value) : $this->app->singleton($key, $value);
        }
    }

    /**
     * Register the routes.
     *
     * @return void
     */
    protected function registerRoutes()
    {
        Route::group(
            [
            'domain' => config('horizon.domain', null),
            'prefix' => 'lumberjack',
            ],
            function () {
                Route::match(
                    ['post'],
                    '/bye',
                    function () {
                        return json_encode('Goodbye 👋');
                    }
                )->name('lumberjack.bye');
            }
        );
    }

    /**
     * Configure the Sanctum middleware and priority.
     *
     * @return void
     */
    protected function configureMiddleware()
    {
        $router = $this->app->make(Router::class);

        $groups = Config::get('lumberjack.middlewaregroups', 'web');

        if (false === is_array($groups)) {
            $groups = [$groups];
        }
        
        foreach ($groups as $group) {
            $router->pushMiddlewareToGroup($group, LumberjackLogger::class);
        }
    }
}
