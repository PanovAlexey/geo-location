<?php

namespace CodeblogPro\GeoLocation\Application\Interfaces;

/**
 * Interface GeoLocationServiceInterface
 * @package CodeblogPro\GeoLocation\Application\Interfaces
 */
interface GeoLocationServiceInterface
{
    public function __construct(string $ip, string $language);

    public function getLocationByIp(): LocationInterface;
}