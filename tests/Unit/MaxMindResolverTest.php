<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Resolvers\MaxMindResolver;
use PHPUnit\Framework\TestCase;

class MaxMindResolverTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $maxMindResolver = new MaxMindResolver(BlanksAndMocks::getIncorrectIp(), BlanksAndMocks::getDefaultLanguage());
        $maxMindResolver->getLocation();
    }

    public function testGetResultLanguage_defaultLanguage_ShouldReturnDefaultLanguage(): void
    {
        $maxMindResolver = new MaxMindResolver(BlanksAndMocks::getCorrectIp(), BlanksAndMocks::getDefaultLanguage());
        $this->assertSame($maxMindResolver->getResultLanguage(), BlanksAndMocks::getDefaultLanguage());
    }

    public function testGetResultLanguage_ruLanguage_ShouldReturnRuLanguage(): void
    {
        $maxMindResolver = new MaxMindResolver(BlanksAndMocks::getCorrectIp(), BlanksAndMocks::getRuLanguageCode());
        $this->assertSame($maxMindResolver->getResultLanguage(), BlanksAndMocks::getRuLanguageCode());
    }
}
