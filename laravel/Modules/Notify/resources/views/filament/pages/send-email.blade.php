<?php

declare(strict_types=1);
?>
<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('notify::send_email.sections.page.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('notify::send_email.sections.page.description') }}
        </x-slot>

        <form wire:submit="sendEmail">
            {{ $this->emailForm }}
            {{ $error_message ?? '--' }}
            <x-filament::actions :actions="$this->getEmailFormActions()" />

            <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="sendEmail" />
        </form>
    </x-filament::section>
</x-filament-panels::page>
