<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIpException;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\MaxMindOptions;
use CodeblogPro\GeoLocation\Application\GeoIpRemoteServices\MaxMind;
use PHPUnit\Framework\TestCase;

class MaxMindTest extends TestCase
{
    public function testGetLocation_incorrectIp_IncorrectIpException(): void
    {
        $this->expectException(IncorrectIpException::class);
        $maxMindOptions = new MaxMindOptions();
        $maxMind = new MaxMind($maxMindOptions);
        $maxMind->getLocation(BlanksAndMocks::getIncorrectIp(), BlanksAndMocks::getDefaultLanguage());
    }
}
