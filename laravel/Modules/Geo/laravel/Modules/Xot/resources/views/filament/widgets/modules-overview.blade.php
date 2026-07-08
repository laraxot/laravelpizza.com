<?php

declare(strict_types=1);

?>
<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            <div class="flex items-center gap-2">
                <x-heroicon-o-cube class="h-5 w-5" />
                {{ __('xot::widgets.modules_overview.title') }}
            </div>
        </x-slot>

        <x-slot name="description">
            {{ __('xot::widgets.modules_overview.description') }}
        </x-slot>

        @php
            $modules = $this->getModules();
        @endphp

        @if(count($modules) > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-2">
                @foreach($modules as $module)
                    <a 
                        href="{{ $module['url'] }}" 
                        class="group block p-2 bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-sm transition-all duration-150"
                    >
                        <div class="flex flex-col items-center text-center space-y-1">
                            <div class="flex-shrink-0">
                                <div class="w-6 h-6 bg-primary-50 dark:bg-primary-900/20 rounded flex items-center justify-center group-hover:bg-primary-100 dark:group-hover:bg-primary-900/40 transition-colors duration-150">
                                    <x-dynamic-component :component="$module['icon']" class="h-3 w-3 text-primary-600 dark:text-primary-400" />
                                </div>
                            </div>
                            
                            <div class="flex-1 min-w-0 w-full">
                                <h3 class="text-xs font-medium text-gray-900 dark:text-gray-100 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors duration-150 truncate">
                                    {{ $module['name'] }}
                                </h3>
                                @if(!empty($module['description']))
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 line-clamp-1">
                                        {{ $module['description'] }}
                                    </p>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div class="text-center py-8">
                <x-heroicon-o-cube class="mx-auto h-12 w-12 text-gray-400" />
                <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ __('xot::widgets.modules_overview.empty.title') }}
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    {{ __('xot::widgets.modules_overview.empty.description') }}
                </p>
            </div>
        @endif
    </x-filament::section>
</x-filament-widgets::widget>
