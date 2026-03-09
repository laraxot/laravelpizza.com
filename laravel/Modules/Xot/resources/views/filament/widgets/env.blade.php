<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <x-filament::section>
        {{-- Widget content

        <x-filament::button wire:click="begin">Start/Stop</x-filament::button>

        <h1>Time: <span wire:stream="count">{{ $time }}</span></h1>
        --}}
         <form wire:submit.prevent="submit">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Save <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="submit"/>
        </x-filament::button>
    </form>

    </x-filament::section>
</x-filament-widgets::widget>
