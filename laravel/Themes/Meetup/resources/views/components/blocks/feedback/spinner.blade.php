@props([
    'value' => 0,
    'max' => 100,
    'variant' => 'primary',
    'size' => 'md',
    'animated' => false,
    'striped' => false,
    'label' => null,
    'show-percentage' => false,
])

@php
    $variants = [
        'primary' => 'text-blue-600',
        'secondary' => 'text-gray-600',
        'success' => 'text-green-600',
        'danger' => 'text-red-600',
        'warning' => 'text-yellow-600',
        'info' => 'text-blue-400'
    ];

    $sizes = [
        'xs' => 'h-4 w-4',
        'sm' => 'h-6 w-6',
        'md' => 'h-8 w-8',
        'lg' => 'h-12 w-12',
        'xl' => 'h-16 w-16'
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
@endphp

<div {{ $attributes->merge(['class' => 'flex items-center justify-center']) }}>
    <div class="flex items-center space-x-2">
        <svg 
            class="animate-spin {$sizeClass} {$variantClass}" 
            xmlns="http://www.w3.org/2000/svg" 
            fill="none" 
            viewBox="0 0 24 24"
            role="status"
            aria-label="{{ $label }}"
        >
            <circle 
                class="opacity-25" 
                cx="12" 
                cy="12" 
                r="10" 
                stroke="currentColor" 
                stroke-width="4"
            ></circle>
            <path 
                class="opacity-75" 
                fill="currentColor" 
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
            ></path>
        </svg>
        
        @if($label)
            <span class="text-sm text-gray-600">{{ $label }}</span>
        @endif
    </div>
</div> 