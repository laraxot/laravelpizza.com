<?php

declare(strict_types=1);

?>
{{--
/**
 * InlineDatePicker View - KISS Principle
 * 
 * La logica è nella classe PHP InlineDatePicker.php
 * Questa vista si limita a renderizzare i dati ricevuti
 */
--}}

@php
    $statePath = $getStatePath();
    $calendarData = $calendarData ?? [];
    $currentValue = $currentValue ?? null;
    $enabledDates = $enabledDates ?? collect();
    $currentViewMonth = $currentViewMonth ?? now()->format('Y-m');
    $monthName = $monthName ?? 'Loading...';
    $weekdays = $weekdays ?? ['L', 'M', 'M', 'G', 'V', 'S', 'D'];
@endphp

<x-dynamic-component 
    :component="$getFieldWrapperView()" 
    :field="$field"
>
    <div 
        x-data="{
            selectedDate: @js($currentValue),
            enabledDates: @js($enabledDates->toArray()),
            
            selectDate(dateString) {
                if (this.enabledDates.includes(dateString)) {
                    // Data abilitata: seleziona
                    this.selectedDate = dateString;
                    $wire.set('{{ $statePath }}', dateString);
                } else {
                    // Data NON abilitata: deseleziona tutto
                    this.selectedDate = null;
                    $wire.set('{{ $statePath }}', null);
                }
            },
            // ✅ Metodi per navigazione mese - chiamata diretta al widget parent
            previousMonth() {
                $wire.call('previousMonth');
            },
            nextMonth() {
                $wire.call('nextMonth');
            }
        }"
        class="space-y-4"
    >
        <!-- Container calendario -->
        <div class="relative">
            <!-- Navigazione -->
            <button 
                type="button" 
                wire:click="previousMonth()"
                class="absolute -left-1.5 -top-1 flex items-center justify-center h-8 w-8 bg-white border border-gray-300 rounded-full shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 z-10"
            >
                <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                </svg>
            </button>
            
            <button 
                type="button" 
                wire:click="nextMonth()"
                class="absolute -right-1.5 -top-1 flex items-center justify-center h-8 w-8 bg-white border border-gray-300 rounded-full shadow-sm hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 z-10"
            >
                <svg class="h-4 w-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </button>

            <!-- Calendario -->
            <section class="text-center">
                <!-- Titolo mese -->
                <h2 class="text-sm font-semibold text-gray-900">{{ $monthName }}</h2>
                
                <!-- Intestazioni giorni -->
                <div class="mt-6 grid grid-cols-7 text-xs/6 text-gray-500">
                    @foreach($weekdays as $weekday)
                        <div>{{ $weekday }}</div>
                    @endforeach
                </div>
                
                <!-- Griglia calendario -->
                <div class="isolate mt-2 grid grid-cols-7 gap-px rounded-lg bg-gray-200 text-sm shadow ring-1 ring-gray-200">
                    @if(isset($calendarData['weeks']) && is_array($calendarData['weeks']))
                        @foreach($calendarData['weeks'] as $week)
                            @foreach($week as $day)
                                @php
                                    $isEnabled = $enabledDates->contains($day['dateString']);
                                    $isSelected = $currentValue === $day['dateString'];
                                    $isCurrentMonth = $day['isCurrentMonth'];
                                    
                                    // ✅ Pre-calcolo classi CSS per performance
                                    if ($isSelected) {
                                        $classes = 'relative py-2 px-1 text-sm font-semibold bg-blue-600 text-white ring-2 ring-blue-600 ring-offset-2 shadow-lg z-10';
                                    } elseif ($isEnabled && $isCurrentMonth) {
                                        $classes = 'relative py-2 px-1 text-sm font-semibold bg-green-50 text-green-700 border-2 border-green-200 hover:bg-green-100 cursor-pointer';
                                    } elseif ($isCurrentMonth) {
                                        $classes = 'relative py-2 px-1 text-sm font-medium bg-gray-50 text-gray-400 border border-gray-200 cursor-not-allowed opacity-60';
                                    } else {
                                        $classes = 'relative py-2 px-1 text-sm font-medium bg-gray-50/30 text-gray-300 cursor-not-allowed opacity-40';
                                    }
                                @endphp
                                
                                <button 
                                    type="button" 
                                    x-on:click="selectDate('{{ $day['dateString'] }}')"
                                    class="{{ $classes }}"
                                >
                                    {{ $day['day'] }}
                                    
                                    @if($isEnabled && $isCurrentMonth)
                                        <span class="absolute -bottom-1 left-1/2 transform -translate-x-1/2 w-1.5 h-1.5 bg-green-500 rounded-full"></span>
                                    @endif
                                    
                                    @if($isSelected)
                                        <span class="absolute -top-1 -right-1 w-2 h-2 bg-blue-400 rounded-full"></span>
                                    @endif
                                </button>
                            @endforeach
                        @endforeach
                    @else
                        <div class="col-span-7 p-4 text-center text-gray-500">Caricamento calendario...</div>
                    @endif
                </div>

               
            </section>
        </div>
    </div>
</x-dynamic-component>

{{-- CSS minimo --}}
<style>
.inline-date-picker button {
    transition: all 200ms cubic-bezier(0.4, 0, 0.2, 1);
}
</style>
