{{--
/**
 * Basic Alert Block - Bootstrap Italia to Tailwind
 * 
 * @props string $title - Alert title
 * @props string $message - Alert message content
 * @props string $type - Alert type (info, success, warning, danger)
 * @props string $size - Alert size (sm, md, lg)
 * @props bool $dismissible - Show dismiss button
 * @props bool $icon - Show type icon
 * @props string $iconCustom - Custom icon SVG (optional)
 * @props bool $border - Show border
 * @props bool $rounded - Rounded corners
 * @props string $position - Position (static, fixed-top, fixed-bottom)
 */
--}}

@props([
    'variant' => 'info',
    'dismissible' => false,
    'icon' => null,
    'title' => null,
    'role' => 'alert',
    'href' => null,
    'link-text' => null,
    'position' => null,
    'duration' => null,
])

@php
$baseClasses = 'flex items-start p-4 transition-all duration-200';

$typeClasses = [
    'info' => 'bg-blue-50 border-blue-200 text-blue-800',
    'success' => 'bg-green-50 border-green-200 text-green-800',
    'warning' => 'bg-yellow-50 border-yellow-200 text-yellow-800',
    'danger' => 'bg-red-50 border-red-200 text-red-800'
];

$sizeClasses = [
    'sm' => 'text-sm p-3',
    'md' => 'text-base p-4',
    'lg' => 'text-lg p-6'
];

$positionClasses = [
    'static' => '',
    'fixed-top' => 'fixed top-4 left-4 right-4 z-50',
    'fixed-bottom' => 'fixed bottom-4 left-4 right-4 z-50'
];

$icons = [
    'info' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>',
    'success' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>',
    'warning' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>',
    'danger' => '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>'
];

$alertClasses = collect([
    $baseClasses,
    $typeClasses[$type] ?? $typeClasses['info'],
    $sizeClasses[$size] ?? $sizeClasses['md'],
    $positionClasses[$position] ?? '',
    $border ? 'border' : '',
    $rounded ? 'rounded-lg' : ''
])->filter()->implode(' ');
@endphp

<div class="{{ $alertClasses }}" role="alert" {{ $attributes }}>
    @if($icon || $iconCustom)
        <div class="flex-shrink-0 mr-3">
            @if($iconCustom)
                {!! $iconCustom !!}
            @else
                {!! $icons[$type] ?? $icons['info'] !!}
            @endif
        </div>
    @endif
    
    <div class="flex-1">
        @if($title)
            <h4 class="font-semibold mb-1">{{ $title }}</h4>
        @endif
        
        @if($message)
            <div class="leading-relaxed">
                {!! $message !!}
            </div>
        @else
            {{ $slot }}
        @endif
    </div>
    
    @if($dismissible)
        <button 
            type="button" 
            class="flex-shrink-0 ml-3 -mr-1 p-1 rounded-md hover:bg-black/10 transition-colors"
            onclick="this.parentElement.remove()"
        >
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path>
            </svg>
        </button>
    @endif
</div>
