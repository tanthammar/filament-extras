<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class MoneySEK
{
    public static function make(string $column = 'price', string $label = 'fields.price'): TextInput
    {
        return TextInput::make($column)
            ->label(trans($label))
            ->loadAs(fn ($state) => str_replace('.', ',', $state)) //DB uses dot, SEK uses comma.
            ->mask(fn (TextInput\Mask $mask) => $mask->patternBlocks(['money' => fn (TextInput\Mask $mask) => $mask->numeric()
                ->thousandsSeparator(' ')
                ->decimalSeparator(',')
                ->signed(), //allows negative numbers
            ])->pattern('kr money'));

    }
}
