<?php

namespace TantHammar\FilamentExtras\Forms;

use TantHammar\FilamentExtras\Helpers\IntlTelCountries;
use TantHammar\LaravelRules\Rules\FixedLineNumber;
use Ysfkaya\FilamentPhoneInput\PhoneInput;

class LandlineIntlTel
{
    public static function make(string $column = 'mobile', string $label = 'fields.phone'): PhoneInput
    {
        return PhoneInput::make($column)
            ->label(trans($label))
            ->preferredCountries(IntlTelCountries::preferred())
            ->onlyCountries(IntlTelCountries::only())
            ->rules([
                'bail',
                'sometimes',
                'min:10',
                new FixedLineNumber,
            ])
            ->prefixIcon('heroicon-o-phone');
    }
}
