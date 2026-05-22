<?php

namespace TantHammar\FilamentExtras\Forms;

use App\Rules\UniqueLowercase;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use TantHammar\FilamentExtras\Rules\EmailDomainResolvable;

class Email
{
    public static function make(string $table, ?string $column = 'email', ?bool $unique = true): TextInput
    {
        $field = TextInput::make($column)
            ->label(trans('fields.email'))
            ->email()
            ->smallcaps()
            ->required()
            ->rules(['email:strict,spoof', new EmailDomainResolvable])
            ->prefixIcon('heroicon-o-at-symbol');

        if ($unique) {
            return $field->rules(fn (?Model $record) => [
                new UniqueLowercase(
                    table: $table,
                    column: $column,
                    record: $record,
                    additionalWhere: fn ($query) => $query
                        ->whereNull('deleted_at'),
                ),
            ]);
        }

        return $field;
    }
}
