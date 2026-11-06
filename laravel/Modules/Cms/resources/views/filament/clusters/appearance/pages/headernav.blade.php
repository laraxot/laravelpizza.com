<?php

declare(strict_types=1);

?>
<x-filament-panels::page>

    <form wire:submit="updateData">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getUpdateFormActions()"
        />

    </form>

</x-filament-panels::page>
