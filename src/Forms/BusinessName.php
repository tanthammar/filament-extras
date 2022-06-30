<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class BusinessName
{
    public static function input(string $column = 'name'): TextInput
    {
        return TextInput::make($column)
            ->label(trans('fields.name'))
            ->ucfirst()
            ->required()
            ->minLength(2)
            ->maxLength(125)
            ->rule('alpha_dash_spaces');
    }
}
