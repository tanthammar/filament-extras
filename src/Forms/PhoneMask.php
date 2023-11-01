<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components;
use TantHammar\LaravelRules\Rules\PhoneNumber;

/**
 * Validates international mobile or landline number
 */
class PhoneMask
{
    public static function make(string $column = 'phone', null|int $default = 460, string $label = 'fields.phone'): Components\TextInput
    {
        return Components\TextInput::make($column)
            ->label(trans($label))
            ->numeric()
            ->default($default)
            ->rules([
                'bail',
                'sometimes',
                'min:9',
                new PhoneNumber,
            ])
            ->mask('+99 (9)999 999 999[ 99]')
            ->prefixIcon('heroicon-o-phone');
    }
}
