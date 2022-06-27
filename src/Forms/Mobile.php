<?php

namespace Tanthammar\FilamentExtras\Forms;

use Filament\Forms\Components;
use Tanthammar\LaravelRules\Rules\PhoneNumber;

class Mobile
{
    public static function input(string $column = 'mobile', int $default = 460, string $label = 'fields.mobile'): Components\TextInput
    {
        return Components\TextInput::make($column)
            ->label(trans($label))
            ->numeric()
            ->default($default)
            ->rules([
                'bail',
                'sometimes',
                'min:10',
                new PhoneNumber,
            ])
            ->mask(fn (Components\TextInput\Mask $mask) => $mask->pattern('+00 (0)000 000 000[ 00]')->lazyPlaceholder(false))
            ->prefixIcon('heroicon-o-device-mobile');
    }
}
