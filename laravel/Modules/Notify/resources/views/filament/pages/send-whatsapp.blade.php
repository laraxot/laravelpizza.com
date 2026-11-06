<?php

declare(strict_types=1);
?>
<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('notify::send_whatsapp.sections.page.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('notify::send_whatsapp.sections.page.description') }}
        </x-slot>

        {{ $this->whatsappForm }}

        <x-slot name="footer">
            <div class="flex items-center justify-end gap-x-3">
                <x-filament::button wire:click="sendWhatsApp" type="submit" color="primary">
                    {{ __('notify::whatsapp.actions.send') }}
                </x-filament::button>
            </div>
        </x-slot>
    </x-filament::section>
</x-filament-panels::page>
