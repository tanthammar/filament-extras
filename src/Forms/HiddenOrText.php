<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;

class HiddenOrText
{
    public static function make(bool $condition, string $column, string $label, string|array $rule): Hidden|TextInput
    {
        return $condition
                    ? TextInput::make($column)->label(__($label))->rules($rule)
                    : Hidden::make($column)->rules($rule);
    }
}
