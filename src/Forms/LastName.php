<?php

namespace Tanthammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class LastName
{
    public static function input(): TextInput
    {
        return TextInput::make('last_name')
            ->label(trans('fields.last-name'))
            ->required()
            ->minLength(2)
            ->maxLength(125);
    }
}