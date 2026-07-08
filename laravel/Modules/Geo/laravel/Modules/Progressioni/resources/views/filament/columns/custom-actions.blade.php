class="flex gap-2">
    <x-filament::button
        wire:click="azioneUno({{ $getRecord()->id }})"
        onclick="event.stopPropagation()"
        color="primary"
        size="sm"
    >
        Uno
    </x-filament::button>
    
    <x-filament::button
        wire:click="azioneDue({{ $getRecord()->id }})"
        onclick="event.stopPropagation()"
        color="danger"
        size="sm"
        x-on:click="$wire.mountAction('confirmAzioneDue', { record: {{ $getRecord()->id }} })"
    >
        Due
    </x-filament::button>
</div>