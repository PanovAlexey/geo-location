<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Resolvers\SypexGeoResolver;
use PHPUnit\Framework\TestCase;

class SypexResolverTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $sypexResolver = new SypexGeoResolver(BlanksAndMocks::getIncorrectIp(), BlanksAndMocks::getDefaultLanguage());
        $sypexResolver->getLocation();
    }

    public function testGetResultLanguage_defaultLanguage_ShouldReturnDefaultLanguage(): void
    {
        $sypexResolver = new SypexGeoResolver(BlanksAndMocks::getCorrectIp(), BlanksAndMocks::getDefaultLanguage());
        $this->assertSame($sypexResolver->getResultLanguage(), BlanksAndMocks::getDefaultLanguage());
    }

    public function testGetResultLanguage_ruLanguage_ShouldReturnRuLanguage(): void
    {
        $sypexResolver = new SypexGeoResolver(BlanksAndMocks::getCorrectIp(), BlanksAndMocks::getRuLanguageCode());
        $this->assertSame($sypexResolver->getResultLanguage(), BlanksAndMocks::getRuLanguageCode());
    }
}
