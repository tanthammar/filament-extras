<x-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div x-data="{ state: $wire.entangle('{{ $getStatePath() }}') }"
         x-text="state"
         style="min-height: 42px"
        @class([
              'block w-full m-0 py-2 px-3 cursor-default leading-6 border border-dashed transition duration-75 rounded-lg shadow-sm focus:border-primary-600 focus:ring-1 focus:ring-inset focus:ring-primary-600 disabled:opacity-70',
              'dark:bg-gray-500/10 dark:text-white dark:focus:border-gray-900' => config('forms.dark_mode'),
              'border-gray-300' => ! $errors->has($getStatePath()),
              'dark:border-gray-600' => (! $errors->has($getStatePath())) && config('forms.dark_mode'),
              'border-danger-600 ring-danger-600' => $errors->has($getStatePath()),
       ])>
    </div>

</x-forms::field-wrapper>
