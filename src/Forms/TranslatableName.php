<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Rules\UniqueLowercase;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;

/**
 * Use Spatie translatable on your Models description field
 */
class TranslatableName
{
    public static function make(?string $column = 'name', ?string $label = 'fields.name', ?bool $unique = false, ?int $max = 125, ?string $table=null): array
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

        if ($unique && $table) {
            $svField->rules(fn (?Model $record) => [
                new UniqueLowercase(
                    table: $table,
                    column: $column . "->>'sv'",
                    record: $record,
                    additionalWhere: fn ($query) => $query
                        ->whereNull('deleted_at'),
                ),
            ]);
            $enField->rules(fn (?Model $record) => [
                new UniqueLowercase(
                    table: $table,
                    column: $column . "->>'en'",
                    record: $record,
                    additionalWhere: fn ($query) => $query
                        ->whereNull('deleted_at'),
                ),
            ]);
        }

        return [$svField, $enField];
    }
}
