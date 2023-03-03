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
            ->numeric()
            ->mask(fn (TextInput\Mask $mask) => $mask->patternBlocks(['money' => fn (TextInput\Mask $mask) => $mask
                ->numeric()
                ->thousandsSeparator(' ')
                ->decimalPlaces(2)
                ->decimalSeparator(',')
                ->mapToDecimalSeparator(['.']) //DB uses dot, SEK uses comma.
                ->padFractionalZeros() // Pad zeros at the end of the number to always maintain the maximum number of decimal places.
                ->signed(), //allows negative numbers
            ])->pattern('kr money'));

    }
}
