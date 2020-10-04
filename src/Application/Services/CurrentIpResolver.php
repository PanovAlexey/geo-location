<?php

namespace CodeblogPro\GeoLocation\Application\Services;

use CodeblogPro\GeoLocation\Application\Interfaces\CurrentIpResolverInterface;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;

class CurrentIpResolver implements CurrentIpResolverInterface
{
    public function getCurrentIp(): IpAddress
    {
        return $this->getIpByServerGlobalArray();
    }

    private function getIpByServerGlobalArray(): IpAddress
    {
        $ipAddressString = '';

        if (!empty($_SERVER['REMOTE_ADDR']) && $this->isIpValid($remoteAddrIpAddressString = trim($_SERVER['REMOTE_ADDR']))) {
            $ipAddressString = $remoteAddrIpAddressString;
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP']) && $this->isIpValid($httpClientIpAddressString = trim($_SERVER['HTTP_CLIENT_IP']))) {
            $ipAddressString = $httpClientIpAddressString;
        } else (
            !empty($_SERVER['HTTP_X_FORWARDED_FOR'])
            && $this->isIpValid($httpForwardedIpAddressString = trim($_SERVER['HTTP_X_FORWARDED_FOR']))
        ) {
            $ipAddressString = $httpForwardedIpAddressString;
        }

        return new IpAddress($ipAddressString);
    }

    private function isIpValid(string $ipAddress = ''): bool
    {
        return (bool)(filter_var($ipAddress, FILTER_VALIDATE_IP));
    }
}
