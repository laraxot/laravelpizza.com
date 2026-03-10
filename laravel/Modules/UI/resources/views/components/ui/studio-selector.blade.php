<?php

declare(strict_types=1);

?>
{{--
    Studio Selector Component - Selezione semplice studio con pulsanti
    
    Props:
    - $studios: Collection di studi
    - $selectedStudio: ID dello studio selezionato
    - $targetField: Nome del campo da popolare (default: 'selected_studio')
    - $wireModel: Wire model per il binding
--}}

@props([
    'studios',
    'selectedStudio' => null,
    'targetField' => 'selected_studio',
    'wireModel' => null,
])

<div class="space-y-4">
    {{-- Header con conteggio --}}
    @if($studios->count() > 0)
        <div class="text-sm text-gray-600 mb-4">
            {{ trans_choice('Trovato :count studio|Trovati :count studi', $studios->count(), ['count' => $studios->count()]) }}
        </div>
    @endif

    {{-- Lista pulsanti studi --}}
    <div class="space-y-3">
        @forelse($studios as $studio)
            <div 
                @class([
                    'border rounded-lg p-4 transition-all duration-200 cursor-pointer',
                    'border-primary-500 bg-primary-50' => $selectedStudio == $studio->id,
                    'border-gray-200 hover:border-gray-300 hover:bg-gray-50' => $selectedStudio != $studio->id,
                ])
                wire:click="selectStudio({{ $studio->id }})"
            >
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            {{-- Radio indicator --}}
                            <div @class([
                                'w-4 h-4 rounded-full border-2 flex items-center justify-center',
                                'border-primary-500 bg-primary-500' => $selectedStudio == $studio->id,
                                'border-gray-300' => $selectedStudio != $studio->id,
                            ])>
                                @if($selectedStudio == $studio->id)
                                    <div class="w-2 h-2 bg-white rounded-full"></div>
                                @endif
                            </div>

                            {{-- Nome Studio --}}
                            <h3 @class([
                                'font-medium',
                                'text-primary-700' => $selectedStudio == $studio->id,
                                'text-gray-900' => $selectedStudio != $studio->id,
                            ])>
                                {{ $studio->name }}
                            </h3>
                        </div>

                        {{-- Indirizzo --}}
                        @if($studio->addresses && $studio->addresses->count() > 0)
                            @php
                                $address = $studio->addresses->first();
                            @endphp
                            <div class="mt-2 ml-7 text-sm text-gray-600">
                                <div>{{ $address->street ?? 'Indirizzo non disponibile' }}</div>
                                <div>{{ $address->postal_code }} {{ $address->city }}</div>
                            </div>
                        @endif

                        {{-- Info aggiuntive compatte --}}
                        <div class="mt-2 ml-7 flex items-center gap-4 text-xs text-gray-500">
                            @if($studio->phone)
                                <div class="flex items-center gap-1">
                                    <x-filament::icon name="heroicon-o-phone" class="w-3 h-3" />
                                    <span>{{ $studio->phone }}</span>
                                </div>
                            @endif

                            @if($studio->services && count($studio->services) > 0)
                                <div class="flex items-center gap-1">
                                    <x-filament::icon name="heroicon-o-wrench-screwdriver" class="w-3 h-3" />
                                    <span>{{ count($studio->services) }} servizi</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Icona selezionato --}}
                    @if($selectedStudio == $studio->id)
                        <div class="flex-shrink-0">
                            <x-filament::icon
                                name="heroicon-o-check-circle"
                                class="w-5 h-5 text-primary-600"
                            />
                        </div>
                    @endif
                </div>
            </div>
        @empty
            {{-- Empty state --}}
            <div class="text-center py-8 border border-dashed border-gray-300 rounded-lg">
                <x-filament::icon
                    name="heroicon-o-building-office"
                    class="w-12 h-12 text-gray-400 mx-auto mb-4"
                />
                <h3 class="text-lg font-medium text-gray-900 mb-2">
                    Nessuno studio trovato
                </h3>
                <p class="text-gray-600">
                    Non ci sono studi disponibili nell'area selezionata.
                </p>
            </div>
        @endforelse
    </div>

    {{-- Selected studio info (hidden input viene gestito dal parent) --}}
    @if($selectedStudio && $studios->where('id', $selectedStudio)->first())
        @php
            $studio = $studios->where('id', $selectedStudio)->first();
        @endphp
        <div class="mt-4 p-3 bg-primary-50 border border-primary-200 rounded-lg">
            <div class="flex items-center gap-2 text-sm">
                <x-filament::icon
                    name="heroicon-o-check-circle"
                    class="w-4 h-4 text-primary-600"
                />
                <span class="text-primary-700 font-medium">
                    Studio selezionato: {{ $studio->name }}
                </span>
            </div>
        </div>
    @endif
</div>
