<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Resolvers\DaDataResolver;
use PHPUnit\Framework\TestCase;

class DaDataResolverTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $daDataResolver = new DaDataResolver(BlanksAndMocks::getIncorrectIp(), BlanksAndMocks::getDefaultLanguage());
        $daDataResolver->getLocation();
    }

    public function testGetResultLanguage_defaultLanguage_ShouldReturnDefaultLanguage(): void
    {
        $daDataResolver = new DaDataResolver(BlanksAndMocks::getCorrectIp(), BlanksAndMocks::getDefaultLanguage());
        $this->assertSame($daDataResolver->getResultLanguage(), BlanksAndMocks::getDefaultLanguage());
    }

    public function testGetResultLanguage_ruLanguage_ShouldReturnRuLanguage(): void
    {
        $daDataResolver = new DaDataResolver(BlanksAndMocks::getCorrectIp(), BlanksAndMocks::getRuLanguageCode());
        $this->assertSame($daDataResolver->getResultLanguage(), BlanksAndMocks::getRuLanguageCode());
    }
}
