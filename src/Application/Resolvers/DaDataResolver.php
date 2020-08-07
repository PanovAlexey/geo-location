<?php

namespace CodeblogPro\GeoLocation\Application\Resolvers;

use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIpException;

class DaDataResolver extends Resolver
{
    private string $resultLanguage;
    private string $ip;

    public function __construct(string $resultLanguage, string $ip)
    {
        $this->resultLanguage = $resultLanguage;
        $this->setIp($ip);
    }

    private function setIp(string $ip)
    {
        if (!$this->isIpValid($ip)) {
            throw new IncorrectIpException();
        }

        $this->ip = $ip;
    }

    private function isIpValid(string $ip)
    {
        if (!filter_var($ip, FILTER_VALIDATE_IP)) {
            return false;
        }

        return true;
    }

    private function getKey()
    {
        return config('geolocation.dadata.key');
    }

    private function getUrl()
    {
        return config('geolocation.dadata.url');
    }
}