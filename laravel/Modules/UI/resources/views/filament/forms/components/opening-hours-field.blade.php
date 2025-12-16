<?php

declare(strict_types=1);

?>
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{}" {{ $attributes->merge($getExtraAttributes())->class([
        'filament-forms-opening-hours-field-component',
    ]) }}>
        <div class="space-y-4">
            {{-- Intestazione con istruzioni --}}
            @if($getHelperText())
                <div class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <div class="flex items-start space-x-2">
                        <x-heroicon-o-information-circle class="w-4 h-4 mt-0.5 flex-shrink-0" />
                        <div>
                            <p class="font-medium">{{ __('ui::opening_hours.instructions.title') }}</p>
                            <p class="text-xs mt-1">{{ $getHelperText() }}</p>
                        </div>
                    </div>
                </div>
            @endif

            {{-- Legenda per gli stati --}}
            <div class="bg-gray-50 dark:bg-gray-900/50 rounded-lg p-3 text-sm">
                <div class="flex items-center space-x-4 text-xs">
                    <div class="flex items-center space-x-1">
                        <span class="text-green-600">✅</span>
                        <span class="text-gray-600 dark:text-gray-400">{{ __('ui::opening_hours.legend.open') }}</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="text-red-600">❌</span>
                        <span class="text-gray-600 dark:text-gray-400">{{ __('ui::opening_hours.legend.closed') }}</span>
                    </div>
                    <div class="flex items-center space-x-1">
                        <span class="text-gray-400">⏰</span>
                        <span class="text-gray-600 dark:text-gray-400">{{ __('ui::opening_hours.legend.format') }}</span>
                    </div>
                </div>
            </div>

            {{-- Rendering del contenuto del form schema --}}
            <div class="filament-forms-opening-hours-content">
                {{ $getChildComponentContainer() }}
            </div>

            {{-- Note aggiuntive --}}
            <div class="text-xs text-gray-500 dark:text-gray-400 mt-4">
                <p>{{ __('ui::opening_hours.notes.format_hint') }}</p>
                <p>{{ __('ui::opening_hours.notes.empty_hint') }}</p>
            </div>
        </div>
    </div>
</x-dynamic-component>
