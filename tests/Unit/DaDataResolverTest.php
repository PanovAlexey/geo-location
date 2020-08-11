<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\Resolvers\DaDataResolver;
use PHPUnit\Framework\TestCase;

class DaDataResolverTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $daDataResolver = new DaDataResolver(new IpAddress(BlanksAndMocks::getIncorrectIpValue()), BlanksAndMocks::getDefaultLanguage());
        $daDataResolver->getLocation();
    }
    
    public function testGetResultLanguage_defaultLanguage_ShouldReturnDefaultLanguage(): void
    {
        $defaultLanguage = BlanksAndMocks::getDefaultLanguage();
        $daDataResolver = new DaDataResolver(BlanksAndMocks::getCorrectIp(), $defaultLanguage);
        $this->assertSame($daDataResolver->getLanguageCode(), $defaultLanguage->getCode());
    }

    public function testGetResultLanguage_ruLanguage_ShouldReturnRuLanguage(): void
    {
        $ruLanguage = BlanksAndMocks::getRuLanguage();
        $daDataResolver = new DaDataResolver(BlanksAndMocks::getCorrectIp(), $ruLanguage);
        $this->assertSame($daDataResolver->getLanguageCode(), $ruLanguage->getCode());
    }
}
