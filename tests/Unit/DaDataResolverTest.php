<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIPException;
use CodeblogPro\GeoLocation\Application\Interfaces\LocationInterface;
use CodeblogPro\GeoLocation\Application\Resolvers\DaDataResolver;
use PHPUnit\Framework\TestCase;

class DaDataResolverTest extends TestCase
{
    function getIncorrectIp()
    {
        return '123456';
    }

    function getCorrectIp()
    {
        return '8.8.8.8';
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

    function testGetLocation_correctInputData_Location(): void
    {
        $daDataResolverMock = $this->getMockBuilder(DaDataResolver::class)
            ->disableOriginalConstructor()
            ->setMethods(['prepareRequest'])
            ->getMock();

        $location = $daDataResolverMock->getLocation();

        $this->assertInstanceOf(LocationInterface::class, $location);
    }
}
