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
                ->label(__("fields.$column") . __('locales.sv'))->columnSpan($colspan)->nullable()
                ->requiredWithout("$column.en")
                ->saveAs(fn ($get, $state) => strip_tags($state ?: $get("$column.en")))
                ->disableToolbarButtons($support ? [] : [
                    'codeBlock',
                    'attachFiles',
                ]),
            MarkdownEditor::make("$column.en")
                ->label(__("fields.$column") . __('locales.en'))->columnSpan($colspan)->nullable()
                ->requiredWithout("$column.sv")
                ->saveAs(fn ($get, $state) => strip_tags($state ?: $get("$column.sv"))) //or if we want to allow html str($state ?: $get("$column.sv"))->sanitizeHtml() //Filament helper, removes malicious html
                ->disableToolbarButtons($support ? [] : [
                    'codeBlock',
                    'attachFiles',
                ]),
        ];
    }
}
