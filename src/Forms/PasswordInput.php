<?php

namespace Tanthammar\FilamentExtras\Forms;

use Filament\Forms\Components\TextInput;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class PasswordInput
{
    public static function create(string $prop = 'new_password'): TextInput
    {
        return TextInput::make($prop)
            ->label(trans('fields.new-password'))
            ->required()
            ->minLength(8)
            ->maxLength(20)
            ->rules(['string', PasswordRule::min(8)->mixedCase()->numbers(), 'max:20'])
            ->saveAs(fn($state) => Hash::make($state))
            ->autocomplete('new-password');
    }

    public static function confirmation(string $prop = 'new_password_confirmation', string $same = 'new_password'): TextInput
    {
        return TextInput::make($prop)
            ->label(trans('fields.password-confirmation'))
            ->password()
            ->ignored()
            ->minLength(8)
            ->maxLength(20)
            ->rules("required_with:$same|string|same:$same")
            ->autocomplete('new-password');
    }

    public static function current(string $prop = 'current_password', bool|string $with = 'new_password'): TextInput
    {
        return TextInput::make($prop)
            ->label(trans('fields.current-password'))
            ->password()
            ->rules($with ? ["required_with:$with", 'current_password'] : ['current_password'])
            ->autocomplete('off')
            ->columnSpan(1);
    }

}
