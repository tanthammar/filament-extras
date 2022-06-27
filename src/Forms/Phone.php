<?php

namespace Tanthammar\FilamentExtras\Forms;

use Filament\Forms\Components;

class Phone
{
    public static function input(string $column = 'phone', int $default = 460, string $label = 'fields.phone'): Components\TextInput
    {
        return Components\TextInput::make($column)
            ->label(trans($label))
            ->numeric()
            ->default($default)
            ->rules([
                'bail',
                'sometimes',
                'min:10',
                new \Tanthammar\LaravelRules\Rules\PhoneNumber,
            ])
            ->mask(fn (Components\TextInput\Mask $mask) => $mask->pattern('+00 (0)000 000 000[ 00]')->lazyPlaceholder(false))
            ->prefixIcon('heroicon-o-phone');
    }
}
