<?php

namespace TantHammar\FilamentExtras\Tables;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Filament\Tables\Columns\TextColumn;

/** requires E164 formatted phone number */
class PhoneParseE164Column
{
    public static function make(string $column, PhoneNumberFormat|int $format = PhoneNumberFormat::INTERNATIONAL): TextColumn
    {
        return TextColumn::make($column)->formatStateUsing(fn ($state): string => PhoneNumber::parse($state)->format($format));
    }
}
