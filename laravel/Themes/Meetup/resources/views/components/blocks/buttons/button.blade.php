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
    $variants = [
        'primary' => [
            'bg' => 'bg-blue-600',
            'hover' => 'hover:bg-blue-700',
            'focus' => 'focus:ring-blue-500',
            'text' => 'text-white',
            'border' => ''
        ],
        'secondary' => [
            'bg' => 'bg-gray-600',
            'hover' => 'hover:bg-gray-700',
            'focus' => 'focus:ring-gray-500',
            'text' => 'text-white',
            'border' => ''
        ],
        'outline' => [
            'bg' => 'bg-transparent',
            'hover' => 'hover:bg-blue-50',
            'focus' => 'focus:ring-blue-500',
            'text' => 'text-blue-600',
            'border' => 'border-2 border-blue-600'
        ],
        'ghost' => [
            'bg' => 'bg-transparent',
            'hover' => 'hover:bg-gray-100',
            'focus' => 'focus:ring-gray-500',
            'text' => 'text-gray-700',
            'border' => ''
        ],
        'danger' => [
            'bg' => 'bg-red-600',
            'hover' => 'hover:bg-red-700',
            'focus' => 'focus:ring-red-500',
            'text' => 'text-white',
            'border' => ''
        ]
    ];

    $sizes = [
        'xs' => 'px-2 py-1 text-xs',
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base',
        'xl' => 'px-8 py-4 text-lg'
    ];

    $variantClasses = $variants[$variant] ?? $variants['primary'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    
    $baseClasses = "inline-flex items-center justify-center font-medium rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-offset-2 {$sizeClasses}";
    $variantClassString = "{$variantClasses['bg']} {$variantClasses['hover']} {$variantClasses['focus']} {$variantClasses['text']} {$variantClasses['border']}";
    
    if ($disabled) {
        $variantClassString .= ' opacity-50 cursor-not-allowed';
    }
    
    if ($loading) {
        $variantClassString .= ' cursor-wait';
    }
    
    $classes = "{$baseClasses} {$variantClassString}";
@endphp

@if($href)
    <a 
        href="{{ $href }}"
        @if($target) target="{{ $target }}" @endif
        {{ $attributes->merge(['class' => $classes]) }}
        @if($disabled) aria-disabled="true" @endif
    >
        @if($loading)
            <x-heroicon-o-arrow-path class="animate-spin h-4 w-4 mr-2" />
        @elseif($icon && $icon-position === 'left')
            <x-dynamic-component :component="$icon" class="h-4 w-4 mr-2" />
        @endif
        
        {{ $slot }}
        
        @if($icon && $icon-position === 'right')
            <x-dynamic-component :component="$icon" class="h-4 w-4 ml-2" />
        @endif
    </a>
@else
    <button 
        type="{{ $type }}"
        {{ $attributes->merge(['class' => $classes]) }}
        @if($disabled) disabled @endif
    >
        @if($loading)
            <x-heroicon-o-arrow-path class="animate-spin h-4 w-4 mr-2" />
        @elseif($icon && $icon-position === 'left')
            <x-dynamic-component :component="$icon" class="h-4 w-4 mr-2" />
        @endif
        
        {{ $slot }}
        
        @if($icon && $icon-position === 'right')
            <x-dynamic-component :component="$icon" class="h-4 w-4 ml-2" />
        @endif
    </button>
@endif 