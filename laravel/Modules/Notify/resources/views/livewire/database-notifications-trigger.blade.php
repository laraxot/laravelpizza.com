<?php

declare(strict_types=1);

?>
<x-filament::icon-button
    :badge="$unreadNotificationsCount"
    color="gray"
    icon="heroicon-o-bell"
    icon-alias="panels::topbar.open-database-notifications-button"
    icon-size="lg"
    :label="__('filament-panels::layout.actions.open_database_notifications.label')"
/>
{{--
<button  @class([
                'flex flex-shrink-0 w-10 h-10 rounded-full bg-gray-200 items-center justify-center',
                'dark:bg-gray-900' => config('filament.dark_mode'),
            ]) aria-label="{{ __('filament::layout.buttons.user_menu.label') }}">
                @svg('heroicon-o-bell', 'w-4 h-4')
        <span class=" p-1 rounded text-blue-600 text-xs ml-2">{{ $unreadNotificationsCount }}</span>
</button>
--}}


{{--
    <button type="button">
    Notifications ({{ $unreadNotificationsCount }} unread)
</button>

--}}
