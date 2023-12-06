<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components;
use TantHammar\LaravelRules\Rules\FixedLineNumber;

/**
 * Validates international landline numbers
 */
class LandLineMask
{
    public static function make(string $column = 'phone', ?int $default = 460, string $label = 'fields.phone'): Components\TextInput
    {
        return Components\TextInput::make($column)
            ->label(trans($label))
            ->numeric()
            ->default($default)
            ->rules([
                'bail',
                'sometimes',
                'min:9',
                new FixedLineNumber,
            ])
            ->mask('+99 (9)999 999 99[9 99]')
            ->prefixIcon('heroicon-o-phone');
    }
}
