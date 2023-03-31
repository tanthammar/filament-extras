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
    <x-filament::input.affixes
        :state-path="$statePath"
        :prefix="$prefixLabel"
        :prefix-actions="$getPrefixActions()"
        :prefix-icon="$prefixIcon"
        :suffix="$suffixLabel"
        :suffix-actions="$getSuffixActions()"
        :suffix-icon="$suffixIcon"
        class="filament-forms-text-input-component"
        :attributes="$getExtraAttributeBag()"
    >
        <div @class([
            'flex-1 filament-phone-input-field',
            'rtl' => $isRtl(),
            ]) wire:ignore>
                <input
                    x-ignore
                    ax-load
                    ax-load-src="@FilamentAlpineComponent('filament-phone-input', 'tanthammar/filament-extras')"
                    x-data="phoneInputFormComponent({
                        options: @js($getJsonPhoneInputConfiguration()),
                        state: $wire.{{ $applyStateBindingModifiers('entangle(\'' . $statePath . '\')', lazilyEntangledModifiers: ['defer']) }},
                    })"
                    wire:ignore
                    x-bind:class="{
                        'border-gray-300 dark:border-gray-600': ! (@js($statePath) in $wire.__instance.serverMemo.errors),
                        'border-danger-600 ring-danger-600': (@js($statePath) in $wire.__instance.serverMemo.errors),
                    }"
                    {{
                        $getExtraInputAttributeBag()
                            ->merge([
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
                                'x-on:input.debounce.'.$getDebounce() => $isDebounced() ? '$wire.$refresh' : null,
                            ], escape: false)
                            ->class([
                                'block w-full transition duration-75 shadow-sm outline-none sm:text-sm focus:border-primary-500 focus:relative focus:z-[1] focus:ring-1 focus:ring-inset focus:ring-primary-500 disabled:opacity-70 dark:bg-gray-700 dark:text-white dark:focus:border-primary-500',
                                'rounded-l-lg' => ! ($prefixLabel || $prefixIcon),
                                'rounded-r-lg' => ! ($suffixLabel || $suffixIcon),
                            ])
                    }}
                />
        </div>
    </x-filament::input.affixes>
</x-dynamic-component>
