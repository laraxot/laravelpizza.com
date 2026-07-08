<x-filament-panels::page>
    <x-filament::section>
    <form wire:submit="send">
        <x-slot name="heading">
            SERVIZIO C030-servizioAccertamentoIdUnicoNazionale-approvazione_autom, v.4
        </x-slot>

        <x-slot name="description">
            Il servizio prevede la restituzione dell'identificativo unico nazionale assegnato a ciascun cittadino presente in ANPR.
            Richiede come input il Codice Fiscale del cittadino interessato.
        </x-slot>
        
        {{ $this->pdndForm }}
        {{ $error_message ?? '--' }}
        
        <x-filament::actions :actions="$this->getPdndFormActions()" />

        <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="send()"/>
        </form>
        idAnpr: {{ $idAnpr }}
    </x-filament::section>
</x-filament-panels::page>