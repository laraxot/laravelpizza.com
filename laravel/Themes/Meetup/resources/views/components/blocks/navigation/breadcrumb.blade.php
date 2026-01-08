{{--
/**
 * Breadcrumb AGID Block - AGID Compliant
 * Navigation breadcrumb for institutional pages
 * 
 * @props string $variant - Breadcrumb variant (default, minimal, expanded)
 * @props array $items - Breadcrumb items array
 * @props string $current-page - Current page title
 * @props string $home-url - Home page URL
 * @props string $separator - Separator character
 * @props bool $show-home - Show home link
 * @props string $background - Background variant
 */
--}}

@props([
    'variant' => 'default',
    'items' => [],
    'currentPage' => 'Pagina corrente',
    'homeUrl' => '/',
    'separator' => '/',
    'showHome' => true,
    'background' => 'light'
])

@php
$baseClasses = 'py-3 border-b border-gray-200';

$backgroundClasses = [
    'light' => 'bg-gray-50',
    'white' => 'bg-white',
    'transparent' => 'bg-transparent'
];

$breadcrumbClasses = collect([
    $baseClasses,
    $backgroundClasses[$background] ?? $backgroundClasses['light']
])->filter()->implode(' ');
@endphp

<nav class="{{ $breadcrumbClasses }}" aria-label="Percorso di navigazione" role="navigation">
    <div class="container mx-auto px-4">
        <ol class="flex items-center space-x-2 text-sm">
            @if($showHome)
                <li>
                    <a href="{{ $homeUrl }}" 
                       class="text-blue-600 hover:text-blue-800 transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded px-1"
                       aria-label="Torna alla home">
                        <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Home
                    </a>
                </li>
                @if(count($items) > 0 || $currentPage)
                    <li class="text-gray-400" aria-hidden="true">{{ $separator }}</li>
                @endif
            @endif
            
            @foreach($items as $index => $item)
                <li>
                    @if(isset($item['url']) && $item['url'])
                        <a href="{{ $item['url'] }}" 
                           class="text-blue-600 hover:text-blue-800 transition-colors focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded px-1">
                            {{ $item['title'] ?? $item['text'] ?? $item['label'] ?? 'Item' }}
                        </a>
                    @else
                        <span class="text-gray-700">{{ $item['title'] ?? $item['text'] ?? $item['label'] ?? 'Item' }}</span>
                    @endif
                </li>
                @if($index < count($items) - 1 || $currentPage)
                    <li class="text-gray-400" aria-hidden="true">{{ $separator }}</li>
                @endif
            @endforeach
            
            @if($currentPage)
                <li class="text-gray-700 font-medium" aria-current="page">
                    {{ $currentPage }}
                </li>
            @endif
        </ol>
    </div>
</nav>
