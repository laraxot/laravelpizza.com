<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <x-filament::section>
        <div class="p-4">
            <h3 class="text-lg font-medium">{{ __('xot::widgets.base.title') }}</h3>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('xot::widgets.base.description') }}
            </p>

            <div class="mt-4">
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-3">
                    <p class="text-sm text-yellow-800 dark:text-yellow-200">
                        <strong>{{ __('xot::widgets.base.warning') }}:</strong>
                        {{ __('xot::widgets.base.abstract_widget_message') }}
                    </p>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>