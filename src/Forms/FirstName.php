<?php

namespace Tanthammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class FirstName
{
    public static function input(): TextInput
    {
        return TextInput::make('first_name')
            ->label(trans('fields.first-name'))
            ->required()
            ->minLength(2)
            ->maxLength(125);
    }
}
