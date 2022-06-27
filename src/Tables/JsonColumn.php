<?php

namespace TantHammar\FilamentExtras\Tables;

use Filament\Tables\Columns\TextColumn;

class JsonColumn
{
    public static function make(string $column, string $dotNotation): TextColumn
    {
        return TextColumn::make($column)->formatStateUsing( fn ($state): string => data_get($state, $dotNotation, ''));
    }
}
