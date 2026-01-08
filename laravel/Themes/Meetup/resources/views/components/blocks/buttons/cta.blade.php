{{--
/**
 * CTA (Call to Action) Button Block - Bootstrap Italia to Tailwind
 * Enhanced button for primary actions with prominent styling
 * 
 * @props string $text - Button text content
 * @props string $icon - Icon name or SVG (optional)
 * @props string $iconPosition - Icon position (left, right)
 * @props string $size - Button size (xs, sm, md, lg, xl)
 * @props string $variant - Button variant (solid, outline, ghost, link)
 * @props string $color - Button color (primary, secondary, success, danger, warning, info)
 * @props bool $disabled - Disabled state
 * @props bool $loading - Loading state
 * @props string $href - Link URL (optional)
 * @props string $type - Button type (button, submit, reset)
 * @props bool $fullWidth - Full width button
 */
--}}

@props([
    'variant' => 'primary',
    'size' => 'md',
    'disabled' => false,
    'loading' => false,
    'type' => 'button',
    'href' => null,
    'target' => null,
    'icon' => null,
    'icon-position' => 'left',
    'active' => false,
    'vertical' => false,
])

@php
$baseClasses = 'inline-flex items-center justify-center font-bold rounded-xl transition-all duration-300 focus:ring-4 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed transform hover:scale-105 shadow-lg hover:shadow-xl';

$sizeClasses = [
    'xs' => 'px-4 py-2 text-sm',
    'sm' => 'px-6 py-3 text-base',
    'md' => 'px-8 py-4 text-lg',
    'lg' => 'px-10 py-5 text-xl',
    'xl' => 'px-12 py-6 text-2xl',
];

$colorClasses = [
    'primary' => [
        'solid' => 'bg-gradient-to-r from-blue-600 to-blue-700 text-white hover:from-blue-700 hover:to-blue-800 focus:ring-blue-500',
        'outline' => 'border-3 border-blue-600 text-blue-600 hover:bg-blue-600 hover:text-white focus:ring-blue-500',
        'ghost' => 'text-blue-600 hover:bg-blue-100 focus:ring-blue-500',
        'link' => 'text-blue-600 hover:text-blue-800 underline focus:ring-blue-500'
    ],
    'success' => [
        'solid' => 'bg-gradient-to-r from-green-600 to-green-700 text-white hover:from-green-700 hover:to-green-800 focus:ring-green-500',
        'outline' => 'border-3 border-green-600 text-green-600 hover:bg-green-600 hover:text-white focus:ring-green-500',
        'ghost' => 'text-green-600 hover:bg-green-100 focus:ring-green-500',
        'link' => 'text-green-600 hover:text-green-800 underline focus:ring-green-500'
    ],
    'danger' => [
        'solid' => 'bg-gradient-to-r from-red-600 to-red-700 text-white hover:from-red-700 hover:to-red-800 focus:ring-red-500',
        'outline' => 'border-3 border-red-600 text-red-600 hover:bg-red-600 hover:text-white focus:ring-red-500',
        'ghost' => 'text-red-600 hover:bg-red-100 focus:ring-red-500',
        'link' => 'text-red-600 hover:text-red-800 underline focus:ring-red-500'
    ]
];

$buttonClasses = collect([
    $baseClasses,
    $sizeClasses[$size] ?? $sizeClasses['lg'],
    $colorClasses[$color][$variant] ?? $colorClasses['primary']['solid'],
    $fullWidth ? 'w-full' : '',
    $loading ? 'cursor-wait' : ''
])->filter()->implode(' ');
@endphp

@if($href && !$disabled)
    <a href="{{ $href }}" class="{{ $buttonClasses }}" {{ $attributes }}>
@else
    <button 
        type="{{ $type }}" 
        class="{{ $buttonClasses }}"
        @if($disabled || $loading) disabled @endif
        {{ $attributes }}
    >
@endif

    @if($loading)
        <svg class="animate-spin -ml-1 mr-3 h-6 w-6" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Caricamento...</span>
    @else
        @if($icon && $iconPosition === 'left')
            <span class="mr-3 text-2xl">{!! $icon !!}</span>
        @endif
        
        @if($text)
            <span class="tracking-wide">{{ $text }}</span>
        @else
            {{ $slot }}
        @endif
        
        @if($icon && $iconPosition === 'right')
            <span class="ml-3 text-xl transform group-hover:translate-x-1 transition-transform">{!! $icon !!}</span>
        @endif
    @endif

@if($href && !$disabled)
    </a>
@else
    </button>
@endif
