<?php

namespace TantHammar\FilamentExtras\Forms;

use TantHammar\FilamentExtras\Helpers\IntlTelCountries;
use TantHammar\LaravelRules\Rules\MobileNumber;
use Ysfkaya\FilamentPhoneInput\PhoneInput;

class MobileIntlTel
{
    public static function make(string $column = 'mobile', string $label = 'fields.mobile'): PhoneInput
    {
        return PhoneInput::make($column)
            ->label(trans($label))
            ->preferredCountries(IntlTelCountries::preferred())
            ->onlyCountries(IntlTelCountries::only())
            ->rules([
                'bail',
                'sometimes',
                'min:10',
                new MobileNumber,
            ])
            ->prefixIcon('heroicon-o-device-mobile');
    }
}
