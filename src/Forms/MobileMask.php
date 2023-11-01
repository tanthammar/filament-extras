<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components;
use TantHammar\LaravelRules\Rules\MobileNumber;

/**
 * validates international mobile numbers
 */
class MobileMask
{
    public static function make(string $column = 'mobile', null|int $default = 460, string $label = 'fields.mobile'): Components\TextInput
    {
        return Components\TextInput::make($column)
            ->label(trans($label))
            ->numeric()
            ->default($default)
            ->rules([
                'bail',
                'sometimes',
                'min:10',
                new MobileNumber,
            ])
            ->mask('+99 (9)999 999 99[ 99]')
            ->prefixIcon('heroicon-o-device-phone-mobile');
    }
}
