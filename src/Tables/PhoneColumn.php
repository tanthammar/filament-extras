<?php

namespace TantHammar\FilamentExtras\Tables;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Filament\Tables\Columns\TextColumn;

class PhoneColumn
{
    public static function make(string $column): TextColumn
    {
        return TextColumn::make($column)->formatStateUsing(fn($state): string => PhoneNumber::parse('+'.$state)->format(PhoneNumberFormat::INTERNATIONAL) ?? '');
    }
}
