<?php

declare(strict_types=1);
?>
@if (isset($_profile) && $_profile->isSuperAdmin())
    <x-filament::icon-button icon="fas-chess-king" class="h-5 w-5 text-gray-500 dark:text-gray-400"
        :tooltip="__('user::super_admin_widget.tooltip.active')" />
@endif
