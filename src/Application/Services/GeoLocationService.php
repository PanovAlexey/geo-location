<?php

namespace CodeblogPro\GeoLocation\Application\Services;

use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\GeoIpRemoteServices;
use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\Models\Language;
use CodeblogPro\GeoLocation\Application\Exceptions\GeoLocationAppException;

class GeoLocationService
{
    public function getLocationArrayByIp(string $ip, string $resultLanguageCode = ''): array
    {
        return $this->getLocationByIp($ip, $resultLanguageCode)->toArray();
    }

    public function getLocationByIp(string $ip, string $resultLanguageCode = ''): LocationInterface
    {
        $ipAddress = new IpAddress($ip);
        $language = new Language($resultLanguageCode);
        $sortedServices = (GeoIpRemoteServices::getInstance())->getSortedServices();
        $location = $exception = null;

        foreach ($sortedServices as $service) {
            try {
                $location = $service->getLocation($ipAddress, $language);

                if ($location instanceof LocationInterface) {
                    break;
                }
            } catch (Throwable $exception) {
                continue;
            }
        }

        if (!isset($location)) {
            throw new GeoLocationAppException('An error occurred while executing the program. ' . $exception->getMessage());
        }

        return $location;
    }
}