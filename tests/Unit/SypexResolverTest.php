<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\Resolvers\SypexGeoResolver;
use PHPUnit\Framework\TestCase;

class SypexResolverTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $sypexResolver = new SypexGeoResolver(new IpAddress(BlanksAndMocks::getIncorrectIpValue()), BlanksAndMocks::getDefaultLanguage());
        $sypexResolver->getLocation();
    }

    public function testGetResultLanguage_defaultLanguage_ShouldReturnDefaultLanguage(): void
    {
        $defaultLanguage = BlanksAndMocks::getDefaultLanguage();
        $sypexResolver = new SypexGeoResolver(BlanksAndMocks::getCorrectIp(), $defaultLanguage);
        $this->assertSame($sypexResolver->getLanguageCode(), $defaultLanguage->getCode());
    }

    public function testGetResultLanguage_ruLanguage_ShouldReturnRuLanguage(): void
    {
        $ruLanguage = BlanksAndMocks::getRuLanguage();
        $sypexResolver = new SypexGeoResolver(BlanksAndMocks::getCorrectIp(), $ruLanguage);
        $this->assertSame($sypexResolver->getLanguageCode(), $ruLanguage->getCode());
    }
}
