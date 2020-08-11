<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

use CodeblogPro\GeoLocation\Application\Enums\AvailableLanguages;
use CodeblogPro\GeoLocation\Application\Models\Language;

class BlanksAndMocks
{
    public static function getIncorrectIp(): string
    {
        return '123456';
    }

    public static function getCorrectIp(): string
    {
        return '8.8.8.8';
    }

    public static function getEnLanguage(): LanguageInterface
    {
        return new Language(AvailableLanguages::EN);
    }

    public static function getRuLanguage(): LanguageInterface
    {
        return new Language(AvailableLanguages::RU);
    }

    public static function getDefaultLanguage(): LanguageInterface
    {
        return self::getEnLanguage();
    }
}