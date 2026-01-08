{{--
/**
 * Basic Card Block - Bootstrap Italia to Tailwind
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
$baseClasses = 'bg-white rounded-lg overflow-hidden transition-all duration-200';

$variantClasses = [
    'default' => 'text-gray-900',
    'primary' => 'border-l-4 border-blue-600',
    'secondary' => 'border-l-4 border-gray-600',
    'success' => 'border-l-4 border-green-600',
    'danger' => 'border-l-4 border-red-600',
    'warning' => 'border-l-4 border-yellow-600',
    'info' => 'border-l-4 border-cyan-600',
];

$sizeClasses = [
    'sm' => 'p-4',
    'md' => 'p-6',
    'lg' => 'p-8',
];

$shadowClass = $shadow ? 'shadow-md hover:shadow-lg' : '';
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
    <a href="{{ $link }}" class="{{ $cardClasses }} hover:scale-[1.02] cursor-pointer">
@else
    <div class="{{ $cardClasses }}">
@endif

    @if($image)
        <div class="aspect-w-16 aspect-h-9">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
        </div>
    @endif
    
    <div class="{{ $contentClasses }}">
        @if($title)
            <h3 class="text-lg font-semibold text-gray-900 mb-2">{{ $title }}</h3>
        @endif
        
        @if($subtitle)
            <p class="text-sm text-gray-600 mb-3">{{ $subtitle }}</p>
        @endif
        
        @if($content)
            <div class="text-gray-700 leading-relaxed">
                {!! $content !!}
            </div>
        @endif
        
        {{ $slot }}
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
