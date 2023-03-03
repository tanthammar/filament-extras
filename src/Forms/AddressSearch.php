<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\Select;
use TantHammar\FilamentExtras\Services\Nominatim;

class AddressSearch
{
    public static function make(string $jsonColumnName = 'address', bool $replaceFormData = false): Select
    {
        $field = Select::make('nominatimSearch')
            ->label(trans('filament-extras::misc.nominatim-search-label'))
            ->placeholder(trans('filament-extras::misc.nominatim-search-placeholder'))
            ->searchable()
            ->ignored()
            ->reactive()
            ->getSearchResultsUsing(fn (string $search) => Nominatim::search($search));

        return $replaceFormData
            ? $field->afterStateUpdated(function ($livewire, $state) {
                if ($state) {
                    $livewire->data = Nominatim::lookup(osm_id: $state, existingFieldValue: $livewire->data);
                }
            })
            : $field->afterStateUpdated(function ($set, $get, $state) use ($jsonColumnName) {
                if ($state) {
                    $set($jsonColumnName, Nominatim::lookup(osm_id: $state, existingFieldValue: $get($jsonColumnName)));
                }
            });

    }
}
