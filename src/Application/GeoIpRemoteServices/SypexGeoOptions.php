<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Interfaces\RemoteServicesOptions;
use Illuminate\Support\Facades\Config;

class SypexGeoOptions implements RemoteServicesOptions
{
    public function isEnabled(): bool
    {
        return (bool)(Config('geolocation.sypex.enabled') ?? false);
    }

    public function getSort(): int
    {
        return (int)(Config('geolocation.sypex.sort') ?? 0);
    }

    public function getKey(): string
    {
        return 'Token ' . Config('geolocation.sypex.key');
    }

    public function getUrl(): string
    {
        return Config('geolocation.sypex.url');
    }
}