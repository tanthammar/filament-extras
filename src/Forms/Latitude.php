<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class Latitude
{
    public static function make(): TextInput
    {
        return TextInput::make('latitude')
            ->label(__('fields.latitude'))
            ->rules(['sometimes', new \TantHammar\LaravelRules\Rules\Latitude]);
    }
}
