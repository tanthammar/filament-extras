<?php

namespace TantHammar\FilamentExtras;

use Closure;
use Filament\Forms\Components;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Blade;
use Illuminate\Validation\Rule;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class FilamentExtrasServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('filament-extras')
            ->hasViews()
            ->hasTranslations()
            ->hasRoute('api');
    }

    public function packageBooted(): void
    {
        Blade::directive('FilamentAlpineComponent', static function (...$expression) {
            return "<?php echo \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc($expression[0]); ?>";
        });
    }

    public function packageRegistered(): void
    {
        /** commands
         * first compile the js and css, then publish the assets with Filament uppgrade cmd
         * npm run prod:js
         * php artisan filament:upgrade
         */
        $this->registerMacros();

        if ($this->app->runningInConsole()) {

            \Filament\Support\Facades\FilamentAsset::register([
                Css::make('filament-phone-input', __DIR__ . '/../dist/filament-phone/filament-phone.css'),
                Js::make('filament-phone-input', __DIR__ . '/../dist/filament-phone/filament-phone.js'),
            ], 'tanthammar/filament-extras');

        }

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
        Components\Field::macro('saveIfSelfFilled', fn (): static => $this->dehydrated(fn ($state): bool => filled($state)));
        Components\Field::macro('saveIfSelfBlank', fn (): static => $this->dehydrated(fn ($state): bool => blank($state)));
        Components\Field::macro('saveIfSelfValue', fn (): static => $this->dehydrated(fn ($state): bool => (bool) $state));
        Components\Field::macro('saveIfSelfNoValue', fn (): static => $this->dehydrated(fn ($state): bool => ! (bool) $state));

        Components\Field::macro('loadAs', fn (mixed $callback): static => $this->afterStateHydrated(fn ($component) => $component->state($callback)));
        Components\Field::macro('saveAs', fn (mixed $callback): static => $this->dehydrateStateUsing($callback));
        Components\Field::macro('updateAs', fn (mixed $callback): static => $this->afterStateUpdated(fn ($component) => $component->state($callback)));

        Components\Field::macro('onLoaded', fn (?Closure $callback): static => $this->afterStateHydrated($callback));
        Components\Field::macro('onSave', fn (?Closure $callback): static => $this->dehydrateStateUsing($callback));
        Components\Field::macro('onUpdated', fn (?Closure $callback): static => $this->afterStateUpdated($callback));

        Components\Field::macro('ignored', fn (): static => $this->dehydrated(false));

        Components\Field::macro('requiredIfBlank', fn (string $field): static => $this->required(fn (\Filament\Forms\Get $get): bool => blank($get($field))));
        Components\Field::macro('requiredIfFilled', fn (string $field): static => $this->required(fn (\Filament\Forms\Get $get): bool => filled($get($field))));
        Components\Field::macro('requiredIfChecked', fn (string $field): static => $this->required(fn (\Filament\Forms\Get $get): bool => $get($field)));
        Components\Field::macro('requiredIfUnChecked', fn (string $field): static => $this->required(fn (\Filament\Forms\Get $get): bool => ! $get($field)));

        Components\Field::macro('disabledIfBlank', fn (string $field): static => $this->disabled(fn (\Filament\Forms\Get $get): bool => blank($get($field))));
        Components\Field::macro('disabledIfFilled', fn (string $field): static => $this->disabled(fn (\Filament\Forms\Get $get): bool => filled($get($field))));
        Components\Field::macro('disabledIfChecked', fn (string $field): static => $this->disabled(fn (\Filament\Forms\Get $get): bool => $get($field)));
        Components\Field::macro('disabledIfUnChecked', fn (string $field): static => $this->disabled(fn (\Filament\Forms\Get $get): bool => ! $get($field)));

        Components\Field::macro('nullableIfBlank', fn (string $field): static => $this->nullable(fn (\Filament\Forms\Get $get): bool => blank($get($field))));
        Components\Field::macro('nullableIfFilled', fn (string $field): static => $this->nullable(fn (\Filament\Forms\Get $get): bool => filled($get($field))));
        Components\Field::macro('nullableIfChecked', fn (string $field): static => $this->nullable(fn (\Filament\Forms\Get $get): bool => $get($field)));
        Components\Field::macro('nullableIfUnChecked', fn (string $field): static => $this->nullable(fn (\Filament\Forms\Get $get): bool => ! $get($field)));

        Components\Field::macro('hiddenIfBlank', fn (string $field): static => $this->hidden(fn (\Filament\Forms\Get $get): bool => blank($get($field))));
        Components\Field::macro('hiddenIfFilled', fn (string $field): static => $this->hidden(fn (\Filament\Forms\Get $get): bool => filled($get($field))));
        Components\Field::macro('hiddenIfChecked', fn (string $field): static => $this->hidden(fn (\Filament\Forms\Get $get): bool => $get($field)));
        Components\Field::macro('hiddenIfUnChecked', fn (string $field): static => $this->hidden(fn (\Filament\Forms\Get $get): bool => ! $get($field)));

        Components\Field::macro('visibleIfBlank', fn (string $field): static => $this->visible(fn (\Filament\Forms\Get $get): bool => blank($get($field))));
        Components\Field::macro('visibleIfFilled', fn (string $field): static => $this->visible(fn (\Filament\Forms\Get $get): bool => filled($get($field))));
        Components\Field::macro('visibleIfChecked', fn (string $field): static => $this->visible(fn (\Filament\Forms\Get $get): bool => $get($field)));
        Components\Field::macro('visibleIfUnChecked', fn (string $field): static => $this->visible(fn (\Filament\Forms\Get $get): bool => ! $get($field)));

        Components\Field::macro('ucwords', fn (): static => $this->dehydrateStateUsing(fn ($state) => mb_convert_case($state, MB_CASE_TITLE, 'UTF-8')));
        Components\Field::macro('ucfirst', fn (): static => $this->dehydrateStateUsing(fn ($state) => mb_convert_case(mb_substr($state, 0, 1), MB_CASE_TITLE) . mb_substr($state, 1)));
        Components\Field::macro('smallcaps', fn (): static => $this->dehydrateStateUsing(fn ($state) => mb_strtolower($state)));
        Components\Field::macro('uppercase', fn (): static => $this->dehydrateStateUsing(fn ($state) => mb_strtoupper($state)));

        Components\Field::macro('ruleEach', fn (array | string $rules, bool | Closure $condition = true): static => $this->nestedRecursiveRules($rules, $condition));

        Components\Field::macro('isReactive', fn (bool $live): static => $live ? $this->live() : $this);

        Components\TagsInput::macro('ruleEachInOptions', fn (): static => $this->nestedRecursiveRules(['bail', fn ($component): \Illuminate\Validation\Rules\In => Rule::in(array_keys($component->getOptions()))]));
        Components\CheckboxList::macro('ruleEachInOptions', fn (): static => $this->nestedRecursiveRules(['bail', fn ($component): \Illuminate\Validation\Rules\In => Rule::in(array_keys($component->getOptions()))]));

        /** For Select->multiple() */
        Components\Select::macro('ruleEachInOptions', fn (): static => $this->nestedRecursiveRules(['bail', fn ($component): \Illuminate\Validation\Rules\In => Rule::in(array_keys($component->getOptions()))]));

        /** for single Select */
        Components\Select::macro('ruleInOptions', fn (): static => $this->rule(fn ($component): \Illuminate\Validation\Rules\In => Rule::in(array_keys($component->getOptions()))));

        /**
         * @deprecated accepted to core
         */
        //Components\TextInput::macro('lazyEntangled', fn (): static => $this->extraAlpineAttributes(['x-on:blur' => '$wire.$refresh'])); //fake entangled.lazy on TextInputs with Masks

        /** Table features removed from Filament v3 */
        Table::macro('prependActions', function (array $actions): static {
            $existing = $this->actions;
            $this->actions = [];
            $this->actions($actions);
            $this->actions = array_merge($this->actions, $existing);

            return $this;
        });

        Table::macro('appendActions', function (array $actions): static {
            $existing = $this->actions;
            $this->actions = [];
            $this->actions($actions);
            $this->actions = array_merge($existing, $this->actions);

            return $this;
        });

        Table::macro('prependBulkActions', function (array $actions): static {
            $existing = $this->groupedBulkActions;
            $this->groupedBulkActions = [];
            $this->bulkActions($actions);
            $this->groupedBulkActions = array_merge($this->groupedBulkActions, $existing);

            return $this;
        });

        Table::macro('appendBulkActions', function (array $actions): static {
            $existing = $this->groupedBulkActions;
            $this->groupedBulkActions = [];
            $this->bulkActions($actions);
            $this->groupedBulkActions = array_merge($existing, $this->groupedBulkActions);

            return $this;
        });

        Table::macro('prependHeaderActions', function (array $actions): static {
            $existing = $this->headerActions;
            $this->headerActions = [];
            $this->headerActions($actions);
            $this->headerActions = array_merge($this->headerActions, $existing);

            return $this;
        });

        Table::macro('appendHeaderActions', function (array $actions): static {
            $existing = $this->headerActions;
            $this->headerActions = [];
            $this->headerActions($actions);
            $this->headerActions = array_merge($existing, $this->headerActions);

            return $this;
        });
    }
}
