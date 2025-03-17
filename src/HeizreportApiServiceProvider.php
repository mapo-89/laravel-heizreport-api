<?php
/*
 * HeizreportApiServiceProvider.php
 * @author Manuel Postler <info@postler.de>
 * @copyright 2025 Manuel Postler
 */

namespace Mapo89\LaravelHeizreportApi;

use Illuminate\Support\ServiceProvider;

class HeizreportApiServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     */
    public function register()
    {
        // Automatically apply the package configuration
        $this->mergeConfigFrom(__DIR__ . '/../config/config.php', 'heizreport-api');

        // Register the main class to use with the facade
        $this->app->singleton('heizreport-api', function () {
            return new HeizreportApi();
        });
    }

    /**
     * Bootstrap the application services.
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/config.php' => config_path('heizreport-api.php'),
            ], 'config');
        }
    }
}
