<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIpException;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\DaDataOptions;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\DaData;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\SypexGeoOptions;
use PHPUnit\Framework\TestCase;

class DaDataTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $daDataOptions = new DaDataOptions();
        $daData = new DaData($daDataOptions);
        $daData->getLocation(BlanksAndMocks::getIncorrectIp(), BlanksAndMocks::getDefaultLanguage());
    }
}
