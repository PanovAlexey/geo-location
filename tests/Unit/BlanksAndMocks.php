<?php

namespace CodeblogPro\GeoLocation\Tests\Unit;

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

    public static function getEnLanguageCode(): string
    {
        return 'en';
    }

    public static function getDefaultLanguage(): string
    {
        return self::getEnLanguageCode();
    }
}