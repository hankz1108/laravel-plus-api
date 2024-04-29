<?php

namespace Hankz\LaravelPlusApi;

use Hankz\LaravelPlusApi\Classes\ApiResponseBuilder;
use Illuminate\Support\ServiceProvider;

class LaravelPlusApiServiceProvider extends ServiceProvider
{
    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/laravel-plus-api.php', 'laravel-plus-api');

        $this->publishes([
            __DIR__ . '/../config/laravel-plus-api.php' => config_path('laravel-plus-api.php'),
        ], 'default');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [ApiResponseBuilder::class];
    }
}
