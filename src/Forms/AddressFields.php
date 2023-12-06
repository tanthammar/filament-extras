<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Rules\CountryCodeRule;
use App\Rules\CountryRule;
use Filament\Forms\Components\TextInput;
use TantHammar\LaravelRules\Rules\Latitude;
use TantHammar\LaravelRules\Rules\Longitude;

class AddressFields
{
    public static function make(string $jsonColumnName = null): array
    {
        $jsonColumnName = $jsonColumnName && ! str_ends_with($jsonColumnName, '.') ? "$jsonColumnName." : $jsonColumnName;

        return [
            TextInput::make($jsonColumnName . 'label')->label(__('fields.adr_dept'))
                ->default(__('field-labels.postal'))
                ->hint(__('fields.adr_dept_hint'))
                ->visible()->required()->rules('alpha_space'),
            TextInput::make($jsonColumnName . 'box')->label(__('fields.box'))->nullable()->rules('alpha_dash_space'),
            TextInput::make($jsonColumnName . 'street')->label(__('fields.street'))->required()->rules('alpha_dash_space'),
            TextInput::make($jsonColumnName . 'address_line_2')->label(__('fields.address_line_2'))->nullable()->rules('alpha_dash_space'),
            TextInput::make($jsonColumnName . 'zip')->label(__('fields.zip'))->required()->rules('alpha_dash_space'),
            TextInput::make($jsonColumnName . 'city')->label(__('fields.city'))->required(),
            TextInput::make($jsonColumnName . 'county')->label(__('fields.county'))->requiredIfBlank($jsonColumnName . 'state'),
            TextInput::make($jsonColumnName . 'state')->label(__('fields.state'))->requiredIfBlank($jsonColumnName . 'county'),
            TextInput::make($jsonColumnName . 'country')->label(__('fields.country'))->required()->rules([new CountryRule]),
            HiddenOrText::make(
                condition: user()->isSuperadmin(),
                column: $jsonColumnName . 'country_code',
                label: 'fields.cc',
                rule: ['bail', 'sometimes', 'min:2', 'max:3', new CountryCodeRule]
            )
                ->nullable(),
            HiddenOrText::make(
                condition: user()->isSuperadmin(),
                column: $jsonColumnName . 'latitude',
                label: 'fields.latitude',
                rule: ['sometimes', new Latitude]
            )
                ->nullable(),
            HiddenOrText::make(
                condition: user()->isSuperadmin(),
                column: $jsonColumnName . 'longitude',
                label: 'fields.longitude',
                rule: ['sometimes', new Longitude]
            )
                ->nullable(),
        ];
    }
}
