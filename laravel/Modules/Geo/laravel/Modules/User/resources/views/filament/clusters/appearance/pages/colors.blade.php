<?php

declare(strict_types=1);

?>
<x-filament-panels::page>

    <x-filament-schemas::form wire:submit="updateData">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getUpdateFormActions()"
        />

    </x-filament-schemas::form>

</x-filament-panels::page>
