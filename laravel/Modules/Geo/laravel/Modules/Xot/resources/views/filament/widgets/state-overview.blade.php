<?php

declare(strict_types=1);

?>
{{-- Vista per il widget AppointmentOverviewWidget --}}
<x-filament-widgets::widget>
        {{-- Grid responsive per gli stati degli appuntamenti (ottimizzato per 17 stati) --}}
        <div class="grid gap-2" style="grid-template-columns: repeat(auto-fit, minmax(120px, 1fr)); max-width: 100%;">
            @forelse($states as $state)
                <div class="bg-white dark:bg-gray-800 rounded-lg p-2 shadow-sm border border-gray-200 dark:border-gray-700 hover:shadow-md transition-shadow duration-200">
                    {{-- Icona e colore dello stato --}}
                    <div class="flex items-center justify-center mb-1">
                        <div class="p-1.5 rounded-full" style="background-color: {{ $state['color'] }}20;">
                            @svg('heroicon-o-' . $state['icon'], 'w-4 h-4', ['style' => 'color: ' . $state['color']])
                        </div>
                    </div>
                    
                    {{-- Conteggio --}}
                    <div class="text-center">
                        <p class="text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ number_format($state['count']) }}
                        </p>
                        <p class="text-xs font-medium text-gray-600 dark:text-gray-400 mt-0.5 leading-tight">
                            {{ $state['label'] }}
                        </p>
                    </div>
                </div>
            @empty
                {{-- Stato vuoto --}}
                <div class="col-span-full text-center py-8">
                    <div class="text-gray-400 dark:text-gray-600">
                        <x-heroicon-o-calendar class="w-12 h-12 mx-auto mb-2" />
                        <p class="text-sm">{{ __('<nome modulo>::widgets.appointment_overview.empty_state') }}</p>
                    </div>
                </div>
            @endforelse
        </div>

</x-filament-widgets::widget>
