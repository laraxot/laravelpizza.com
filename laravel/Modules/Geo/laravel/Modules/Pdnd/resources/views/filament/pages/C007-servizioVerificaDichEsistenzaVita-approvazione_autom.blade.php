<x-filament-panels::page>
    <x-filament::section>
        <form wire:submit="send">
            <x-slot name="heading">
                C007-servizioVerificaDichEsistenzaVita-approvazione_autom
            </x-slot>

            <x-slot name="description">
                Il servizio verifica la corrispondenza di quanto dichiarato da un cittadino con quanto presente in ANPR alla data di riferimento della richiesta.
                La risposta del servizio prevede i seguenti valori: S/N (Si/No).
            </x-slot>
            
            {{ $this->pdndForm }}
            
            <br>

            <x-filament::actions :actions="$this->getPdndFormActions()" />

            <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="send()"/>

            <br> <br>
            @if($risultatoVerifica == 'S')
                Risultato Verifica:
                {{ 'Il soggetto è in vita.' }}
                <x-filament::badge color="success">IN VITA</x-filament::badge>
            @elseif($risultatoVerifica == 'N')
                Risultato Verifica:
                {{ 'Il soggetto non è in vita.' }}
                <x-filament::badge color="gray">DECEDUTO</x-filament::badge>
            @else
                Risultato Verifica: {{ '--' }}
            @endif

        </form>
    </x-filament::section>
</x-filament-panels::page>