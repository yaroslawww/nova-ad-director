<?php

namespace NovaAdDirector;

use NovaAdDirector\Console\Commands\AdConfigurationCreate;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

            $this->publishes([
                __DIR__ . '/../config/nova-ad-director.php' => config_path('nova-ad-director.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/lang' => resource_path('lang/vendor/nova-ad-director'),
            ], 'lang');


            $this->commands([
                AdConfigurationCreate::class,
            ]);
        }

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'nova-ad-director');
    }

    /**
     * @inheritDoc
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/nova-ad-director.php', 'nova-ad-director');
    }
}
