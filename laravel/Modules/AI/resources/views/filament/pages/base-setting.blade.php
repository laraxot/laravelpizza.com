<?php

declare(strict_types=1);
?>
{{-- Vista unica di BaseSettingPage: i moduli scrivono solo il form, mai una vista. --}}
<x-filament-panels::page>
    <form wire:submit="save">
        {{ $this->form }}

        <x-filament::actions
            :actions="$this->getFormActions()"
        />
    </form>
</x-filament-panels::page>
