<?php

namespace Lumberjack;

use Illuminate\Support\ServiceProvider;
use Lumberjack\Http\Middleware\LumberjackLogger;

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
                'config'
            );
        }//end if

        $this->configureMiddleware();
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
    }

    /**
     * Configure the Sanctum middleware and priority.
     *
     * @return void
     */
    protected function configureMiddleware()
    {
        $kernel = $this->app->make(Kernel::class);

        $kernel->appendToMiddlewarePriority(LumberjackLogger::class);
    }
}
