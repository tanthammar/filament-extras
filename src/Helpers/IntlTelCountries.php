<?php
namespace TantHammar\FilamentExtras\Helpers;

class IntlTelCountries
{

    public static function europe(): array
    {
        return ["al", "ad", "at", "by", "be", "ba", "bg", "hr", "cz", "dk",
            "ee", "fo", "fi", "fr", "de", "gi", "gr", "va", "hu", "is", "ie", "it", "lv",
            "li", "lt", "lu", "mk", "mt", "md", "mc", "me", "nl", "no", "pl", "pt", "ro",
            "ru", "sm", "rs", "sk", "si", "es", "se", "ch", "ua", "gb"];
    }

    public static function nordic(): array
    {
        return ["se", "no", "dk", "fi", "is"];
    }

    public static function preferred(): array
    {
        return ["se", "no", "dk", "fi"];
    }

    public static function only(): array
    {
        return array_merge(self::europe(), ["us"]);
    }

}
