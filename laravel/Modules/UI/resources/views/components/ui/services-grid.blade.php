<?php

declare(strict_types=1);

?>
{{--
    Services Grid Component - Griglia di servizi comunali/aziendali
    
    Props:
    - $services: array - Array di servizi con chiavi: title, description, icon, url, category, status, requiresAuth
    - $columns: int - Numero di colonne (1, 2, 3, 4)
    - $gap: string - Gap tra le cards (sm, md, lg)
    
    Utilizzo:
    <x-ui.services-grid 
        :services="[
            ['title' => 'Servizio 1', 'description' => 'Descrizione', 'category' => 'anagrafe', 'status' => 'active'],
            ['title' => 'Servizio 2', 'description' => 'Descrizione', 'category' => 'tributi', 'status' => 'active'],
        ]"
        :columns="2"
        gap="md"
    />
--}}

@props([
    'services' => [],
    'columns' => 3,
    'gap' => 'md',
])

@php
    $gridCols = match($columns) {
        1 => 'grid-cols-1',
        2 => 'grid-cols-1 md:grid-cols-2',
        3 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
        4 => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-4',
        default => 'grid-cols-1 md:grid-cols-2 lg:grid-cols-3',
    };
    
    $gapSize = match($gap) {
        'sm' => 'gap-4',
        'md' => 'gap-6',
        'lg' => 'gap-8',
        default => 'gap-6',
    };
@endphp

@if(count($services) > 0)
    <div @class(['grid', $gridCols, $gapSize])>
        @foreach($services as $service)
            <x-ui.service-card
                :title="$service['title'] ?? 'Servizio'"
                :description="$service['description'] ?? ''"
                :icon="$service['icon'] ?? 'heroicon-o-document'"
                :url="$service['url'] ?? '#'"
                :category="$service['category'] ?? 'default'"
                :status="$service['status'] ?? 'active'"
                :requiresAuth="$service['requiresAuth'] ?? false"
                :badge="$service['badge'] ?? null"
            />
        @endforeach
    </div>
@else
    {{-- Empty State --}}
    <div class="text-center py-12 bg-gray-50 rounded-lg border-2 border-dashed border-gray-300">
        <x-heroicon-o-document-magnifying-glass class="w-12 h-12 text-gray-400 mx-auto mb-4" />
        <h3 class="text-lg font-medium text-gray-900 mb-2">Nessun servizio disponibile</h3>
        <p class="text-sm text-gray-600">Non sono presenti servizi in questa categoria.</p>
    </div>
@endif
