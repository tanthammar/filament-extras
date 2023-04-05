<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

/**
 * Use Spatie translatable on your Models description field
 */
class TranslatableName
{
    public static function make(string $column = 'name', string $label = 'fields.name', array $rules= ['alpha_dash_space']): array
    {
        return [
            TextInput::make("$column.sv")
                ->label(trans($label) .' Svenska')
                ->ucfirst()
                ->minLength(2)
                ->maxLength(125)
                ->requiredIfBlank("$column.en")
                ->saveAs(fn ($get, $state) => $state ?: $get("$column.en"))
                ->rules($rules),
            TextInput::make("$column.en")
                ->label(trans($label).' English')
                ->ucfirst()
                ->minLength(2)
                ->maxLength(125)
                ->requiredIfBlank("$column.sv")
                ->saveAs(fn ($get, $state) => $state ?: $get("$column.sv"))
                ->rules($rules),
        ];
    }
}
