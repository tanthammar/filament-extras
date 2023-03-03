<?php

namespace TantHammar\FilamentExtras\Tables;

use Brick\PhoneNumber\PhoneNumber;
use Brick\PhoneNumber\PhoneNumberFormat;
use Brick\PhoneNumber\PhoneNumberParseException;
use Filament\Tables\Columns\TextColumn;

/** requires E164 formatted phone number */
class PhoneParseE164Column
{
    public static function make(string $column, PhoneNumberFormat|int $format = PhoneNumberFormat::INTERNATIONAL): TextColumn
    {
        return TextColumn::make($column)->formatStateUsing(
            function ($state) use ($format): string {
                try {
                    return PhoneNumber::parse($state);
                } catch (PhoneNumberParseException $e) {
                    return $state;
                }
            });
    }
}
