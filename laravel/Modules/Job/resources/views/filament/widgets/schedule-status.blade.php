<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">{{ __('job::schedule_status_widget.sections.status.title') }}</x-slot>

        <pre>{!! $out !!}</pre>

        @foreach ($this->getAllowedCommands() as $cmd)
            <x-filament::button wire:click="artisan('{{ $cmd }}')">
                {{ $cmd }}
            </x-filament::button>
        @endforeach
    </x-filament::section>
</x-filament-widgets::widget>
