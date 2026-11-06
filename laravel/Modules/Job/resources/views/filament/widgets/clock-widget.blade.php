<?php

declare(strict_types=1);
?>
<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}

        <x-filament::button wire:click="begin">{{ __('job::common.actions.start_stop.label') }}</x-filament::button>

        <h1>{{ __('job::common.fields.time.label') }}: <span wire:stream="count">{{ $time }}</span></h1>
    </x-filament::section>
</x-filament-widgets::widget>
