<?php

namespace CodeblogPro\GeoLocation\Application\Interfaces;

use CodeblogPro\GeoLocationAddress\LocationInterface;

/**
 * Interface GeoLocationServiceInterface
 * @package CodeblogPro\GeoLocation\Application\Interfaces
 */
interface GeoLocationServiceInterface
{
    public function __construct(string $ip, string $language);

    public function getLocationByIp(): LocationInterface;
}
