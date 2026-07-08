<?php

declare(strict_types=1);

?>
{{--
/**
 * State Icons Split Component
 * 
 * Displays state transition icons in a responsive grid layout with proper spacing and visual hierarchy.
 * 
 * @param array $states Array of state configurations
 * @param object $record The current record
 * @param string $stateClass The state class name
 * @param string $modelClass The model class name
 */
--}}

@php
    // Get the data from the ViewColumn's getState() method
    $data = $getState();
    $record = $data['record'] ?? null;
    $states = $data['states'] ?? [];
    $stateClass = $data['stateClass'] ?? '';
    $modelClass = $data['modelClass'] ?? '';
@endphp

<div class="flex flex-wrap gap-1 items-center justify-start min-h-[2rem]" 
     x-data="{ 
         hoveredState: null,
         showTooltip: false 
     }">
    
    @if(empty($states))
        <span class="text-gray-400 text-xs italic">
            {{ __('ui::components.state_icons.no_transitions') }}
        </span>
    @else
        @foreach($states as $stateKey => $stateConfig)
            @php
                $canTransition = $record?->state?->canTransitionTo($stateConfig['class']) ?? false;
                $stateInstance = $stateConfig['instance'];
            @endphp
            
            @if($canTransition)
                <div class="relative inline-flex"
                     x-data="{ showTooltip: false }"
                     @mouseenter="showTooltip = true"
                     @mouseleave="showTooltip = false">
                    
                    {{-- State Action Button --}}
                    <button type="button"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-full 
                                   transition-all duration-200 ease-in-out
                                   hover:scale-110 hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-1
                                   {{ $stateInstance->bgColor() ? 'bg-' . $stateInstance->bgColor() . '-100 hover:bg-' . $stateInstance->bgColor() . '-200 focus:ring-' . $stateInstance->bgColor() . '-500' : 'bg-gray-100 hover:bg-gray-200 focus:ring-gray-500' }}"
                            wire:click="mountTableAction('{{ $stateKey }}-action', '{{ $record->getKey() }}')"
                            title="{{ $stateInstance->label() }}"
                            aria-label="{{ $stateInstance->label() }}">
                        
                        {{-- State Icon --}}
                        @if($stateInstance->icon())
                            <x-filament::icon 
                                :icon="$stateInstance->icon()" 
                                class="w-4 h-4 {{ $stateInstance->color() ? 'text-' . $stateInstance->color() . '-600' : 'text-gray-600' }}" />
                        @else
                            <div class="w-2 h-2 rounded-full {{ $stateInstance->color() ? 'bg-' . $stateInstance->color() . '-600' : 'bg-gray-600' }}"></div>
                        @endif
                    </button>
                    
                    {{-- Enhanced Tooltip --}}
                    <div x-show="showTooltip"
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 transform scale-95"
                         x-transition:enter-end="opacity-100 transform scale-100"
                         x-transition:leave="transition ease-in duration-150"
                         x-transition:leave-start="opacity-100 transform scale-100"
                         x-transition:leave-end="opacity-0 transform scale-95"
                         class="absolute z-50 px-3 py-2 text-sm font-medium text-white bg-gray-900 rounded-lg shadow-lg
                                bottom-full left-1/2 transform -translate-x-1/2 mb-2 min-w-max"
                         style="display: none;">
                        
                        <div class="text-center">
                            <div class="font-semibold">{{ $stateInstance->label() }}</div>
                            @if($stateInstance->modalDescription())
                                <div class="text-xs text-gray-300 mt-1">
                                    {{ Str::limit($stateInstance->modalDescription(), 50) }}
                                </div>
                            @endif
                        </div>
                        
                        {{-- Tooltip Arrow --}}
                        <div class="absolute top-full left-1/2 transform -translate-x-1/2">
                            <div class="border-4 border-transparent border-t-gray-900"></div>
                        </div>
                    </div>
                </div>
            @endif
        @endforeach
        
        {{-- State Count Indicator (when many states) --}}
        @if(count(array_filter($states, fn($state) => $record?->state?->canTransitionTo($state['class']) ?? false)) > 4)
            <div class="text-xs text-gray-500 ml-2 px-2 py-1 bg-gray-100 rounded-full">
                {{ count(array_filter($states, fn($state) => $record?->state?->canTransitionTo($state['class']) ?? false)) }}
            </div>
        @endif
    @endif
</div>

{{-- Additional Styles for Better Visual Hierarchy --}}
<style>
    .state-icons-container {
        /* Custom scrollbar for horizontal overflow on mobile */
        scrollbar-width: thin;
        scrollbar-color: #cbd5e0 #f7fafc;
    }
    
    .state-icons-container::-webkit-scrollbar {
        height: 4px;
    }
    
    .state-icons-container::-webkit-scrollbar-track {
        background: #f7fafc;
        border-radius: 2px;
    }
    
    .state-icons-container::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 2px;
    }
    
    .state-icons-container::-webkit-scrollbar-thumb:hover {
        background: #a0aec0;
    }
    
    /* Responsive adjustments */
    @media (max-width: 640px) {
        .state-icons-container {
            overflow-x: auto;
            flex-wrap: nowrap;
        }
    }
</style>
