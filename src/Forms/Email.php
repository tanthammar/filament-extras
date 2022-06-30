<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class Email
{
    public static function input(string $column = 'email', bool $unique = true): TextInput
    {
        $field = TextInput::make($column)
            ->label(trans('fields.email'))
            ->email()
            ->smallcaps()
            ->required()
            ->rules(['email:strict,dns,spoof'])
            ->prefixIcon('heroicon-o-at-symbol');

        if($unique) {
            return $field->unique(ignorable: fn (?Model $record): ?Model => $record);
        }

        return $field;
    }
}
