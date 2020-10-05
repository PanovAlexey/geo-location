<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Enums\AvailableLanguages;
use CodeblogPro\GeoLocation\Application\Interfaces\IpAddressInterface;
use CodeblogPro\GeoLocation\Application\Interfaces\LanguageInterface;
use CodeblogPro\GeoLocation\Application\Models\IpAddress;
use CodeblogPro\GeoLocation\Application\Models\Language;

class BlanksAndMocks
{
    public static function getIncorrectIp(): IpAddressInterface
    {
        return new IpAddress('123');
    }

    public static function getCorrectIp(): IpAddressInterface
    {
        return new IpAddress('8.8.8.8');
    }

    public static function getEnLanguage(): LanguageInterface
    {
        return new Language(AvailableLanguages::EN);
    }

    public static function getRuLanguage(): LanguageInterface
    {
        return new Language(AvailableLanguages::RU);
    }

    public static function getEmptyLanguage(): LanguageInterface
    {
        return new Language('');
    }

    public static function getDefaultLanguage(): LanguageInterface
    {
        return self::getEnLanguage();
    }
}
