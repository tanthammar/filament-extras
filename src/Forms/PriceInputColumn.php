<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Tables\Columns\TextInputColumn;

class PriceInputColumn
{
    public static function make(): void
    {
        TextInputColumn::make('price')
            ->updateStateUsing(fn ($state) => $state === '' ? null : $state)
            ->inputMode('decimal')
            ->step('0.50')
            ->type('number')
            ->rules(['nullable', 'numeric']);
    }

}
