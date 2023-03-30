<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

/**
 * I use a HasUuid trait that generates a custom UUID when my model is created <br>
 * This means that the $hiddenOn property would typically be your Filament Resource create page, <br>
 * as the UUID is automatically generated when the Model created
 */
class Uuid
{
    public static function make(string|array $visibleOn = 'view', string $column = 'uuid'): TextInput
    {
        return TextInput::make($column)
            ->maxLength(36)
            ->disabled()
            ->ignored()
            ->visibleOn(contexts: $visibleOn)//order matters, must be before visible()
            ->visible(user()?->isSuperAdmin());
    }
}
