<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Tables\Columns\TextInputColumn;

class PriceInputColumn
{
    public static function make(): TextInputColumn
    {
        return TextInputColumn::make('price')
            ->inputMode('decimal')
            ->step('0.50')
            ->type('number')
            ->rules(['nullable', 'numeric']);
    }
}
