<?php

namespace TantHammar\FilamentExtras\Forms;

use TantHammar\FilamentExtras\Enums\PhoneInputNumberFormat;
use TantHammar\FilamentExtras\Enums\PhoneInputNumberType;
use TantHammar\FilamentExtras\Enums\PlaceholderMethod;
use TantHammar\FilamentExtras\Helpers\IntlTelCountries;
use TantHammar\LaravelRules\Rules\PhoneNumber;

/**
 * Validates international mobile or landline number
 */
class PhoneIntlTel
{
    public static function make(string $column = 'mobile', string $label = 'fields.phone'): PhoneInput
    {
        return PhoneInput::make($column)
            ->label(trans($label))
            ->preferredCountries(IntlTelCountries::preferred())
            ->onlyCountries(IntlTelCountries::only())
            ->displayNumberFormat(PhoneInputNumberFormat::NATIONAL)
            ->placeholderFormat(PhoneInputNumberType::FIXED_LINE_OR_MOBILE)
            ->placeholderMethod(PlaceholderMethod::AGGRESSIVE)
            ->geoIpLookup(false)
            ->rules([
                'bail',
                'sometimes',
                'min:8',
                new PhoneNumber,
            ])
            ->prefixIcon('heroicon-o-phone');
    }
}
