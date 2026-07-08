<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="send">
            <x-slot name="heading">
                SERVIZIO C003-servizioVerificaDichGeneralita-approvazione_autom
            </x-slot>

            <x-slot name="description">
                Il servizio verifica la corrispondenza di quanto dichiarato da un cittadino con quanto presente in ANPR alla data di riferimento della richiesta.
                La risposta del servizio prevede i seguenti valori: S/N (Si/No).
            </x-slot>
            
            {{ $this->pdndForm }}
            {{ $error_message ?? '--' }}
            
            <x-filament::actions :actions="$this->getPdndFormActions()" />
            <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="send()"/>
            
            
            @if($risultatoVerifica == 'S')
                Risultato Verifica: {{ 'C\'è corrispondenza' }}
            @elseif($risultatoVerifica == 'N')
                Risultato Verifica: {{ 'Non c\'è corrispondenza' }}
            @else
                Risultato Verifica: {{ '--' }}
            @endif
        </form
    </x-filament::section>
</x-filament-panels::page>