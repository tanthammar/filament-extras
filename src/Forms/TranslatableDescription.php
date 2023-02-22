<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\MarkdownEditor;

/**
 * Use Spatie translatable on your Models description field
 */
class TranslatableDescription
{
    public static function make(string $column = 'description', int $colspan = 2): array
    {
        return [
            MarkdownEditor::make("$column.sv")
                ->label(__("fields.$column").' Svenska')->columnSpan($colspan)->nullable()->rules('string')
                ->requiredIfBlank("$column.en")
                ->saveAs(fn ($get, $state) => $state ?? $get("$column.en")),
            MarkdownEditor::make("$column.en")
                ->label(__("fields.$column").' English')->columnSpan($colspan)->nullable()->rules('string')
                ->requiredIfBlank("$column.sv")
                ->saveAs(fn ($get, $state) => $state ?? $get("$column.sv")),
        ];
    }
}
