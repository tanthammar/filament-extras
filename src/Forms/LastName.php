<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class LastName
{
    public static function input(string $column = 'last_name'): TextInput
    {
        return TextInput::make($column)
            ->label(trans('fields.last-name'))
            ->ucfirst()
            ->required()
            ->minLength(2)
            ->maxLength(125)
            ->rule('alpha_space');
    }
}
