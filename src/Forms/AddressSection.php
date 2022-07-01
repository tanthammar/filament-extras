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
            ->schema([
                AddressSearch::make($jsonColumnName),
                TextInput::make("$jsonColumnName.label")->label(__('fields.adr_dept'))->default(__('field-labels.hq'))->required()->rules('alpha_space'),
                TextInput::make("$jsonColumnName.box")->label(__('fields.box'))->nullable()->rules('alpha_dash'),
                TextInput::make("$jsonColumnName.street")->label(__('fields.street'))->required()->rules('alpha_dash_space'),
                TextInput::make("$jsonColumnName.address_line_2")->label(__('fields.address_line_2'))->nullable()->rules('alpha_dash_space'),
                TextInput::make("$jsonColumnName.zip")->label(__('fields.zip'))->required()->rules('alpha_dash_space'),
                TextInput::make("$jsonColumnName.city")->label(__('fields.city'))->required(),
                TextInput::make("$jsonColumnName.county")->label(__('fields.county'))->requiredIfBlank("$jsonColumnName.state"),
                TextInput::make("$jsonColumnName.state")->label(__('fields.state'))->requiredIfBlank("$jsonColumnName.county"),
                TextInput::make("$jsonColumnName.country")->label(__('fields.country'))->required(),
                HiddenOrText::make(
                    condition: user()->isSuperadmin(),
                    column: "$jsonColumnName.country_code",
                    label: 'fields.cc',
                    rule: 'sometimes|min:2|max:3')
                    ->nullable(),
                HiddenOrText::make(
                    condition: user()->isSuperadmin(),
                    column: "$jsonColumnName.latitude",
                    label: 'fields.latitude',
                    rule: ['sometimes', new Latitude])
                    ->nullable(),
                HiddenOrText::make(
                    condition: user()->isSuperadmin(),
                    column: "$jsonColumnName.longitude",
                    label: 'fields.longitude',
                    rule: ['sometimes', new Longitude])
                    ->nullable(),
            ])->columns(2)
            ->collapsible();
    }

}
