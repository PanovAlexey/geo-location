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
    }
 }