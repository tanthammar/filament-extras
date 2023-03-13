<?php

namespace TantHammar\FilamentExtras\Forms;

use TantHammar\FilamentExtras\Enums\PhoneInputNumberFormat;
use TantHammar\FilamentExtras\Enums\PhoneInputNumberType;
use TantHammar\FilamentExtras\Enums\PlaceholderMethod;
use TantHammar\FilamentExtras\Helpers\IntlTelCountries;
use TantHammar\LaravelRules\Rules\FixedLineNumber;

class LandlineIntlTel
{
    public static function make(string $column = 'phone', string $label = 'fields.phone'): PhoneInput
    {
        return PhoneInput::make($column)
            ->label(trans($label))
            ->preferredCountries(IntlTelCountries::preferred())
            ->onlyCountries(IntlTelCountries::only())
            ->displayNumberFormat(PhoneInputNumberFormat::NATIONAL)
            ->placeholderFormat(PhoneInputNumberType::FIXED_LINE)
            ->placeholderMethod(PlaceholderMethod::AGGRESSIVE)
            ->geoIpLookup(false)
            ->rules([
                'bail',
                'sometimes',
                'min:9',
                new FixedLineNumber,
            ])
            ->prefixIcon('heroicon-o-phone');
    }
}
