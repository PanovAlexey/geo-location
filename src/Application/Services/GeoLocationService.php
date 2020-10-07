<?php

namespace CodeblogPro\GeoLocation\Application\Services;

use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\GeoIpRemoteServices;
use CodeblogPro\GeoLocation\Application\Interfaces\CurrentIpResolverInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\GeoLocationServiceInterface;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\Models\Language;
use CodeblogPro\GeoLocation\Application\Exceptions\GeoLocationAppException;
use CodeblogPro\GeoLocationAddress\LocationInterface;

class GeoLocationService implements GeoLocationServiceInterface
{
    public function __construct()
    {
    }

    public function getLocationByIpResolverAndLanguageResultCode(
        CurrentIpResolverInterface $currentIpResolver,
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

    public function getLocationByIpAndLanguageResultCode(string $ip, string $languageResultCode): LocationInterface
    {
        $ipAddress = new IpAddress($ip);
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

    public function getCurrentIpByIpResolver(CurrentIpResolverInterface $currentIpResolver): IpAddress
    {
        return $currentIpResolver->getCurrentIp();
    }
}
