<?php

declare(strict_types=1);
?>
<x-filament-forms::field-wrapper
    :id="$getId()"
    :label="$getLabel()"
    :label-sr-only="$isLabelHidden()"
    :helper-text="$getHelperText()"
    :hint="$getHint()"
    :hint-icon="$getHintIcon()"
    :required="$isRequired()"
    :state-path="$getStatePath()"
>
    <div class="flex items-center gap-x-2" wire:key="order-column-{{ $getStatePath() }}">
        <button
            type="button"
            wire:click="$set('{{ $getStatePath() }}', {{ (int) ($getState() ?? 0) }} - 1)"
            class="fi-icon-btn flex h-6 w-6 items-center justify-center rounded-full text-gray-400 outline-none transition duration-75 hover:text-gray-500 focus-visible:ring-2 focus-visible:ring-primary-600"
            aria-label="{{ __('ui::components.order_column.move_up.label') }}"
        >
            <x-heroicon-m-chevron-up class="h-4 w-4" />
        </button>

        <x-filament::badge color="gray">
            {{ $getState() }}
        </x-filament::badge>

        <button
            type="button"
            wire:click="$set('{{ $getStatePath() }}', {{ (int) ($getState() ?? 0) }} + 1)"
            class="fi-icon-btn flex h-6 w-6 items-center justify-center rounded-full text-gray-400 outline-none transition duration-75 hover:text-gray-500 focus-visible:ring-2 focus-visible:ring-primary-600"
            aria-label="{{ __('ui::components.order_column.move_down.label') }}"
        >
            <x-heroicon-m-chevron-down class="h-4 w-4" />
        </button>
    </div>
</x-filament-forms::field-wrapper>
