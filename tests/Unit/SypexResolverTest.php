<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\SypexGeo;
use PHPUnit\Framework\TestCase;

class SypexTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $sypex = new SypexGeo(new IpAddress(BlanksAndMocks::getIncorrectIpValue()), BlanksAndMocks::getDefaultLanguage());
        $sypex->getLocation();
    }

    public function testGetResultLanguage_defaultLanguage_ShouldReturnDefaultLanguage(): void
    {
        $defaultLanguage = BlanksAndMocks::getDefaultLanguage();
        $sypex = new SypexGeo(BlanksAndMocks::getCorrectIp(), $defaultLanguage);
        $this->assertSame($sypex->getLanguageCode(), $defaultLanguage->getCode());
    }

    public function testGetResultLanguage_ruLanguage_ShouldReturnRuLanguage(): void
    {
        $ruLanguage = BlanksAndMocks::getRuLanguage();
        $sypex = new SypexGeo(BlanksAndMocks::getCorrectIp(), $ruLanguage);
        $this->assertSame($sypex->getLanguageCode(), $ruLanguage->getCode());
    }
}
