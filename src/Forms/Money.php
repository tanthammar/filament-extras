<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

use NumberFormatter;

class Money
{
    public static function make(string $column = 'price', string $label = 'fields.price'): TextInput
    {
        return TextInput::make($column)
            ->label(trans($label))
            ->numeric() //Keep numeric() before step(), else step will eq 'any'
            ->step('0.50');
    }
}
