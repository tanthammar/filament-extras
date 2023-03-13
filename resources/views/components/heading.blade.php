@php
    $icon = $getIcon();
    $content = $getContent();
    $iconModal = $getIconModal();
    $hintIcon = $getHintIcon();
    $hintModal = $getHintModal();
    $modalView = $getModalView();;
    $statePath = $getStatePath();
@endphp

<div wire:key="{{ $statePath }}" x-data="{ open: false }">

    <div class="flex p-4 space-x-3">
        <div class="shrink-0">icon</div>
        <div class="grow space-y-2">
            <h3>label</h3>
            <div>content</div>
        </div>
        <div class="ml-auto shrink-0">hintIcon</div>

    </div>

    <!-- Heading -->
    <div {{ $attributes->merge($getExtraAttributes())->class([
                'p-4 flex flex-col text-sm',
                'space-y-4' => (bool) ($content),
                $getStyling(),
            ]) }} x-cloak>
        <div class="flex items-center">

            <!-- Icon -->
            @if ($icon || $iconModal)
                <div {{ $attributes->merge([
                            'wire:key' => "$statePath.icon",
                            'x-on:click.stop' => $iconModal ? 'open = true' : null
                        ])->class([
                            'flex-shrink-0',
                            'cursor-pointer' => $iconModal
                        ]) }}>
                    @svg($icon, 'w-5 h-5')
                </div>
            @endif

            <!-- Label -->
            <div wire:key="{{ $statePath . '.label' }}" @class([
                'ml-3' => (bool) $icon,
                'font-bold'
            ])>
                {{ $getLabel() }}
            </div>

            <!-- Hint -->
            @if ($hintIcon || $hintModal)
                <button type="button" wire:key="{{ $statePath . '.hint' }}" @if($hintModal) x-on:click.stop="open = true" @endif class="ml-auto -mx-1.5 -my-1.5">
                    @svg($hintIcon, 'w-5 h-5')
                </button>
            @endif
        </div>
        <div>
            {{ $content }}
        </div>
    </div>

    <!-- Modal -->
    @if($modalView)
        <div
            x-show="open"
            style="display: none"
            x-on:keydown.escape.prevent.stop="open = false"
            role="dialog"
            aria-modal="true"
            x-id="['{{ $statePath . '.modal' }}']"
            wire:key="['{{ $statePath . '.modal' }}']"
            :aria-labelledby="$id('modal-title')"
            class="fixed inset-0 z-10 overflow-y-auto"
        >
            <!-- Overlay -->
            <div x-show="open" x-transition.opacity class="fixed inset-0 bg-black bg-opacity-50"></div>

            <!-- Panel -->
            <div x-show="open" x-transition x-on:click.stop="open = false" class="relative flex min-h-screen items-center justify-center p-4">
                <div x-on:click.stop x-trap.noscroll.inert="open" class="relative w-full max-w-2xl overflow-y-auto rounded-xl bg-white p-12 shadow-lg">
                    <h2 class="text-3xl font-bold" :id="$id('modal-title')">{{ $getModalTitle() }}</h2>
                    <div>
                        @include($modalView)
                    </div>
                    <div class="mt-8 flex space-x-2">
                        <button type="button" x-on:click.prevent.stop="open = false" class="rounded-md border border-gray-200 bg-white px-5 py-2.5">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
