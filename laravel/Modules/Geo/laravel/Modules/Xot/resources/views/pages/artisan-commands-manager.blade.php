<?php

declare(strict_types=1);

?>
<x-filament::page>
    <div class="space-y-6">
        <div class="p-6 bg-white rounded-xl shadow dark:bg-gray-800">
            <div class="space-y-4">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-medium">
                        @if($isRunning)
                            {{ __('xot::artisan-commands-manager.running', ['command' => $currentCommand]) }}
                        @else
                            {{ __('xot::artisan-commands-manager.select_command') }}
                        @endif
                    </h2>
                    
                    @if($isRunning)
                        <div class="flex items-center space-x-2">
                            <div class="animate-spin rounded-full h-4 w-4 border-b-2 border-primary-500"></div>
                            <span class="text-sm text-gray-500 dark:text-gray-400">
                                {{ __('xot::artisan-commands-manager.executing') }}
                            </span>
                        </div>
                    @endif
                </div>

                <x-xot::terminal />
            </div>
        </div>
    </div>
{{--
    @script
    <script>
        setInterval(() => {
            if (@js($isRunning)) {
                $wire.$refresh()
            }
        }, @js($pollInterval))
    </script>
    @endscript
    --}}
</x-filament::page>
