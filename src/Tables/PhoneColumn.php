<?php

namespace TantHammar\FilamentExtras\Tables;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Filament\Tables\Columns\TextColumn;

class PhoneColumn
{
    /** Phone number must start with country code with or without '+' */
    public static function make(string $column): TextColumn
    {
        return TextColumn::make($column)->formatStateUsing(fn($state): string => PhoneNumber::parse(str_starts_with($state, '+') ? $state : '+'.$state)->format(PhoneNumberFormat::INTERNATIONAL) ?? '');
    }
}
