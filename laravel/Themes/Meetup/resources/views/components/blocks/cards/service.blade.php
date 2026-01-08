{{--
/**
 * Service Card Block - Bootstrap Italia to Tailwind
 * Card optimized for displaying PA services
 * 
 * @props string $title - Card title
 * @props string $subtitle - Card subtitle (optional)
 * @props string $content - Card main content
 * @props string $image - Card image URL (optional)
 * @props string $footer - Card footer content (optional)
 * @props string $variant - Card style variant (default, primary, secondary, success, danger, warning, info)
 * @props string $size - Card size (sm, md, lg)
 * @props bool $shadow - Enable shadow
 * @props bool $border - Enable border
 * @props string $link - Card link URL (optional)
 */
--}}

@props([
    'variant' => 'default',
    'with-header' => false,
    'with-footer' => false,
    'with-image' => false,
    'image-src' => null,
    'image-alt' => null,
    'elevated' => false,
    'bordered' => true,
    'overlay-title' => null,
    'overlay-subtitle' => null,
    'overlay-position' => 'bottom',
    'overlay-variant' => 'dark',
])

@php
$baseClasses = 'bg-white rounded-lg overflow-hidden transition-all duration-200 hover:shadow-lg';

$variantClasses = [
    'default' => 'text-gray-900',
    'primary' => 'border-t-4 border-blue-600',
    'secondary' => 'border-t-4 border-gray-600',
    'success' => 'border-t-4 border-green-600',
    'danger' => 'border-t-4 border-red-600',
    'warning' => 'border-t-4 border-yellow-600',
    'info' => 'border-t-4 border-cyan-600',
];

$sizeClasses = [
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
];

$shadowClass = $shadow ? 'shadow-md' : '';
$borderClass = $border ? 'border border-gray-200' : '';

$cardClasses = collect([
    $baseClasses,
    $variantClasses[$variant] ?? $variantClasses['default'],
    $shadowClass,
    $borderClass
])->filter()->implode(' ');

$contentClasses = $sizeClasses[$size] ?? $sizeClasses['md'];
@endphp

@if($link)
    <a href="{{ $link }}" class="{{ $cardClasses }} hover:scale-[1.01] cursor-pointer group">
@else
    <div class="{{ $cardClasses }}">
@endif

    @if($image)
        <div class="h-32 bg-gradient-to-r from-blue-500 to-blue-600 flex items-center justify-center">
            <img src="{{ $image }}" alt="{{ $title }}" class="h-16 w-16 object-contain filter brightness-0 invert">
        </div>
    @endif
    
    <div class="{{ $contentClasses }}">
        @if($title)
            <h3 class="text-xl font-semibold text-gray-900 mb-3 group-hover:text-blue-600 transition-colors">{{ $title }}</h3>
        @endif
        
        @if($subtitle)
            <p class="text-sm text-blue-600 font-medium mb-3 uppercase tracking-wide">{{ $subtitle }}</p>
        @endif
        
        @if($content)
            <div class="text-gray-700 leading-relaxed mb-4">
                {!! $content !!}
            </div>
        @endif
        
        {{ $slot }}
        
        @if($link)
            <div class="flex items-center text-blue-600 font-medium text-sm mt-4 group-hover:text-blue-800 transition-colors">
                <span>Accedi al servizio</span>
                <svg class="w-4 h-4 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </div>
        @endif
    </div>
    
    @if($footer)
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            <div class="text-sm text-gray-600">
                {!! $footer !!}
            </div>
        </div>
    @endif

@if($link)
    </a>
@else
    </div>
@endif
