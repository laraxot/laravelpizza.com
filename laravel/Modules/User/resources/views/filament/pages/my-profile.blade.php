<?php

declare(strict_types=1);

?>
<x-filament-panels::page>
    <form wire:submit="updateProfile">
        {{ $editProfileForm }}

        <x-filament::actions :actions="$this->getUpdateProfileFormActions(
    </form>

    <form wire:submit="updatePassword">
        {{ $editPasswordForm }}

        <x-filament::actions :actions="$this->getUpdatePasswordFormActions(
    </form>
</x-filament-panels::page>
