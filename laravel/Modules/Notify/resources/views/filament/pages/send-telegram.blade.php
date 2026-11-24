<?php

declare(strict_types=1);
?>
<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('notify::send_telegram.sections.page.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('notify::send_telegram.sections.page.description') }}
        </x-slot>

        {{ $this->telegramForm }}

        <x-slot name="footer">
            <div class="flex items-center justify-end gap-x-3">
                <x-filament::button wire:click="sendTelegram" type="submit" color="primary">
                    {{ __('notify::telegram.actions.send') }}
                </x-filament::button>
            </div>
        </x-slot>
    </x-filament::section>
</x-filament-panels::page>
