<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\DaData;
use PHPUnit\Framework\TestCase;

class DaDataTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $daData = new DaData(new IpAddress(BlanksAndMocks::getIncorrectIpValue()), BlanksAndMocks::getDefaultLanguage());
        $daData->getLocation();
    }
    
    public function testGetResultLanguage_defaultLanguage_ShouldReturnDefaultLanguage(): void
    {
        $defaultLanguage = BlanksAndMocks::getDefaultLanguage();
        $daData = new DaData(BlanksAndMocks::getCorrectIp(), $defaultLanguage);
        $this->assertSame($daData->getLanguageCode(), $defaultLanguage->getCode());
    }

    public function testGetResultLanguage_ruLanguage_ShouldReturnRuLanguage(): void
    {
        $ruLanguage = BlanksAndMocks::getRuLanguage();
        $daData = new DaData(BlanksAndMocks::getCorrectIp(), $ruLanguage);
        $this->assertSame($daData->getLanguageCode(), $ruLanguage->getCode());
    }
}
