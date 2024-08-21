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
            ->live(debounce: 1000)
            ->getSearchResultsUsing(fn (string $search) => Nominatim::search($search));

        return $replaceFormData
            ? $field->afterStateUpdated(function ($get, $set, $state) {
                if ($state) {

                    $existingFieldValue = collect([
                        'street', 'zip', 'city', 'state', 'county', 'country', 'country_code', 'latitude', 'longitude',
                    ])->mapWithKeys(fn ($field) => [$field => $get($field)])->all();

                    foreach (Nominatim::lookup(osm_id: $state, existingFieldValue: $existingFieldValue) as $field => $value) {
                        $set($field, $value);
                    }
                }
            })
            : $field->afterStateUpdated(function ($state, $livewire) use ($jsonColumnName) {
                if ($state) {
                    //this worked when 'address' was a json column and not a relation
                    //$set($jsonColumnName, Nominatim::lookup(osm_id: $state, existingFieldValue: $get($jsonColumnName)));
                    //this works when 'address' is a relation or is a json column
                    data_set($livewire->data, $jsonColumnName, Nominatim::lookup(osm_id: $state, existingFieldValue: data_get($livewire->data, $jsonColumnName, [])));
                }
            });

    }
}
