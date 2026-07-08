<?php

declare(strict_types=1);

?>
<x-filament-panels::page>


    @if ($lastRanAt)
        <div
            class="{{ $lastRanAt->diffInMinutes() > 5 ? 'text-red-500' : 'text-gray-400 dark:text-gray-200' }} text-md text-center font-medium">
            {{ __('Check') }}
            {{ $lastRanAt->diffForHumans() }}
        </div>
    @endif

</x-filament-panels::page>
