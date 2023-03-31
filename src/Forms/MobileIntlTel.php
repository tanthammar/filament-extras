<?php

namespace TantHammar\FilamentExtras\Forms;

use TantHammar\FilamentExtras\Enums\PhoneInputNumberFormat;
use TantHammar\FilamentExtras\Enums\PhoneInputNumberType;
use TantHammar\FilamentExtras\Enums\PlaceholderMethod;
use TantHammar\FilamentExtras\Helpers\IntlTelCountries;
use TantHammar\LaravelRules\Rules\MobileNumber;

class MobileIntlTel
{
    public static function make(string $column = 'mobile', string $label = 'fields.mobile'): PhoneInput
    {
        return PhoneInput::make($column)
            ->label(trans($label))
            ->preferredCountries(IntlTelCountries::preferred())
            ->onlyCountries(IntlTelCountries::only())
            ->displayNumberFormat(PhoneInputNumberFormat::NATIONAL)
            ->placeholderFormat(PhoneInputNumberType::MOBILE)
            ->placeholderMethod(PlaceholderMethod::AGGRESSIVE)
            ->geoIpLookup(false)
            ->rules([
                'bail',
                'sometimes',
                'min:10',
                new MobileNumber,
            ])
            ->prefixIcon('heroicon-o-device-phone-mobile');
    }
}
