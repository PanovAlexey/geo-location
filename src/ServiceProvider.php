<?php

namespace CodeblogPro\GeoLocation;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        parent::register();
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . './routes/geo-location.php');

        $this->publishes([
            __DIR__ . './config/geolocation.php' => config_path('geolocation.php'),
            'geolocation-config'
        ]);
        $this->mergeConfigFrom(__DIR__ . 'config/geolocation.php', 'geolocation');
    }
}