<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-4">
            <h3 class="text-lg font-medium">{{ __('ui::widgets.user-calendar.title') }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('ui::widgets.user-calendar.description') }}
            </p>

            <div class="mt-4">
                <p class="text-sm text-gray-500">
                    {{ __('ui::widgets.user-calendar.implementation_pending') }}
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>