<?php

namespace Tanthammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class FirstName
{
    public static function input(string $column = 'first_name'): TextInput
    {
        return TextInput::make($column)
            ->label(trans('fields.first-name'))
            ->required()
            ->minLength(2)
            ->maxLength(125)
            ->rule('alpa_dash');
    }
}
