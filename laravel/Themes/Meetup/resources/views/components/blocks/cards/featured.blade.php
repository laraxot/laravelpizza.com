{{--
/**
 * Featured Card Block - Bootstrap Italia to Tailwind
 * Enhanced card with prominent styling for featured content
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
$baseClasses = 'bg-gradient-to-br rounded-xl overflow-hidden transition-all duration-300';

$variantClasses = [
    'default' => 'from-gray-50 to-gray-100 text-gray-900',
    'primary' => 'from-blue-50 to-blue-100 border-2 border-blue-200',
    'secondary' => 'from-gray-50 to-gray-100 border-2 border-gray-200',
    'success' => 'from-green-50 to-green-100 border-2 border-green-200',
    'danger' => 'from-red-50 to-red-100 border-2 border-red-200',
    'warning' => 'from-yellow-50 to-yellow-100 border-2 border-yellow-200',
    'info' => 'from-cyan-50 to-cyan-100 border-2 border-cyan-200',
];

$sizeClasses = [
    'sm' => 'p-6',
    'md' => 'p-8',
    'lg' => 'p-10',
];

$shadowClass = $shadow ? 'shadow-xl hover:shadow-2xl' : '';
$borderClass = $border ? 'border-2 border-gray-200' : '';

$cardClasses = collect([
    $baseClasses,
    $variantClasses[$variant] ?? $variantClasses['primary'],
    $shadowClass,
    $borderClass
])->filter()->implode(' ');

$contentClasses = $sizeClasses[$size] ?? $sizeClasses['lg'];
@endphp

@if($link)
    <a href="{{ $link }}" class="{{ $cardClasses }} hover:scale-[1.03] cursor-pointer transform">
@else
    <div class="{{ $cardClasses }}">
@endif

    @if($image)
        <div class="relative mb-6">
            <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-64 object-cover rounded-lg">
            <div class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent rounded-lg"></div>
        </div>
    @endif
    
    <div class="{{ $contentClasses }}">
        @if($title)
            <h2 class="text-2xl font-bold text-gray-900 mb-4 leading-tight">{{ $title }}</h2>
        @endif
        
        @if($subtitle)
            <p class="text-lg text-gray-600 mb-6 font-medium">{{ $subtitle }}</p>
        @endif
        
        @if($content)
            <div class="text-gray-700 leading-relaxed text-lg mb-6">
                {!! $content !!}
            </div>
        @endif
        
        {{ $slot }}
    </div>
    
    @if($footer)
        <div class="px-10 py-6 bg-white/50 backdrop-blur-sm border-t border-gray-200/50">
            <div class="text-gray-700 font-medium">
                {!! $footer !!}
            </div>
        </div>
    @endif

@if($link)
    </a>
@else
    </div>
@endif
