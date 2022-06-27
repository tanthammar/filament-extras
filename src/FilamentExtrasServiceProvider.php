<?php

namespace Tanthammar\FilamentExtras;

use Closure;
use Filament\Forms\Components;
use Filament\PluginServiceProvider;
use Hash;

class FilamentExtrasServiceProvider extends PluginServiceProvider
{
    public static string $name = 'filament-extras';

    protected function registerMacros(): void
    {
        /*
         * ->dehydrateStateUsing() sets the field's state to null when you submit the form, and then returns a hash of the password
            also, I'd add autocomplete('new-password') just in case
         */

        /**
         * ->dehydrated determines if a field is present in the form's output & validation
         */
        Components\Field::macro('saveIfFilled', fn(): static => $this->dehydrated(fn($state): bool => filled($state)));
        Components\Field::macro('saveIfBlank', fn(): static => $this->dehydrated(fn($state): bool => blank($state)));
        Components\Field::macro('saveIfValue', fn(): static => $this->dehydrated(fn($state): bool => (bool)$state));
        Components\Field::macro('saveIfNoValue', fn(): static => $this->dehydrated(fn($state): bool => !(bool)$state));
        Components\Field::macro('saveAs', fn(?Closure $callback): static => $this->dehydrateStateUsing($callback));

        Components\Field::macro('ignored', fn(): static => $this->dehydrated(false));

        Components\Field::macro('requiredIfBlank', fn(string $field): static =>
             $this->required(fn(\Closure $get): bool => blank($get($field)))
        );
        Components\Field::macro('requiredIfFilled', fn(string $field): static =>
            $this->required(fn(\Closure $get): bool => filled($get($field)))
        );

        Components\Field::macro('nullableIfBlank', fn(string $field): static =>
            $this->nullable(fn(\Closure $get): bool => blank($get($field)))
        );
        Components\Field::macro('nullableIfFilled', fn(string $field): static =>
            $this->nullable(fn(\Closure $get): bool => filled($get($field)))
        );

        Components\Field::macro('hiddenIfBlank', fn(string $field): static =>
            $this->hidden(fn(\Closure $get): bool => blank($get($field)))
        );
        Components\Field::macro('hiddenIfFilled', fn(string $field): static =>
            $this->hidden(fn(\Closure $get): bool => filled($get($field)))
        );


        Components\TextInput::macro('lazyEntangled', fn(): static => $this->extraAlpineAttributes(['x-on:blur' => '$wire.$refresh'])); //fake entangled.lazy on TextInputs with Masks
    }
}
