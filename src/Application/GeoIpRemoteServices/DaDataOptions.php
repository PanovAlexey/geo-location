<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

use CodeblogPro\GeoLocation\Application\Interfaces\RemoteServicesOptions;
use Illuminate\Support\Facades\Config;

class DaDataOptions implements RemoteServicesOptions
{
    public function isEnabled(): bool
    {
        return (bool)(Config('geolocation.dadata.enabled') ?? false);
    }

    public function getSort(): int
    {
        return (int)(Config('geolocation.dadata.sort') ?? 0);
    }

    public function getKey(): string
    {
        return 'Token ' . Config('geolocation.dadata.key');
    }

    public function getUrl(): string
    {
        return Config('geolocation.dadata.url');
    }
}