<?php

namespace TantHammar\FilamentExtras;

use Closure;
use Filament\Forms\Components;
use Filament\PluginServiceProvider;
use Illuminate\Support\Facades\Validator;
use Spatie\LaravelPackageTools\Package;

class FilamentExtrasServiceProvider extends PluginServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('filament-extras')
            ->hasTranslations()
            ->hasViews('filament-extras');
    }


    protected function registerMacros(): void
    {
        /*
         * ->dehydrateStateUsing() sets the field's state to null when you submit the form, and then returns a hash of the password
            also, I'd add autocomplete('new-password') just in case
         */

        /**
         * ->dehydrated determines if a field is present in the form's output & validation
         */
        Components\Field::macro('saveIfSelfFilled', fn(): static => $this->dehydrated(fn($state): bool => filled($state)));
        Components\Field::macro('saveIfSelfBlank', fn(): static => $this->dehydrated(fn($state): bool => blank($state)));
        Components\Field::macro('saveIfSelfValue', fn(): static => $this->dehydrated(fn($state): bool => (bool)$state));
        Components\Field::macro('saveIfSelfNoValue', fn(): static => $this->dehydrated(fn($state): bool => !(bool)$state));

        Components\Field::macro('loadAs', fn(mixed $callback): static => $this->afterStateHydrated(fn ($component) => $component->state($callback)));
        Components\Field::macro('saveAs', fn(mixed $callback): static => $this->dehydrateStateUsing($callback));
        Components\Field::macro('updateAs', fn(mixed $callback): static => $this->afterStateUpdated(fn ($component) => $component->state($callback)));

        Components\Field::macro('onLoaded', fn(?Closure $callback): static => $this->afterStateHydrated($callback));
        Components\Field::macro('onSave', fn(?Closure $callback): static => $this->dehydrateStateUsing($callback));
        Components\Field::macro('onUpdated', fn(?Closure $callback): static => $this->afterStateUpdated($callback));

        Components\Field::macro('ignored', fn(): static => $this->dehydrated(false));

        Components\Field::macro('requiredIfBlank', fn(string $field): static => $this->required(fn(Closure $get): bool => blank($get($field))));
        Components\Field::macro('requiredIfFilled', fn(string $field): static => $this->required(fn(Closure $get): bool => filled($get($field))));
        Components\Field::macro('requiredIfChecked', fn(string $field): static => $this->required(fn(Closure $get): bool => $get($field)));
        Components\Field::macro('requiredIfUnChecked', fn(string $field): static => $this->required(fn(Closure $get): bool => !$get($field)));

        Components\Field::macro('disabledIfBlank', fn(string $field): static => $this->disabled(fn(Closure $get): bool => blank($get($field))));
        Components\Field::macro('disabledIfFilled', fn(string $field): static => $this->disabled(fn(Closure $get): bool => filled($get($field))));
        Components\Field::macro('disabledIfChecked', fn(string $field): static => $this->disabled(fn(Closure $get): bool => $get($field)));
        Components\Field::macro('disabledIfUnChecked', fn(string $field): static => $this->disabled(fn(Closure $get): bool => !$get($field)));

        Components\Field::macro('nullableIfBlank', fn(string $field): static => $this->nullable(fn(Closure $get): bool => blank($get($field))));
        Components\Field::macro('nullableIfFilled', fn(string $field): static => $this->nullable(fn(Closure $get): bool => filled($get($field))));
        Components\Field::macro('nullableIfChecked', fn(string $field): static => $this->nullable(fn(Closure $get): bool => $get($field)));
        Components\Field::macro('nullableIfUnChecked', fn(string $field): static => $this->nullable(fn(Closure $get): bool => !$get($field)));

        Components\Field::macro('hiddenIfBlank', fn(string $field): static => $this->hidden(fn(Closure $get): bool => blank($get($field))));
        Components\Field::macro('hiddenIfFilled', fn(string $field): static => $this->hidden(fn(Closure $get): bool => filled($get($field))));
        Components\Field::macro('hiddenIfChecked', fn(string $field): static => $this->hidden(fn(Closure $get): bool => $get($field)));
        Components\Field::macro('hiddenIfUnChecked', fn(string $field): static => $this->hidden(fn(Closure $get): bool => !$get($field)));

        Components\Field::macro('visibleIfBlank', fn(string $field): static => $this->visible(fn(Closure $get): bool => blank($get($field))));
        Components\Field::macro('visibleIfFilled', fn(string $field): static => $this->visible(fn(Closure $get): bool => filled($get($field))));
        Components\Field::macro('visibleIfChecked', fn(string $field): static => $this->visible(fn(Closure $get): bool => $get($field)));
        Components\Field::macro('visibleIfUnChecked', fn(string $field): static => $this->visible(fn(Closure $get): bool => !$get($field)));

        Components\TextInput::macro('lazyEntangled', fn(): static => $this->extraAlpineAttributes(['x-on:blur' => '$wire.$refresh'])); //fake entangled.lazy on TextInputs with Masks

        Components\Field::macro('ucwords', fn(): static => $this->dehydrateStateUsing(fn ($state) => ucwords($state)));
        Components\Field::macro('ucfirst', fn(): static => $this->dehydrateStateUsing(fn ($state) => ucfirst($state)));
        Components\Field::macro('smallcaps', fn(): static => $this->dehydrateStateUsing(fn ($state) => strtolower($state)));
        Components\Field::macro('uppercase', fn(): static => $this->dehydrateStateUsing(fn ($state) => strtoupper($state)));

    }
}
