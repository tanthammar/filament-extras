<?php

namespace TantHammar\FilamentExtras\Forms;

use Closure;
use Filament\Forms\Components\MarkdownEditor;

/**
 * Use Spatie translatable on your Models description field
 */
class TranslatableDescription
{
    public static function input(
        string $column,
        string $autoFillFrom,
        string $label): MarkdownEditor
    {
        return MarkdownEditor::make($column)
            ->label(__($label))->columnSpan(2)->nullable()->rules('string')
            ->requiredIfBlank($autoFillFrom)
            ->nullableIfFilled($autoFillFrom)
            ->dehydrateStateUsing(fn(Closure $get, $state) => $state ?? $get($autoFillFrom));
    }
}
