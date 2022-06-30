<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class SpatieSlug
{
    public static function input(mixed $hiddenOn, string $column = 'slug'): TextInput
    {
        return TextInput::make($column)
            ->maxLength(255)
            ->visible(user()?->isSuperAdmin())
            ->hiddenOn(livewireClass: $hiddenOn);
    }
}
