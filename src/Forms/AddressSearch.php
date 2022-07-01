<?php

namespace TantHammar\FilamentExtras\Forms;

use Closure;
use Filament\Forms\Components\Select;
use TantHammar\FilamentExtras\Services\Nominatim;

class AddressSearch
{
    public static function make(string $jsonColumnName = 'address'): Select
    {
        return Select::make('nominatimSearch')
            ->searchable()
            ->ignored()
            ->reactive()
            ->getSearchResultsUsing(fn(string $search) => Nominatim::search($search))
            ->afterStateUpdated(function (Closure $set, $state) use ($jsonColumnName) {
                $set($jsonColumnName, Nominatim::lookup($state));
            });
    }
}
