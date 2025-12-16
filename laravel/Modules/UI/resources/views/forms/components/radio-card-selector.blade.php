<?php

declare(strict_types=1);

?>
{{-- Radio Card Selector Component --}}
@php
    $cards = $getCards();
    $sectionTitle = $getSectionTitle();
    $sectionSubtitle = $getSectionSubtitle();
    $targetField = $getTargetFieldName();
    $emptyStateTitle = $getEmptyStateTitle();
    $emptyStateDescription = $getEmptyStateDescription();
    $statePath = $getStatePath();
@endphp

<div 
    x-data="{
        selectedValue: @js($getState()),
        selectCard(id, title) {
            this.selectedValue = id;
            $wire.set('{{ $statePath }}', id);
            @if($targetField)
                $wire.set('data.{{ $targetField }}', title);
            @endif
        }
    }"
    class="w-full"
>
    {{-- Section Header --}}
    @if($sectionTitle || $sectionSubtitle)
        <div class="mb-6 text-center">
            @if($sectionTitle)
                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    {{ $sectionTitle }}
                </h3>
            @endif
            @if($sectionSubtitle)
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ $sectionSubtitle }}
                </p>
            @endif
        </div>
    @endif

    @if(count($cards) > 0)
        {{-- Cards Grid --}}
        <div class="grid gap-4 sm:grid-cols-1 md:grid-cols-2 lg:grid-cols-3">
            @foreach($cards as $card)
                @php
                    $cardId = $card['id'] ?? null;
                    $cardTitle = $card['title'] ?? '';
                    $cardSubtitle = $card['subtitle'] ?? '';
                    $cardDescription = $card['description'] ?? '';
                    $cardMeta = $card['meta'] ?? '';
                    $cardExtra = $card['extra'] ?? '';
                @endphp
                
                <div 
                    x-bind:class="{
                        'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/20': selectedValue == {{ $cardId }},
                        'ring-1 ring-gray-200 dark:ring-gray-700 hover:ring-gray-300 dark:hover:ring-gray-600': selectedValue != {{ $cardId }}
                    }"
                    class="relative bg-white dark:bg-gray-800 rounded-lg shadow-sm border border-gray-200 dark:border-gray-700 p-4 cursor-pointer transition-all duration-200 hover:shadow-md"
                    @click="selectCard({{ $cardId }}, '{{ addslashes($cardTitle) }}')"
                >
                    {{-- Radio Button --}}
                    <div class="absolute top-4 right-4">
                        <div 
                            x-show="selectedValue == {{ $cardId }}"
                            class="w-5 h-5 bg-blue-500 rounded-full flex items-center justify-center"
                        >
                            <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                            </svg>
                        </div>
                        <div 
                            x-show="selectedValue != {{ $cardId }}"
                            class="w-5 h-5 border-2 border-gray-300 dark:border-gray-600 rounded-full"
                        ></div>
                    </div>

                    {{-- Card Content --}}
                    <div class="pr-8">
                        {{-- Title --}}
                        @if($cardTitle)
                            <h4 class="text-base font-semibold text-gray-900 dark:text-gray-100 mb-2">
                                {{ $cardTitle }}
                            </h4>
                        @endif

                        {{-- Subtitle --}}
                        @if($cardSubtitle)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-2">
                                {{ $cardSubtitle }}
                            </p>
                        @endif

                        {{-- Description --}}
                        @if($cardDescription)
                            <p class="text-xs text-gray-500 dark:text-gray-500 mb-3">
                                {{ $cardDescription }}
                            </p>
                        @endif

                        {{-- Meta Info --}}
                        @if($cardMeta || $cardExtra)
                            <div class="space-y-1">
                                @if($cardMeta)
                                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z"></path>
                                        </svg>
                                        {{ $cardMeta }}
                                    </div>
                                @endif
                                
                                @if($cardExtra)
                                    <div class="flex items-center text-xs text-gray-500 dark:text-gray-500">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                        </svg>
                                        {{ $cardExtra }}
                                    </div>
                                @endif
                            </div>
                        @endif
                    </div>

                    {{-- Selection Indicator --}}
                    <div 
                        x-show="selectedValue == {{ $cardId }}"
                        class="absolute inset-0 rounded-lg border-2 border-blue-500 pointer-events-none"
                    ></div>
                </div>
            @endforeach
        </div>
    @else
        {{-- Empty State --}}
        <div class="text-center py-12">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-gray-100">
                {{ $emptyStateTitle ?? 'Nessun elemento disponibile' }}
            </h3>
            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                {{ $emptyStateDescription ?? 'Non ci sono elementi da selezionare al momento.' }}
            </p>
        </div>
    @endif
</div>
