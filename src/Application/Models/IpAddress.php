<?php

namespace CodeblogPro\GeoLocation\Application\Models;

use CodeblogPro\GeoLocation\Application\Interfaces\IpAddressInterface;
use CodeblogPro\GeoLocation\Application\Exceptions\IncorrectIpException;

class IpAddress implements IpAddressInterface
{
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $this->validate($value);
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function validate(string $value): string
    {
        $value = trim($value);

        if (!filter_var($value, FILTER_VALIDATE_IP)) {
            throw new IncorrectIpException($value);
        }

        return $value;
    }
}