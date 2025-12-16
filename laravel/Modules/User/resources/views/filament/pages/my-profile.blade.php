<?php

declare(strict_types=1);

?>
<x-filament-panels::page>
    <x-filament-schemas::form wire:submit="updateProfile">
        {{ $this->editProfileForm }}

        <x-filament::actions :actions="$this->getUpdateProfileFormActions()" />
    </x-filament-schemas::form>

    <x-filament-schemas::form wire:submit="updatePassword">
        {{ $this->editPasswordForm }}

        <x-filament::actions :actions="$this->getUpdatePasswordFormActions()" />
    </x-filament-schemas::form>
</x-filament-panels::page>
