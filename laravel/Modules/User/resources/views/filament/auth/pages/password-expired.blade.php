<?php

declare(strict_types=1);

?>
<x-filament-panels::page>
    
    <x-filament-schemas::form wire:submit="resetPassword">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </x-filament-schemas::form>
    
</x-filament-panels::page>
