<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components;
use TantHammar\LaravelRules\Rules\FixedLineNumber;

/**
 * Validates international landline numbers
 */
class LandLineMask
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
                new FixedLineNumber,
            ])
            ->mask(fn (Components\TextInput\Mask $mask) => $mask->pattern('+00 (0)000 000 00[0 00]')->lazyPlaceholder(false))
            ->prefixIcon('heroicon-o-phone');
    }
}
