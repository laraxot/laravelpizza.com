<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget class="fi-wi-infolist">
    @if ($this->getInfolistRecord())
        {{ $this->infolist }}
    @else
        <x-filament::section>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('xot::widgets.infolist.record_not_available.label') }}
            </p>
        </x-filament::section>
    @endif
</x-filament-widgets::widget>
