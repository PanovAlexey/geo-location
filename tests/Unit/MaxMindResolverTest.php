<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\MaxMind;
use PHPUnit\Framework\TestCase;

class MaxMindTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $maxMind = new MaxMind(new IpAddress(BlanksAndMocks::getIncorrectIpValue()), BlanksAndMocks::getDefaultLanguage());
        $maxMind->getLocation();
    }

    public function testGetResultLanguage_defaultLanguage_ShouldReturnDefaultLanguage(): void
    {
        $defaultLanguage = BlanksAndMocks::getDefaultLanguage();
        $maxMind = new MaxMind(BlanksAndMocks::getCorrectIp(), $defaultLanguage);
        $this->assertSame($maxMind->getLanguageCode(), $defaultLanguage->getCode());
    }

    public function testGetResultLanguage_ruLanguage_ShouldReturnRuLanguage(): void
    {
        $ruLanguage = BlanksAndMocks::getRuLanguage();
        $maxMind = new MaxMind(BlanksAndMocks::getCorrectIp(), $ruLanguage);
        $this->assertSame($maxMind->getLanguageCode(), $ruLanguage->getCode());
    }
}
