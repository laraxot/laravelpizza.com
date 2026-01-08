{{--
/**
 * Header Slim Block - AGID Compliant
 * Slim header with institutional information
 * 
 * @props string $variant - Header variant (default, primary, secondary)
 * @props string $ente-name - Name of the institution
 * @props string $ente-url - URL to institution website
 * @props bool $show-links - Show additional links
 * @props string $position - Position (static, fixed-top)
 * @props string $background - Background color variant
 */
--}}

@props([
    'variant' => 'default',
    'enteName' => 'Ente di appartenenza',
    'enteUrl' => '#',
    'showLinks' => true,
    'position' => 'static',
    'background' => 'primary'
])

@php
$baseClasses = 'py-2 text-white text-sm';

$backgroundClasses = [
    'primary' => 'bg-blue-600',
    'secondary' => 'bg-gray-600',
    'dark' => 'bg-gray-900'
];

$positionClasses = [
    'static' => '',
    'fixed-top' => 'fixed top-0 left-0 right-0 z-50'
];

$headerClasses = collect([
    $baseClasses,
    $backgroundClasses[$background] ?? $backgroundClasses['primary'],
    $positionClasses[$position] ?? ''
])->filter()->implode(' ');
@endphp

<div class="{{ $headerClasses }}" role="banner">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center">
            <div class="flex items-center space-x-4">
                @if($showLinks)
                    <span class="hidden md:inline">{{ $enteName }}</span>
                    <span class="md:hidden">{{ Str::limit($enteName, 20) }}</span>
                @endif
            </div>
            
            <div class="flex items-center space-x-4">
                @if($enteUrl && $enteUrl !== '#')
                    <a href="{{ $enteUrl }}" 
                       class="hover:underline transition-colors"
                       title="Vai al sito dell'ente"
                       target="_blank"
                       rel="noopener noreferrer">
                        <span class="hidden sm:inline">Vai al sito dell'ente</span>
                        <span class="sm:hidden">Sito ente</span>
                    </a>
                @endif
                
                {{ $slot }}
            </div>
        </div>
    </div>
</div>
