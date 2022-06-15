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
        Components\Field::macro('ifFilled', fn(): static => $this->dehydrated(fn($state): bool => filled($state)));
        Components\Field::macro('ifBlank', fn(): static => $this->dehydrated(fn($state): bool => blank($state)));
        Components\Field::macro('ifValue', fn(): static => $this->dehydrated(fn($state): bool => (bool)$state));
        Components\Field::macro('ifNoValue', fn(): static => $this->dehydrated(fn($state): bool => !(bool)$state));
        Components\Field::macro('ignored', fn(): static => $this->dehydrated(false));
        Components\Field::macro('saveAs', fn(?Closure $callback): static => $this->dehydrateStateUsing($callback));
    }
}
