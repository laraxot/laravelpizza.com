<?php

declare(strict_types=1);

?>
<x-filament-panels::page>
    <form wire:submit.prevent="sendSMS">
        <x-filament::section>
            <x-slot name="heading">
                Test Invio SMS
            </x-slot>

            <x-slot name="description">
                Utilizza questo form per testare l'invio di messaggi SMS tramite diversi provider.
            </x-slot>

            {{ $this->smsForm }}

            <div class="flex items-center justify-between gap-x-3">
                <div>
                    <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="sendSMS"/>
                </div>
                <div>
                    @foreach ($this->getSmsFormActions() as $action)
                        {{ $action }}
                    @endforeach
                </div>
            </div>

        </x-filament::section>
    </form>
</x-filament-panels::page>
