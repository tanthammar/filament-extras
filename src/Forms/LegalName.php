<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class LegalName
{
    public static function make(string $column = 'legal_name'): TextInput
    {
        return TextInput::make($column)
            ->label(__('fields.legal_name'))
            ->nullable()
            ->rules('bail|sometimes|alpha_dash_space_and')
            ->nullable()
            ->helperText(__('fields.legal-name-hint'));
    }

}