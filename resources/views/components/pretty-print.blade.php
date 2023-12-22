<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div class="border dark:border-gray-600 rounded bg-white dark:bg-gray-800 p-6 w-full">
        <pre class="w-full overflow-x-auto">{!! print_r(data_get($this, $getStatePath()), true)  !!}</pre>
        {{-- <pre><code>{!! json_encode(data_get($this, $getStatePath()), JSON_PRETTY_PRINT)   !!}</code>}</pre> --}}
    </div>
</x-dynamic-component>
