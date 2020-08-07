<?php

namespace CodeblogPro\GeoLocation\Application\Interfaces;

/**
 * Interface GetLocationServiceInterface
 * @package CodeblogPro\GeoLocation\Application\Interfaces
 */
interface GetLocationServiceInterface
{
    public function __construct(string $ip, string $language);

    public function getLocationByIp(): LocationInterface;
}