@php
    $id = $getId();
    $isConcealed = $isConcealed();
    $statePath = $getStatePath();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <x-filament::input.wrapper
        :prefix="$prefixLabel"
        :prefix-actions="$getPrefixActions()"
        :prefix-icon="$prefixIcon"
        :suffix="$suffixLabel"
        :suffix-actions="$getSuffixActions()"
        :suffix-icon="$suffixIcon"
        :valid="! $errors->has($statePath)"
        class="fi-fo-text-input"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class(['overflow-hidden'])
        "
    >
        <div @class([
            'flex-1 filament-phone-input-field',
            'rtl' => $isRtl(),
            ])
             x-cloak
             wire:ignore
             x-load
             x-load-css="[@js(\Filament\Support\Facades\FilamentAsset::getStyleHref('filament-phone-input', package: 'tanthammar/filament-extras'))]"
             x-load-src="{{ \Filament\Support\Facades\FilamentAsset::getAlpineComponentSrc('filament-phone-input', 'tanthammar/filament-extras') }}"
             x-data="phoneInputFormComponent({
                        options: @js($getJsonPhoneInputConfiguration()),
                        state: $wire.{{ $applyStateBindingModifiers("\$entangle('{$statePath}')") }},
                        inputEl: $refs.phoneInput,
                    })"
             x-intersect.once="initWhenVisible()"
        >
                <input {{ $getExtraInputAttributeBag()
                            ->merge([
                                'x-ref' => 'phoneInput',
                                'autocomplete' => $getAutocomplete(),
                                'autofocus' => $isAutofocused(),
                                'disabled' => $isDisabled(),
                                'dusk' => "filament.forms.{$statePath}",
                                'id' => $id,
                                'placeholder' => $getPlaceholder(),
                                'readonly' => $isReadOnly(),
                                'required' => $isRequired() && (! $isConcealed),
                                'type' =>   'tel',
                                'x-on:blur' => $isLazy() ? '$wire.$refresh' : null,
                                'x-on:input.debounce.'.$getLiveDebounce() => $isLiveDebounced() ? '$wire.$refresh' : null,
                                'x-on:change' => 'updateState()',
                                'x-on:countrychange' => 'countryChange()',
                                'x-on:focus' => 'focusInput()',
                            ], escape: false)
                            ->class([
                                'block w-full outline-none border-0 sm:text-sm appearance-none focus:relative focus:z-[1] focus:ring-0 disabled:opacity-70 dark:bg-gray-700 dark:text-white',
                                'rounded-l-lg' => ! ($prefixLabel || $prefixIcon),
                                'rounded-r-lg' => ! ($suffixLabel || $suffixIcon),
                            ])
                    }}
                >
        </div>
    </x-filament::input.wrapper>
</x-dynamic-component>
