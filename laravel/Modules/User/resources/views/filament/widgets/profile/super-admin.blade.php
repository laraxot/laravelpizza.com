<?php

declare(strict_types=1);
?>
<span>
@if ($profile->isSuperAdmin())
    <x-filament::icon-button
        icon="user-superman"
        color="warning"
        size="sm"
        data-super-admin-state="active"
        :label="__('user::super_admin_widget.tooltip.active')"
        :tooltip="__('user::super_admin_widget.tooltip.active')"
        wire:click="toggleSuperAdmin"
    />
@elseif ($profile->isNegateSuperAdmin())
    <x-filament::icon-button
        icon="user-clark-kent"
        color="danger"
        size="sm"
        data-super-admin-state="negated"
        :label="__('user::super_admin_widget.tooltip.negated')"
        :tooltip="__('user::super_admin_widget.tooltip.negated')"
        wire:click="toggleSuperAdmin"
    />
@endif
</span>
