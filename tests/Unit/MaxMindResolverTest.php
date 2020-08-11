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
        $defaultLanguage = BlanksAndMocks::getDefaultLanguage();
        $maxMindResolver = new MaxMindResolver(BlanksAndMocks::getCorrectIp(), $defaultLanguage);
        $this->assertSame($maxMindResolver->getLanguageCode(), $defaultLanguage->getCode());
    }

    public function testGetResultLanguage_ruLanguage_ShouldReturnRuLanguage(): void
    {
        $ruLanguage = BlanksAndMocks::getRuLanguage();
        $maxMindResolver = new MaxMindResolver(BlanksAndMocks::getCorrectIp(), $ruLanguage);
        $this->assertSame($maxMindResolver->getLanguageCode(), $ruLanguage->getCode());
    }
}
