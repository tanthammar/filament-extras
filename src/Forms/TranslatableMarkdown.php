<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\MarkdownEditor;

/**
 * Use Spatie translatable on your Models description field
 */
class TranslatableMarkdown
{
    public static function make(
        string $column,
        string $autoFillFrom,
        string $label): MarkdownEditor
    {
        return MarkdownEditor::make($column)
            ->label(__($label))->columnSpan(2)->nullable()->rules('string')
            ->requiredIfBlank($autoFillFrom)
            ->saveAs(fn ($get, $state) => $state ?? $get($autoFillFrom));
    }
}
