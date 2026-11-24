<?php

declare(strict_types=1);
?>
<x-filament-panels::page>
    <x-filament::section>
        <x-slot name="heading">
            {{ __('notify::send_push_notification.sections.page.title') }}
        </x-slot>

        <x-slot name="description">
            {{ __('notify::send_push_notification.sections.page.description') }}
        </x-slot>

        {{ $this->notificationForm }}

        <x-slot name="footer">
            <div class="flex items-center justify-between gap-x-3">
                <div>
                    <x-filament::loading-indicator class="h-5 w-5" wire:loading wire:target="sendNotification" />
                </div>
                <div>
                    <x-filament::actions :actions="$this->getNotificationFormActions()" />
                </div>
            </div>
        </x-slot>
    </x-filament::section>
</x-filament-panels::page>
