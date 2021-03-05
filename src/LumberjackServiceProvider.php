<?php

namespace Lumberjack;

use Illuminate\Support\ServiceProvider;
use Lumberjack\Http\Middleware\LumberjackLogger;
use Illuminate\Contracts\Http\Kernel;

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
