<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class Longitude
{
    public static function make(): TextInput
    {
        return TextInput::make('longitude')
            ->label(__('fields.longitude'))
            ->rules(['sometimes', new \TantHammar\LaravelRules\Rules\Longitude]);
    }

}
