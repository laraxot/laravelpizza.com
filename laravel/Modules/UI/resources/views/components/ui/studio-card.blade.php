<?php

declare(strict_types=1);

?>
{{--
    Studio Card Component - Visualizzazione informazioni studio odontoiatrico
    
    Props:
    - $studio: Model Studio con dati dello studio
    - $showDistance: bool - Mostra la distanza
    - $showRating: bool - Mostra il rating
    - $showServices: bool - Mostra i servizi
    - $actions: array - Azioni disponibili ['book', 'details', 'contact']
    - $selectable: bool - Rende la card selezionabile
    - $selected: bool - Stato di selezione
    - $wireClick: string - Azione Livewire al click
--}}

@props([
    'studio',
    'showDistance' => false,
    'showRating' => false, 
    'showServices' => false,
    'actions' => ['book'],
    'selectable' => false,
    'selected' => false,
    'wireClick' => null,
    'distance' => null,
    'rating' => null,
])

<div 
    @class([
        'bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200',
        'cursor-pointer hover:border-primary-300' => $selectable,
        'border-primary-500 bg-primary-50' => $selected,
        'border-gray-200' => !$selected,
    ])
    @if($wireClick && $selectable)
        wire:click="{{ $wireClick }}"
    @endif
>
    <!-- Header Studio -->
    <div class="p-4 border-b border-gray-100">
        <div class="flex items-start justify-between">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-900">
                    {{ $studio->name }}
                </h3>
                
                @if($studio->description)
                    <p class="text-sm text-gray-600 mt-1 line-clamp-2">
                        {{ Str::limit($studio->description, 100) }}
                    </p>
                @endif
            </div>

            @if($selectable && $selected)
                <div class="ml-3 flex-shrink-0">
                    <x-filament::icon
                        name="heroicon-o-check-circle"
                        class="w-6 h-6 text-primary-600"
                    />
                </div>
            @endif
        </div>

        <!-- Rating e Distanza -->
        @if($showRating || $showDistance)
            <div class="flex items-center gap-4 mt-3">
                @if($showRating && $rating)
                    <div class="flex items-center gap-1">
                        @for($i = 1; $i <= 5; $i++)
                            <x-filament::icon
                                name="heroicon-s-star"
                                @class([
                                    'w-4 h-4',
                                    'text-yellow-400' => $i <= $rating,
                                    'text-gray-300' => $i > $rating,
                                ])
                            />
                        @endfor
                        <span class="text-sm text-gray-600 ml-1">
                            ({{ $rating }}/5)
                        </span>
                    </div>
                @endif

                @if($showDistance && $distance)
                    <div class="flex items-center gap-1 text-sm text-gray-600">
                        <x-filament::icon
                            name="heroicon-o-map-pin"
                            class="w-4 h-4"
                        />
                        <span>{{ number_format($distance, 1) }} km</span>
                    </div>
                @endif
            </div>
        @endif
    </div>

    <!-- Informazioni Studio -->
    <div class="p-4 space-y-3">
        <!-- Indirizzo -->
        @if($studio->addresses && $studio->addresses->count() > 0)
            @php
                $address = $studio->addresses->first();
            @endphp
            <div class="flex items-start gap-2">
                <x-filament::icon
                    name="heroicon-o-map-pin"
                    class="w-4 h-4 text-gray-400 mt-0.5 flex-shrink-0"
                />
                <div class="text-sm text-gray-600">
                    <div>{{ $address->street ?? 'Indirizzo non disponibile' }}</div>
                    <div>{{ $address->postal_code }} {{ $address->city }}</div>
                </div>
            </div>
        @endif

        <!-- Contatti -->
        <div class="space-y-2">
            @if($studio->phone)
                <div class="flex items-center gap-2">
                    <x-filament::icon
                        name="heroicon-o-phone"
                        class="w-4 h-4 text-gray-400 flex-shrink-0"
                    />
                    <a 
                        href="tel:{{ $studio->phone }}"
                        class="text-sm text-primary-600 hover:text-primary-800"
                    >
                        {{ $studio->phone }}
                    </a>
                </div>
            @endif

            @if($studio->email)
                <div class="flex items-center gap-2">
                    <x-filament::icon
                        name="heroicon-o-envelope"
                        class="w-4 h-4 text-gray-400 flex-shrink-0"
                    />
                    <a 
                        href="mailto:{{ $studio->email }}"
                        class="text-sm text-primary-600 hover:text-primary-800"
                    >
                        {{ $studio->email }}
                    </a>
                </div>
            @endif

            @if($studio->website)
                <div class="flex items-center gap-2">
                    <x-filament::icon
                        name="heroicon-o-globe-alt"
                        class="w-4 h-4 text-gray-400 flex-shrink-0"
                    />
                    <a 
                        href="{{ $studio->website }}"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="text-sm text-primary-600 hover:text-primary-800"
                    >
                        Visita sito
                    </a>
                </div>
            @endif
        </div>

        <!-- Servizi -->
        @if($showServices && $studio->services && count($studio->services) > 0)
            <div class="space-y-2">
                <h4 class="text-sm font-medium text-gray-900">Servizi offerti</h4>
                <div class="flex flex-wrap gap-1">
                    @foreach(array_slice($studio->services, 0, 3) as $service)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            {{ $service }}
                        </span>
                    @endforeach
                    @if(count($studio->services) > 3)
                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">
                            +{{ count($studio->services) - 3 }} altri
                        </span>
                    @endif
                </div>
            </div>
        @endif

        <!-- Orari Apertura (sintesi) -->
        @if($studio->opening_hours)
            @php
                $today = now()->format('l'); // es: Monday
                $todayHours = $studio->opening_hours[$today] ?? null;
            @endphp
            @if($todayHours && !empty($todayHours['open']) && !empty($todayHours['close']))
                <div class="flex items-center gap-2 text-sm text-gray-600">
                    <x-filament::icon
                        name="heroicon-o-clock"
                        class="w-4 h-4 text-gray-400"
                    />
                    <span>Oggi: {{ $todayHours['open'] }} - {{ $todayHours['close'] }}</span>
                </div>
            @else
                <div class="flex items-center gap-2 text-sm text-gray-500">
                    <x-filament::icon
                        name="heroicon-o-clock"
                        class="w-4 h-4 text-gray-400"
                    />
                    <span>Oggi: Chiuso</span>
                </div>
            @endif
        @endif
    </div>

    <!-- Actions Footer -->
    @if(count($actions) > 0)
        <div class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex gap-2 justify-end">
            @foreach($actions as $action)
                @switch($action)
                    @case('book')
                        <x-filament::button
                            color="primary"
                            size="sm"
                            wire:click="selectStudio({{ $studio->id }})"
                        >
                            <x-filament::icon
                                name="heroicon-o-calendar-days"
                                class="w-4 h-4 mr-1"
                            />
                            Prenota
                        </x-filament::button>
                        @break

                    @case('details')
                        <x-filament::button
                            color="gray"
                            variant="outlined"
                            size="sm"
                        >
                            <x-filament::icon
                                name="heroicon-o-information-circle"
                                class="w-4 h-4 mr-1"
                            />
                            Dettagli
                        </x-filament::button>
                        @break

                    @case('contact')
                        @if($studio->phone)
                            <x-filament::button
                                color="gray"
                                variant="outlined"
                                size="sm"
                                tag="a"
                                :href="'tel:' . $studio->phone"
                            >
                                <x-filament::icon
                                    name="heroicon-o-phone"
                                    class="w-4 h-4 mr-1"
                                />
                                Chiama
                            </x-filament::button>
                        @endif
                        @break
                @endswitch
            @endforeach
        </div>
    @endif
</div>
