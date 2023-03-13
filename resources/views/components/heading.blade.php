@php
    $icon = $getIcon();
    $content = $getContent();
    $iconModal = $getIconModal();
    $hintIcon = $getHintIcon();
    $hintModal = $getHintModal();
    $modalView = $getModalView();;
    $statePath = $getStatePath();
@endphp

<div wire:key="{{ $statePath }}" x-data="{ open: false }" class="w-full">

    <!-- Heading -->
    <div {{ $attributes->merge($getExtraAttributes())->class([
                'w-full flex items-start p-4 text-sm',
                'space-x-3' => $icon || $hintModal,
                $getStyling(),
            ]) }} x-cloak>

            <!-- Icon -->
            @if ($icon || $iconModal)
                <div {{ $attributes->merge([
                            'wire:key' => "$statePath.icon",
                            'x-on:click.stop' => $iconModal ? 'open = true' : null
                        ])->class([
                            'shrink-0',
                            'cursor-pointer' => $iconModal
                        ]) }}>
                    @svg($icon, 'w-5 h-5')
                </div>
            @endif

            <!-- Label/Content -->
            <div @class(['grow', 'space-y-1' => (bool) $content])>
                <h3 wire:key="{{ $statePath . '.label' }}" class="font-bold">
                    {{ $getLabel() }}
                </h3>
                <div class="text-sm">
                    {{ $content }}
                </div>
            </div>

            <!-- Hint -->
            @if ($hintIcon || $hintModal)
                <button type="button" wire:key="{{ $statePath . '.hint' }}" @if($hintModal) x-on:click.stop="open = true" @endif class="ml-auto shrink-0">
                    @svg($hintIcon, 'w-5 h-5')
                </button>
            @endif
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
            <div x-show="open" x-transition x-on:click.stop="open = false" class="relative z-50 flex min-h-screen items-center justify-center p-4">
                <div x-on:click.stop x-trap.noscroll.inert="open" class="relative w-full max-w-2xl overflow-y-auto rounded-xl bg-white dark:bg-gray-700 shadow-lg">
                    <div class="flex items-start justify-between px-6 py-4 border-b rounded-t dark:border-gray-600">
                        <h2 class="text-xl font-bold text-gray-900 dark:text-white" wire:key="{{ $statePath . '.modal.title' }}">{{ $getModalTitle() }}</h2>
                        <button type="button" x-on:click.prevent.stop="open = false" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white">
                            @svg('heroicon-o-x', 'w-5 h-5')
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <div wire:key="{{ $statePath . '.modal.content' }}" class="p-6">
                        @include($modalView)
                    </div>
                    <div class="px-6 py-4 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button type="button" x-on:click.prevent.stop="open = false" class="text-white bg-primary-700 hover:bg-primary-800 focus:ring-4 focus:outline-none focus:ring-primary-300 font-bold rounded-md text-sm px-5 py-2.5 text-center dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                            OK
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
