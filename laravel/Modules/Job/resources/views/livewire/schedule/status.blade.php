<?php

declare(strict_types=1);

?>
<div>
    <x-filament::section></x-filament::section>
    <x-filament::section>
        <x-slot name="title">Schedule Status</x-slot>
        <x-slot name="txt">
            <pre>{!! $out !!}</pre>
        </x-slot>
        <x-slot name="footer">
            @foreach ($acts as $act)
                <button class="btn btn-primary" wire:click="artisan('{{ $act->name }}')">{{ $act->name }}
                </button>
            @endforeach
        </x-slot>
    </x-filament::section>

</div>
