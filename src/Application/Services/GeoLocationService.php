<?php

namespace CodeblogPro\GeoLocation\Application\Services;

use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\GeoIpRemoteServices;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\Models\Language;
use CodeblogPro\GeoLocation\Application\Exceptions\GeoLocationAppException;
use CodeblogPro\GeoLocation\Application\Services\CurrentIpResolver;
use CodeblogPro\GeoLocationAddress\LocationInterface;

class GeoLocationService
{
    public function __construct()
    {
    }

    public function getLocationByIpResolverAndLanguageResultCode(
        CurrentIpResolver $currentIpResolver,
        string $languageResultCode
    ): LocationInterface {
        return $this->getLocationByIpAndLanguageResultCode(
            $currentIpResolver->getCurrentIp()->getValue(),
            $languageResultCode
        );
    }

    public function getLocationArrayByIpAndLanguageResultCode(string $ip, string $languageResultCode = ''): array
    {
        return $this->getLocationByIpAndLanguageResultCode($ip, $languageResultCode)->toArray();
    }

    public function getLocationByIpAndLanguageResultCode(string $ipValue, string $languageResultCode): LocationInterface
    {
        $ipAddress = new IpAddress($ipValue);
        $language = new Language($languageResultCode);

        $sortedServices = (GeoIpRemoteServices::getInstance())->getSortedServices();
        $location = $exception = null;

        foreach ($sortedServices as $service) {
            try {
                $location = $service->getLocation($ipAddress, $language);
                if ($location instanceof LocationInterface) {
                    break;
                }
            } catch (\Exception $exception) {
                continue;
            }
        }

        if (!isset($location)) {
            throw new GeoLocationAppException(
                'An error occurred while executing the program. ' . $exception->getMessage()
            );
        }

        return $location;
    }

    public function getCurrentIpByIpResolver(CurrentIpResolver $currentIpResolver): IpAddress
    {
        return $currentIpResolver->getCurrentIp();
    }
}
