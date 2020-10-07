<?php

namespace CodeblogPro\GeoLocation\Application\Interfaces;

use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocationAddress\LocationInterface;

/**
 * Interface GeoLocationServiceInterface
 * @package CodeblogPro\GeoLocation\Application\Interfaces
 */
interface GeoLocationServiceInterface
{
    public function getLocationByIpResolverAndLanguageResultCode(
        CurrentIpResolverInterface $currentIpResolver,
        string $languageResultCode
    ): LocationInterface;

    public function getLocationArrayByIpAndLanguageResultCode(string $ip, string $languageResultCode = ''): array;

    public function getLocationByIpAndLanguageResultCode(string $ip, string $languageResultCode): LocationInterface;

    public function getCurrentIpByIpResolver(CurrentIpResolverInterface $currentIpResolver): IpAddress;
}
