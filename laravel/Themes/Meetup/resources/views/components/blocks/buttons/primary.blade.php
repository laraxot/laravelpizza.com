{{--
/**
 * Primary Button Block - Bootstrap Italia to Tailwind
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
$baseClasses = 'inline-flex items-center justify-center font-semibold rounded-lg transition-all duration-200 focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

$sizeClasses = [
    'xs' => 'px-2.5 py-1.5 text-xs',
    'sm' => 'px-3 py-2 text-sm',
    'md' => 'px-4 py-2.5 text-sm',
    'lg' => 'px-6 py-3 text-base',
    'xl' => 'px-8 py-4 text-lg',
];

$colorClasses = [
    'primary' => [
        'solid' => 'bg-blue-600 text-white hover:bg-blue-700 focus:ring-blue-500',
        'outline' => 'border-2 border-blue-600 text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
        'ghost' => 'text-blue-600 hover:bg-blue-50 focus:ring-blue-500',
        'link' => 'text-blue-600 hover:text-blue-800 underline focus:ring-blue-500'
    ],
    'secondary' => [
        'solid' => 'bg-gray-600 text-white hover:bg-gray-700 focus:ring-gray-500',
        'outline' => 'border-2 border-gray-600 text-gray-600 hover:bg-gray-50 focus:ring-gray-500',
        'ghost' => 'text-gray-600 hover:bg-gray-50 focus:ring-gray-500',
        'link' => 'text-gray-600 hover:text-gray-800 underline focus:ring-gray-500'
    ],
    'success' => [
        'solid' => 'bg-green-600 text-white hover:bg-green-700 focus:ring-green-500',
        'outline' => 'border-2 border-green-600 text-green-600 hover:bg-green-50 focus:ring-green-500',
        'ghost' => 'text-green-600 hover:bg-green-50 focus:ring-green-500',
        'link' => 'text-green-600 hover:text-green-800 underline focus:ring-green-500'
    ],
    'danger' => [
        'solid' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-500',
        'outline' => 'border-2 border-red-600 text-red-600 hover:bg-red-50 focus:ring-red-500',
        'ghost' => 'text-red-600 hover:bg-red-50 focus:ring-red-500',
        'link' => 'text-red-600 hover:text-red-800 underline focus:ring-red-500'
    ],
    'warning' => [
        'solid' => 'bg-yellow-600 text-white hover:bg-yellow-700 focus:ring-yellow-500',
        'outline' => 'border-2 border-yellow-600 text-yellow-600 hover:bg-yellow-50 focus:ring-yellow-500',
        'ghost' => 'text-yellow-600 hover:bg-yellow-50 focus:ring-yellow-500',
        'link' => 'text-yellow-600 hover:text-yellow-800 underline focus:ring-yellow-500'
    ],
    'info' => [
        'solid' => 'bg-cyan-600 text-white hover:bg-cyan-700 focus:ring-cyan-500',
        'outline' => 'border-2 border-cyan-600 text-cyan-600 hover:bg-cyan-50 focus:ring-cyan-500',
        'ghost' => 'text-cyan-600 hover:bg-cyan-50 focus:ring-cyan-500',
        'link' => 'text-cyan-600 hover:text-cyan-800 underline focus:ring-cyan-500'
    ]
];

$buttonClasses = collect([
    $baseClasses,
    $sizeClasses[$size] ?? $sizeClasses['md'],
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
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span>Caricamento...</span>
    @else
        @if($icon && $iconPosition === 'left')
            <span class="mr-2">{!! $icon !!}</span>
        @endif
        
        @if($text)
            <span>{{ $text }}</span>
        @else
            {{ $slot }}
        @endif
        
        @if($icon && $iconPosition === 'right')
            <span class="ml-2">{!! $icon !!}</span>
        @endif
    @endif

@if($href && !$disabled)
    </a>
@else
    </button>
@endif
