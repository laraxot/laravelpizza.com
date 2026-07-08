<?php

declare(strict_types=1);

?>
{{-- Studio Selector Component - Card cliccabili per selezione studio --}}
<div 
    x-data="{
        selectedStudioId: @js($selectedStudioId ?? null),
        selectStudio(studioId, studioName) {
            this.selectedStudioId = studioId;
            
            // Aggiorna i campi del form tramite Livewire
            $wire.set('data.selected_studio', studioId);
            $wire.set('data.selected_studio_name', studioName);
            
            // Mostra notifica di conferma
            window.dispatchEvent(new CustomEvent('notify', {
                detail: {
                    type: 'success',
                    title: @js(__('ui::studio_selector.messages.studio_selected_title')),
                    body: @js(__('ui::studio_selector.messages.studio_selected_body')).replace(':studio_name', studioName)
                }
            }));
        }
    }"
    class="space-y-6"
>
    {{-- Titolo sezione --}}
    <div class="text-center">
        <h3 class="text-lg font-medium text-gray-900 dark:text-gray-100">
            {{ __('ui::studio_selector.studio_list.title') }}
        </h3>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('ui::studio_selector.studio_list.subtitle') }}
        </p>
    </div>

    @if($studios && $studios->count() > 0)
        {{-- Contatore studi trovati --}}
        <div class="text-center">
            <p class="text-sm font-medium text-blue-600 dark:text-blue-400">
                {{ __('ui::studio_selector.studio_list.count_found', ['count' => $studios->count()]) }}
            </p>
        </div>

        {{-- Grid di card studi --}}
        <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach($studios as $studio)
                <div 
                    x-bind:class="{
                        'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20': selectedStudioId == {{ $studio->id }},
                        'ring-1 ring-gray-200 dark:ring-gray-700 hover:ring-gray-300 dark:hover:ring-gray-600': selectedStudioId != {{ $studio->id }}
                    }"
                    class="bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-6 cursor-pointer transition-all duration-200 hover:shadow-md"
                    @click="selectStudio({{ $studio->id }}, '{{ addslashes($studio->name) }}')"
                >
                    {{-- Header studio --}}
                    <div class="flex items-start justify-between mb-4">
                        <div class="flex-1">
                            <h4 class="text-lg font-semibold text-gray-900 dark:text-gray-100 line-clamp-2">
                                {{ $studio->name }}
                            </h4>
                            
                            {{-- Badge stato --}}
                            <div class="mt-2">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                    {{ __('ui::studio_selector.studio_list.active_label') }}
                                </span>
                            </div>
                        </div>
                        
                        {{-- Icona selezione --}}
                        <div class="ml-4">
                            <div 
                                x-show="selectedStudioId == {{ $studio->id }}"
                                class="w-6 h-6 bg-blue-500 rounded-full flex items-center justify-center"
                            >
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                </svg>
                            </div>
                            <div 
                                x-show="selectedStudioId != {{ $studio->id }}"
                                class="w-6 h-6 border-2 border-gray-300 dark:border-gray-600 rounded-full"
                            ></div>
                        </div>
                    </div>

                    {{-- Indirizzo --}}
                    @if($studio->address)
                        <div class="mb-4">
                            <div class="flex items-start text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"></path>
                                </svg>
                                <span class="line-clamp-2">
                                    {{ $studio->address->formatted_address ?? 
                                       ($studio->address->street_address . ', ' . $studio->address->locality . ' ' . $studio->address->postal_code) }}
                                </span>
                            </div>
                        </div>
                    @endif

                    {{-- Informazioni aggiuntive --}}
                    <div class="space-y-2 mb-4">
                        {{-- Numero dottori --}}
                        @if($studio->doctors && $studio->doctors->count() > 0)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                </svg>
                                <span>
                                    {{ trans_choice('ui::studio_selector.studio_list.doctors_count', $studio->doctors->count(), ['count' => $studio->doctors->count()]) }}
                                </span>
                            </div>
                        @endif

                        {{-- Telefono se disponibile --}}
                        @if($studio->phone)
                            <div class="flex items-center text-sm text-gray-600 dark:text-gray-400">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                </svg>
                                <span>{{ $studio->phone }}</span>
                            </div>
                        @endif
                    </div>

                    {{-- Pulsante azione --}}
                    <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                        <button 
                            type="button"
                            @click.stop="selectStudio({{ $studio->id }}, '{{ addslashes($studio->name) }}')"
                            x-bind:class="{
                                'bg-blue-600 text-white hover:bg-blue-700': selectedStudioId == {{ $studio->id }},
                                'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-700 dark:text-gray-300 dark:hover:bg-gray-600': selectedStudioId != {{ $studio->id }}
                            }"
                            class="w-full px-4 py-2 text-sm font-medium rounded-md transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                        >
                            <span x-show="selectedStudioId == {{ $studio->id }}">
                                {{ __('ui::studio_selector.studio_list.actions.selected') }}
                            </span>
                            <span x-show="selectedStudioId != {{ $studio->id }}">
                                {{ __('ui::studio_selector.studio_list.actions.select') }}
                            </span>
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Empty state --}}
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ __('ui::studio_selector.studio_list.empty_state.title') }}
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ __('ui::studio_selector.studio_list.empty_state.description') }}
            </p>
        </div>
    @endif
</div>
