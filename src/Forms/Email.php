<?php

namespace Tanthammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;

class Email
{
    public static function input(): TextInput
    {
        return TextInput::make('email')
            ->label(trans('fields.email'))
            ->email()
            ->required()
            ->unique(ignorable: fn (?Model $record): ?Model => $record)
            ->rules(['email:strict,dns,spoof']);
    }
}
