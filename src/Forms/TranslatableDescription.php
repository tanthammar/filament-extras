<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\MarkdownEditor;
use Illuminate\Support\Str;

/**
 * Use Spatie translatable on your Models description field
 */
class TranslatableDescription
{
    public static function make(string $column = 'description', int $colspan = 2): array
    {
        $support = user()?->isSupport();
        return [
            MarkdownEditor::make("$column.sv")
                ->label(__("fields.$column").' Svenska')->columnSpan($colspan)->nullable()
                ->requiredIfBlank("$column.en")
                ->saveAs(fn ($get, $state) => $support
                    ? ($state ?: $get("$column.en"))
                    : strip_tags($state ?? $get("$column.en")))
                ->disableToolbarButtons($support ? [] : [
                    'codeBlock',
                ]),
            MarkdownEditor::make("$column.en")
                ->label(__("fields.$column").' English')->columnSpan($colspan)->nullable()
                ->requiredIfBlank("$column.sv")
                ->saveAs(fn ($get, $state) => $support
                    ? ($state ?: $get("$column.sv"))
                    : strip_tags($state ?? $get("$column.sv")))
                ->disableToolbarButtons($support ? [] : [
                    'codeBlock',
                ]),
        ];
    }
}
