<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Schemas\Components\Section;

class AddressSection
{
    public static function make(string $jsonColumnName = 'address', string $label = 'Address'): Section
    {
        return Section::make(__($label))
            ->schema(array_merge(
                [AddressSearch::make($jsonColumnName)],
                AddressFields::make($jsonColumnName),
            ))->columns(2)
            ->collapsible();
    }
}
