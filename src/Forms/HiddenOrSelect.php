<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;

/** @deprecated use Select->dehydratedWhenHidden() */
class HiddenOrSelect
{
    public static function make(
        bool $condition,
        string $column,
        string $label,
        string | array $rule,
        array $options,
    ): Hidden | Select {
        return $condition
                    ? Select::make($column)->label(__($label))->rules($rule)->options($options)
                    : Hidden::make($column)->rules($rule);
    }
}
