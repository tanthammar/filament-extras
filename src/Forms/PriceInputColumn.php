<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Tables\Columns\TextInputColumn;

class PriceInputColumn
{
    public static function make(): TextInputColumn
    {
        return TextInputColumn::make('price')
            ->label(__('fields.price'))
            ->type('number')
            ->inputMode('decimal')
            ->step(0.50)
            ->rules(['nullable', 'numeric']);
    }
}
