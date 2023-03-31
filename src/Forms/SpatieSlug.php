<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

/*
 * Your model should use Spatie slug package. <br>
 * The $hiddenOn property would typically be your Filament Resource create page, <br>
 * as the slug is automatically generated when the Model is created
 */
class SpatieSlug
{
    public static function make(mixed $hiddenOn, string $column = 'slug'): TextInput
    {
        return TextInput::make($column)
            ->maxLength(255)
            ->visible(user()?->isSuperAdmin())
            ->hiddenOn(operations: $hiddenOn);
    }
}
