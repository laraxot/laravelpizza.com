<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content --}}

        <x-filament::button wire:click="begin">Start/Stop</x-filament::button>

        <h1>Time: <span wire:stream="count">{{ $time }}</span></h1>
    </x-filament::section>
</x-filament-widgets::widget>
