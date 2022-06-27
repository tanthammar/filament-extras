<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class LastName
{
    public static function input(string $column = 'last_name'): TextInput
    {
        return TextInput::make('last_name')
            ->label(trans('fields.last-name'))
            ->required()
            ->minLength(2)
            ->maxLength(125)
            ->rule('alpa_dash');
    }
}
