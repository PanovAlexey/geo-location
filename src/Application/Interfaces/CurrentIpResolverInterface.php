<?php

namespace CodeblogPro\GeoLocation\Application\Interfaces;

use CodeblogPro\GeoLocation\Application\Models\IpAddress;

interface CurrentIpResolverInterface
{
    public function getCurrentIp(): IpAddress;
}
