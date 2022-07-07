<?php

namespace TantHammar\FilamentExtras\Forms;

use App\DTO\Address;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\KeyValue;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use TantHammar\LaravelRules\Rules\Latitude;
use TantHammar\LaravelRules\Rules\Longitude;
use TantHammar\FilamentExtras\Forms\HiddenOrText;

class AddressSection
{

    public static function make(string $jsonColumnName, string $label = 'Address'): Section
    {
        return Section::make(__($label))
            ->schema(array_merge(
                [AddressSearch::make($jsonColumnName)],
                AddressFields::make($jsonColumnName),
            ))->columns(2)
            ->collapsible();
    }

}
