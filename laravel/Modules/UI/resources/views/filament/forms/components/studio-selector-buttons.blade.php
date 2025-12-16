<?php

declare(strict_types=1);

?>
{{-- Componente per la selezione di studi odontoiatrici tramite pulsanti --}}
<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{
        selectedStudio: $wire.entangle('{{ $statePath }}'),
        selectStudio(studioId) {
            this.selectedStudio = studioId;
            document.getElementById('{{ $componentId }}').dispatchEvent(new Event('change'));
        }
    }" class="space-y-4">
        {{-- Header con titolo --}}
        <div class="text-xl font-medium text-gray-900 dark:text-white">
            Gli Studi Odontoiatrici più vicini a te
        </div>

        {{-- Lista degli studi come pulsanti/card --}}
        <div class="space-y-3 md:grid md:grid-cols-2 md:gap-6 md:space-y-0">
            @foreach ($studios as $studio)
                <div 
                    x-bind:class="selectedStudio == {{ $studio['id'] }} ? 'ring-2 ring-primary-500' : ''"
                    class="relative bg-white dark:bg-gray-800 rounded-lg shadow-sm hover:shadow-md transition-all duration-200 ease-in-out p-4 cursor-pointer overflow-hidden"
                    x-on:click="selectStudio({{ $studio['id'] }})"
                >
                    {{-- Indicatore di selezione --}}
                    <div 
                        x-show="selectedStudio == {{ $studio['id'] }}"
                        class="absolute top-0 right-0 bg-primary-500 text-white p-1 rounded-bl-md"
                    >
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </div>

                    {{-- Contenuto dello studio --}}
                    <div @class([
                        'flex flex-col space-y-2',
                        'opacity-75' => !($studio['id'] === $getState()),
                    ])>
                        <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                            {{ $studio['name'] }}
                        </h3>
                        
                        <div class="text-sm text-gray-600 dark:text-gray-300">
                            <div class="flex items-start">
                                <svg class="w-4 h-4 mt-0.5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                                <span>{{ $studio['address'] }}</span>
                            </div>
                            
                            @if(isset($studio['phone']) && $studio['phone'])
                                <div class="flex items-start mt-1">
                                    <svg class="w-4 h-4 mt-0.5 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                                    </svg>
                                    <span>{{ $studio['phone'] }}</span>
                                </div>
                            @endif
                        </div>
                        
                        {{-- Pulsante prenota --}}
                        <div class="mt-4 flex justify-end">
                            <button 
                                type="button"
                                class="inline-flex items-center justify-center py-1 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500"
                            >
                                Prenota
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Messaggio se non ci sono studi --}}
        @if (count($studios) === 0)
            <div class="text-center py-4 text-gray-500 dark:text-gray-400">
                Nessuno studio trovato con i criteri di ricerca selezionati.
            </div>
        @endif
    </div>
</x-dynamic-component>
