<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Interfaces\RemoteServicesOptions;
use Illuminate\Support\Facades\Config;

class MaxMindOptions implements RemoteServicesOptions
{
    public function isEnabled(): bool
    {
        return (bool)(Config('geolocation.maxmind.enabled') ?? false);
    }

    public function getSort(): int
    {
        return (int)(Config('geolocation.maxmind.sort') ?? 0);
    }

    public function getKey(): string
    {
        return 'Token ' . Config('geolocation.maxmind.key');
    }

    public function getUrl(): string
    {
        return Config('geolocation.maxmind.url');
    }
}