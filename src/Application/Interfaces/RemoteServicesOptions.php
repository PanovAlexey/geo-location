<?php

namespace CodeblogPro\GeoLocation\Application\Interfaces;

interface RemoteServicesOptions
{
    public function isEnabled(): bool;

    public function getSort(): int;

    public function getKey(): string;

    public function getUrl(): string;
}
