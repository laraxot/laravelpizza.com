<?php

declare(strict_types=1);

?>
<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            Test Invio WhatsApp
        </x-slot>

        <x-slot name="description">
            Utilizza questo form per testare l'invio di messaggi WhatsApp tramite diversi provider.
        </x-slot>

        {{ $this->whatsappForm }}

        <x-slot name="footer">
            <div class="flex items-center justify-end gap-x-3">
                <x-filament::button wire:click="sendWhatsApp" type="submit" color="primary">
                    Invia WhatsApp
                </x-filament::button>
            </div>
        </x-slot>
    </x-filament::section>
</x-filament-panels::page>
