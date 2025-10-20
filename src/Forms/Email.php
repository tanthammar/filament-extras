<?php

namespace TantHammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rules\Unique;

class Email
{
    public static function make(?string $column = 'email', ?bool $unique = true): TextInput
    {
        $field = TextInput::make($column)
            ->label(trans('fields.email'))
            ->email()
            ->smallcaps()
            ->required()
            ->rules(['email:strict,dns,spoof'])
            ->prefixIcon('heroicon-o-at-symbol');

        if ($unique) {
            return $field->unique(
                ignoreRecord: true,
                modifyRuleUsing: function (Unique $rule) {
                    return $rule->withoutTrashed();
                });
        }

        return $field;
    }
}
