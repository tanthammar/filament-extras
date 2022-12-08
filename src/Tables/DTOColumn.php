<?php

namespace TantHammar\FilamentExtras\Tables;

use Filament\Tables\Columns\TextColumn;

class DTOColumn
{
    public static function make(string $column, string $attribute): TextColumn
    {
        return TextColumn::make($column)->formatStateUsing(fn ($state): string => $state?->$attribute ?? '');
    }
}
