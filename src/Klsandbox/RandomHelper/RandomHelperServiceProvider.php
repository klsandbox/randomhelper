<?php

namespace Klsandbox\RandomHelper;

use Illuminate\Support\ServiceProvider;

class RandomHelperServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../../../config/' => config_path(),
                ], 'config');
    }
}
