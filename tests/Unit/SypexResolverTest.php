<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIpException;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\SypexGeoOptions;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\SypexGeo;
use PHPUnit\Framework\TestCase;

class SypexTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $sypexGeoOptions = new SypexGeoOptions();
        $sypexGeo = new SypexGeo($sypexGeoOptions);
        $sypexGeo->getLocation(BlanksAndMocks::getIncorrectIp(), BlanksAndMocks::getDefaultLanguage());
    }
}
