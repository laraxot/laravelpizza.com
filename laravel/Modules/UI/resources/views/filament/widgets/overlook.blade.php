<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget id="overlook-widget">

    <x-filament::section class="relative overflow-hidden overlook-card bg-gradient-to-tr group">


            <div class="grid items-center sm:gap-6 sm:grid-cols-2">
                <div class="py-4">
                    <div class="text-center overlook-name ">{{ $title }}</div>
                </div>
                <div>
                    @foreach ($stats as $stat)
                    <div class="flex items-center justify-between text-gray-400">
                        <div class="flex items-center space-x-1">
                            {{--
                            <x-heroicon-o-chat-bubble-left class="size-4" />
                            --}}
                            <x-filament::icon :icon="$stat['icon']" class="size-4" />
                            <h4 class="text-gray-700 dark:text-white">{{ $stat['label'] }}</h4>
                        </div>
                        <span class="text-sm">{{ $stat['value'] }}</span>
                    </div>
                    @endforeach
                </div>

        </div>

        <x-filament::icon :icon="$icon" :size="24"
            class="absolute w-auto transition left-2 text-primary-500 h-36 z-1 overlook-icon -bottom-12 opacity-10 dark:opacity-10 group-hover:scale-110 group-hover:-rotate-12 group-hover:opacity-30" />

    </x-filament::section>


</x-filament-widgets::widget>
