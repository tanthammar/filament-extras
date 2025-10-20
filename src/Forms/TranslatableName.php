<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;
use Illuminate\Validation\Rules\Unique;

/**
 * Use Spatie translatable on your Models description field
 */
class TranslatableName
{
    public static function make(?string $column = 'name', ?string $label = 'fields.name', ?bool $unique = false, ?int $max = 125): array
    {
        $svField = TextInput::make("$column.sv")
            ->label(trans($label) . ' Svenska')
            ->ucfirst()
            ->minLength(2)
            ->maxLength($max)
            ->requiredWithout("$column.en")
            //->saveAs(fn ($get, $state) => $state ?: $get("$column.en"))
            ->rules(['alpha_dash_space_and']);

        $enField = TextInput::make("$column.en")
            ->label(trans($label) . ' English')
            ->ucfirst()
            ->minLength(2)
            ->maxLength($max)
            ->requiredWithout("$column.sv")
            //->saveAs(fn ($get, $state) => $state ?: $get("$column.sv"))
            ->rules(['alpha_dash_space_and']);

        if ($unique) {
            $svField->unique(
                column: $column . '->sv',
                ignoreRecord: true,
                modifyRuleUsing: function (Unique $rule) {
                    return $rule->withoutTrashed();
                });
            $enField->unique(
                column: $column . '->en',
                ignoreRecord: true,
                modifyRuleUsing: function (Unique $rule) {
                    return $rule->withoutTrashed();
                });
        }

        return [$svField, $enField];
    }
}
