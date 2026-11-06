<?php

declare(strict_types=1);
?>
<x-filament-panels::page>
    
    <form wire:submit="resetPassword">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getCachedFormActions()"
            :full-width="$this->hasFullWidthFormActions()"
        />
    </form>
    
</x-filament-panels::page>
