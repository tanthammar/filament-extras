<?php

namespace TantHammar\FilamentExtras\Tables;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Filament\Tables\Columns\TextColumn;

class JsonPhoneColumn
{
    public static function make(string $column, string $dotNotation): TextColumn
    {
        return TextColumn::make($column)
            ->formatStateUsing(fn($state): string =>
            ($nr = data_get($state, $dotNotation))
                ? PhoneNumber::parse($nr)->format(PhoneNumberFormat::INTERNATIONAL)
                : '');
    }
}
