<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;

class Uuid
{
    public static function input(mixed $hiddenOn, string $column = 'uuid'): TextInput
    {
        return TextInput::make($column)
            ->maxLength(36)
            ->visible(user()?->isSuperAdmin())
            ->hiddenOn(livewireClass: $hiddenOn);

    }
}
