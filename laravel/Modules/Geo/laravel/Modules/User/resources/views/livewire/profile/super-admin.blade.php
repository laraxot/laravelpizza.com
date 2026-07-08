<?php

declare(strict_types=1);

?>
<div>
@if (isset($profile) && $profile->isSuperAdmin())
    <x-filament::icon-button icon="fas-chess-king" class="h-5 w-5 text-gray-500 dark:text-gray-400"
        tooltip="Super Admin" wire:click="toggleSuperAdmin" />
@endif
@if (isset($profile) && $profile->isNegateSuperAdmin())
    <x-filament::icon-button icon="fas-chess-king" class="h-5 w-5 text-gray-500 dark:text-gray-400 rotate-180"
        tooltip="Negate Super Admin" wire:click="toggleSuperAdmin" />
@endif
</div>
