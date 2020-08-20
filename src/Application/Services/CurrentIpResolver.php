<?php

namespace CodeblogPro\GeoLocation\Application\Services;

class CurrentIpResolver
{
    public function getCurrentIp()
    {
        return $this->getIpByServerGlobalArray();
    }

    private function getIpByServerGlobalArray(): string
    {
        if (!empty($_SERVER['REMOTE_ADDR']) && $this->isIpValid($ipAddress = trim($_SERVER['REMOTE_ADDR']))) {
            return $ipAddress;
        } elseif (!empty($_SERVER['HTTP_CLIENT_IP']) && $this->isIpValid($ipAddress = trim($_SERVER['HTTP_CLIENT_IP']))) {
            return $ipAddress;
        } elseif (
            !empty($_SERVER['HTTP_X_FORWARDED_FOR'])
            && $this->isIpValid($ipAddress = trim($_SERVER['HTTP_X_FORWARDED_FOR']))
        ) {
            return $ipAddress;
        }

        return '';
    }

    private function isIpValid(string $ipAddress = ''): bool
    {
        return (bool)(filter_var($ipAddress, FILTER_VALIDATE_IP));
    }
}
