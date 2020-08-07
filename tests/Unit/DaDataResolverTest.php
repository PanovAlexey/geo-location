<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Resolvers\DaDataResolver;
use PHPUnit\Framework\TestCase;

class DaDataResolverTest extends TestCase
{
    function getIncorrectIp()
    {
        return '123456';
    }

    function getEnLanguageCode()
    {
        return 'en';
    }

    function getDefaultLanguage()
    {
        return $this->getEnLanguageCode();
    }

    function testGetLocation_incorrectIp_IncorrectIpException()
    {
        $this->expectException(IncorrectIpException::class);
        $daDataResolver = new DaDataResolver($this->getDefaultLanguage(), $this->getIncorrectIp());
        $daDataResolver->getLocation();
    }
    {
        $this->expectException(IncorrectIpException::class);
        $daDataResolver = new DaDataResolver($this->getDefaultLanguage(), $this->getIncorrectIp());
        $daDataResolver->getLocation();
    }
}
