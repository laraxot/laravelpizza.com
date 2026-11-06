<?php

declare(strict_types=1);
?>
<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getFormActions()"
        />

    </form>
</x-filament-panels::page>
