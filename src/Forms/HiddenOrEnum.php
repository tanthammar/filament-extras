<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;

class HiddenOrEnum
{

    public static function make(
        bool $condition,
        string $column,
        string $label,
        string|array $rule,
        array $enumValues,
    ): Hidden|Select
    {
        return $condition
                    ? Select::make($column)->label(__($label))->rules($rule)->options($enumValues)
                    : Hidden::make($column)->rules($rule);
    }

}
