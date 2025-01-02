<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

/**
 * Use Spatie translatable on your Models description field
 */
class TranslatableName
{
    public static function make(string $column = 'name', string $label = 'fields.name'): array
    {
        return [
            TextInput::make("$column.sv")
                ->label(trans($label) . ' Svenska')
                ->ucfirst()
                ->minLength(2)
                ->maxLength(125)
                ->requiredWithout("$column.en")
                ->saveAs(fn ($get, $state) => $state ?: $get("$column.en"))
                ->rules(['bail', 'alpha_dash_space_and'])
                ->unique(column: $column . '->sv', ignoreRecord: true),
            TextInput::make("$column.en")
                ->label(trans($label) . ' English')
                ->ucfirst()
                ->minLength(2)
                ->maxLength(125)
                ->requiredWithout("$column.sv")
                ->saveAs(fn ($get, $state) => $state ?: $get("$column.sv"))
                ->rules(['bail', 'alpha_dash_space_and'])
                ->unique(column: $column . '->en', ignoreRecord: true),
        ];
    }
}
