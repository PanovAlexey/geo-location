<?php

namespace CodeblogPro\GeoLocation\Application\GeoIpRemoteServices;

class GeoIpRemoteServices
{
    private static $instance = null;
    private array $sortToServicesMap = [];

    private function __construct()
    {
        $this->initServicesMap();
        $this->sortServicesMap();
    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function getSortedToServicesMap(): array
    {
        return $this->sortToServicesMap;
    }

    public function getSortedServices(): array
    {
        $services = [];

        foreach ($this->sortToServicesMap as $remoteServiceSort => $remoteServices) {
            foreach ($remoteServices as $remoteService) {
                $services[] = $remoteService;
            }
        }

        return $services;
    }

    protected function __clone()
    {
    }

    private function initServicesMap()
    {
        $daDataOptions = new DaDataOptions();

        if ($daDataOptions->isEnabled()) {
            $daData = new DaData($daDataOptions);
            $this->sortToServicesMap[$daDataOptions->getSort()][] = $daData;
        }

        $sypexGeoOptions = new SypexGeoOptions();

        if ($sypexGeoOptions->isEnabled()) {
            $sypexGeo = new SypexGeo($sypexGeoOptions);
            $this->sortToServicesMap[$sypexGeoOptions->getSort()][] = $sypexGeo;
        }

        $maxMindOptions = new MaxMindOptions();

        if ($maxMindOptions->isEnabled()) {
            $maxMind = new MaxMind($maxMindOptions);
            $this->sortToServicesMap[$maxMindOptions->getSort()][] = $maxMind;
        }
    }

    private function sortServicesMap()
    {
        ksort($this->sortToServicesMap);
    }
}