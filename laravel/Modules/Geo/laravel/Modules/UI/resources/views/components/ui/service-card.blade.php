<?php

declare(strict_types=1);

?>
{{--
    Service Card Component - Card servizio riutilizzabile per servizi comunali/aziendali
    
    Props:
    - $title: string - Titolo del servizio
    - $description: string - Descrizione del servizio
    - $icon: string - Nome icona Heroicon (es: 'heroicon-o-document-text')
    - $url: string - URL del servizio
    - $category: string - Categoria per styling (anagrafe, tributi, urbanistica, sociale, ambiente)
    - $status: string - Stato del servizio (active, inactive, maintenance)
    - $requiresAuth: bool - Richiede autenticazione
    - $badge: string|null - Badge opzionale (es: "Nuovo", "Urgente")
    
    Utilizzo:
    <x-ui.service-card
        title="Certificati Anagrafici"
        description="Richiedi e scarica certificati online"
        icon="heroicon-o-document-text"
        url="/servizi/anagrafe/certificati"
        category="anagrafe"
        status="active"
        :requiresAuth="true"
        badge="Nuovo"
    />
--}}

@props([
    'title' => '',
    'description' => '',
    'icon' => 'heroicon-o-document',
    'url' => '#',
    'category' => 'default',
    'status' => 'active',
    'requiresAuth' => false,
    'badge' => null,
])

@php
    // Mappatura colori per categoria (AGID/PA compliance)
    $categoryColors = match($category) {
        'anagrafe' => [
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-700',
            'border' => 'border-blue-500',
            'icon' => 'text-blue-600',
        ],
        'tributi' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-700',
            'border' => 'border-green-500',
            'icon' => 'text-green-600',
        ],
        'urbanistica' => [
            'bg' => 'bg-orange-100',
            'text' => 'text-orange-700',
            'border' => 'border-orange-500',
            'icon' => 'text-orange-600',
        ],
        'sociale' => [
            'bg' => 'bg-purple-100',
            'text' => 'text-purple-700',
            'border' => 'border-purple-500',
            'icon' => 'text-purple-600',
        ],
        'ambiente' => [
            'bg' => 'bg-emerald-100',
            'text' => 'text-emerald-700',
            'border' => 'border-emerald-500',
            'icon' => 'text-emerald-600',
        ],
        default => [
            'bg' => 'bg-gray-100',
            'text' => 'text-gray-700',
            'border' => 'border-gray-500',
            'icon' => 'text-gray-600',
        ],
    };
    
    // Stili per stato
    $isActive = $status === 'active';
    $statusColors = match($status) {
        'active' => 'bg-green-100 text-green-700',
        'inactive' => 'bg-gray-100 text-gray-500',
        'maintenance' => 'bg-yellow-100 text-yellow-700',
        default => 'bg-gray-100 text-gray-500',
    };
@endphp

<article 
    @class([
        'bg-white border rounded-lg shadow-sm hover:shadow-md transition-all duration-200 overflow-hidden group',
        'border-l-4',
        $categoryColors['border'],
        'opacity-60 pointer-events-none' => !$isActive,
    ])
>
    <a 
        href="{{ $isActive ? $url : '#' }}"
        @class([
            'block p-5',
            'cursor-not-allowed' => !$isActive,
        ])
        @if(!$isActive) 
            aria-disabled="true" 
            tabindex="-1"
        @endif
    >
        {{-- Header con icona e badge --}}
        <div class="flex items-start justify-between mb-3">
            <div @class([
                'p-2 rounded-lg',
                $categoryColors['bg'],
            ])>
                @if(str_starts_with($icon, 'heroicon-'))
                    <x-dynamic-component 
                        :component="$icon" 
                        @class(['w-6 h-6', $categoryColors['icon']])
                    />
                @else
                    <x-heroicon-o-document @class(['w-6 h-6', $categoryColors['icon']]) />
                @endif
            </div>
            
            {{-- Badges --}}
            <div class="flex items-center gap-2">
                @if($badge)
                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-primary-100 text-primary-700">
                        {{ $badge }}
                    </span>
                @endif
                
                @if($requiresAuth)
                    <span 
                        class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-50 text-blue-600"
                        title="Richiede autenticazione SPID/CIE"
                    >
                        <x-heroicon-m-lock-closed class="w-3 h-3 mr-1" />
                        Auth
                    </span>
                @endif
                
                @if(!$isActive)
                    <span @class([
                        'inline-flex items-center px-2 py-1 rounded-full text-xs font-medium',
                        $statusColors,
                    ])>
                        {{ $status === 'maintenance' ? 'Manutenzione' : 'Non attivo' }}
                    </span>
                @endif
            </div>
        </div>
        
        {{-- Titolo --}}
        <h3 class="text-lg font-semibold text-gray-900 mb-2 group-hover:text-primary-600 transition-colors">
            {{ $title }}
        </h3>
        
        {{-- Descrizione --}}
        @if($description)
            <p class="text-sm text-gray-600 line-clamp-2 mb-4">
                {{ $description }}
            </p>
        @endif
        
        {{-- Footer con categoria e freccia --}}
        <div class="flex items-center justify-between pt-3 border-t border-gray-100">
            <span @class([
                'inline-flex items-center px-2 py-1 rounded text-xs font-medium capitalize',
                $categoryColors['bg'],
                $categoryColors['text'],
            ])>
                {{ $category }}
            </span>
            
            @if($isActive)
                <span class="text-sm text-primary-600 font-medium flex items-center group-hover:translate-x-1 transition-transform">
                    Vai al servizio
                    <x-heroicon-m-arrow-right class="w-4 h-4 ml-1" />
                </span>
            @endif
        </div>
    </a>
</article>
