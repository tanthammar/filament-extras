<?php

namespace TantHammar\FilamentExtras\Tables;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Filament\Tables\Columns\TextColumn;

class DTOPhoneColumn
{
    public static function make(string $column, string $attribute): TextColumn
    {
        return TextColumn::make($column)
            ->formatStateUsing(fn ($state): string => ($nr = data_get($state, $attribute))
                ? PhoneNumber::parse('+' . $nr)->format(PhoneNumberFormat::INTERNATIONAL)
                : '');
    }
}
