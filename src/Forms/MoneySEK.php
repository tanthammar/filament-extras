<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;
use Filament\Support\RawJs;

class MoneySEK
{
    public static function make(string $column = 'price', string $label = 'fields.price'): TextInput
    {
        return TextInput::make($column)
            ->label(trans($label))
            ->numeric()
            ->mask(RawJs::make("\$money(\$input, ',', ' ')"))
            ->dehydrateStateUsing(fn ($state) => str_replace(',', '.', $state ));
    }
}
