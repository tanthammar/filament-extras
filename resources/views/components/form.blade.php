@props([
    'submit' => 'submit',
    'label' => null,
    'description' => null,
    'button' => trans('filament::resources/pages/edit-record.form.actions.save.label')
])
<form wire:submit.prevent="{{$submit}}"
      class="p-6 space-y-6 rounded shadow-sm border border-gray-300 filament-forms-section-component" {{ $attributes }}>
    @if($label || $description)
        <div class="flex flex-col space-y-1">
            @if($label)
                <h3 class="text-xl font-bold tracking-tight">
                    {{ $label }}
                </h3>
            @endif
            @if($description)
                <p class="text-gray-500">
                    {{ $description }}
                </p>
            @endif
        </div>
    @endif
    {{ $slot }}
    <div class="flex flex-wrap items-center gap-4 justify-end">
        {{ $buttons ?? null }}
        <x-filament::button type="submit">
            {{ $button }}
        </x-filament::button>
    </div>
</form>
