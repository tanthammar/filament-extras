<?php

namespace TantHammar\FilamentExtras\Helpers;

class IntlTelCountries
{
    /**
     * All ISO 3166-1 alpha-2 country codes supported by intl-tel-input.
     */
    public static function all(): array
    {
        return [
            'af', 'al', 'dz', 'as', 'ad', 'ao', 'ai', 'aq', 'ag', 'ar', 'am', 'aw', 'au', 'at', 'az',
            'bs', 'bh', 'bd', 'bb', 'by', 'be', 'bz', 'bj', 'bm', 'bt', 'bo', 'ba', 'bw', 'br', 'io',
            'vg', 'bn', 'bg', 'bf', 'bi', 'kh', 'cm', 'ca', 'cv', 'ky', 'cf', 'td', 'cl', 'cn', 'cx',
            'cc', 'co', 'km', 'cg', 'cd', 'ck', 'cr', 'ci', 'hr', 'cu', 'cw', 'cy', 'cz', 'dk', 'dj',
            'dm', 'do', 'ec', 'eg', 'sv', 'gq', 'er', 'ee', 'sz', 'et', 'fk', 'fo', 'fj', 'fi', 'fr',
            'gf', 'pf', 'ga', 'gm', 'ge', 'de', 'gh', 'gi', 'gr', 'gl', 'gd', 'gp', 'gu', 'gt', 'gg',
            'gn', 'gw', 'gy', 'ht', 'hn', 'hk', 'hu', 'is', 'in', 'id', 'ir', 'iq', 'ie', 'im', 'il',
            'it', 'jm', 'jp', 'je', 'jo', 'kz', 'ke', 'ki', 'xk', 'kw', 'kg', 'la', 'lv', 'lb', 'ls',
            'lr', 'ly', 'li', 'lt', 'lu', 'mo', 'mg', 'mw', 'my', 'mv', 'ml', 'mt', 'mh', 'mq', 'mr',
            'mu', 'yt', 'mx', 'fm', 'md', 'mc', 'mn', 'me', 'ms', 'ma', 'mz', 'mm', 'na', 'nr', 'np',
            'nl', 'nc', 'nz', 'ni', 'ne', 'ng', 'nu', 'nf', 'kp', 'mk', 'mp', 'no', 'om', 'pk', 'pw',
            'ps', 'pa', 'pg', 'py', 'pe', 'ph', 'pl', 'pt', 'pr', 'qa', 're', 'ro', 'ru', 'rw', 'bl',
            'sh', 'kn', 'lc', 'mf', 'pm', 'vc', 'ws', 'sm', 'st', 'sa', 'sn', 'rs', 'sc', 'sl', 'sg',
            'sx', 'sk', 'si', 'sb', 'so', 'za', 'kr', 'ss', 'es', 'lk', 'sd', 'sr', 'sj', 'se', 'ch',
            'sy', 'tw', 'tj', 'tz', 'th', 'tl', 'tg', 'tk', 'to', 'tt', 'tn', 'tr', 'tm', 'tc', 'tv',
            'ug', 'ua', 'ae', 'gb', 'us', 'vi', 'uy', 'uz', 'vu', 'va', 've', 'vn', 'wf', 'ye', 'zm', 'zw',
        ];
    }

    /**
     * Get localized country names for all countries.
     *
     * @param  string|null  $locale  e.g. 'sv', 'de', 'fr'. Defaults to app()->getLocale()
     */
    public static function localized(?string $locale = null): array
    {
        $locale = $locale ?? app()->getLocale();
        $countries = [];

        foreach (self::all() as $code) {
            $name = \Locale::getDisplayRegion("-{$code}", $locale);
            if ($name && $name !== strtoupper($code)) {
                $countries[$code] = $name;
            }
        }

        return $countries;
    }

    public static function europe(): array
    {
        return [
            'al', 'ad', 'at', 'by', 'be', 'ba', 'bg', 'hr', 'cz', 'dk',
            'ee', 'fo', 'fi', 'fr', 'de', 'gi', 'gr', 'va', 'hu', 'is', 'ie', 'it', 'lv',
            'li', 'lt', 'lu', 'mk', 'mt', 'md', 'mc', 'me', 'nl', 'no', 'pl', 'pt', 'ro',
            'ru', 'sm', 'rs', 'sk', 'si', 'es', 'se', 'ch', 'ua', 'gb',
        ];
    }

    public static function nordic(): array
    {
        return ['se', 'no', 'dk', 'fi', 'is'];
    }

    public static function preferred(): array
    {
        return ['se', 'no', 'dk', 'fi'];
    }

    public static function only(): array
    {
        return array_merge(self::europe(), ['us']);
    }
}
