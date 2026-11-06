<?php

declare(strict_types=1);
?>
<x-filament-panels::page>

    <form wire:submit="updateLogo">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getUpdateLogoFormActions()"
        />

    </form>

</x-filament-panels::page>
