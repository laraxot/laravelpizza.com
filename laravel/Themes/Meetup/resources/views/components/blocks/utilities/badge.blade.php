@props([
    'variant' => 'primary',
    'size' => 'md',
    'pill' => false,
    'dismissible' => false,
    'content' => null,
    'position' => 'top',
    'trigger' => 'hover',
    'delay' => 0
])

@php
    $variants = [
        'primary' => [
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-800',
            'hover' => 'hover:bg-blue-200'
        ],
        'secondary' => [
            'bg' => 'bg-gray-100',
            'text' => 'text-gray-800',
            'hover' => 'hover:bg-gray-200'
        ],
        'success' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
            'hover' => 'hover:bg-green-200'
        ],
        'warning' => [
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-800',
            'hover' => 'hover:bg-yellow-200'
        ],
        'danger' => [
            'bg' => 'bg-red-100',
            'text' => 'text-red-800',
            'hover' => 'hover:bg-red-200'
        ],
        'info' => [
            'bg' => 'bg-blue-100',
            'text' => 'text-blue-800',
            'hover' => 'hover:bg-blue-200'
        ]
    ];

    $sizes = [
        'xs' => 'px-2 py-0.5 text-xs',
        'sm' => 'px-2.5 py-0.5 text-sm',
        'md' => 'px-3 py-1 text-sm',
        'lg' => 'px-4 py-1.5 text-base',
        'xl' => 'px-5 py-2 text-lg'
    ];

    $variantClasses = $variants[$variant] ?? $variants['primary'];
    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $pillClasses = $pill ? 'rounded-full' : 'rounded-md';
@endphp

<span 
    {{ $attributes->merge([
        'class' => "inline-flex items-center font-medium {$variantClasses['bg']} {$variantClasses['text']} {$sizeClasses} {$pillClasses} {$variantClasses['hover']}"
    ]) }}
>
    {{ $slot }}
    
    @if($dismissible)
        <button
            type="button"
            class="ml-1.5 -mr-1 h-4 w-4 rounded-full inline-flex items-center justify-center {$variantClasses['text']} hover:bg-white hover:bg-opacity-20 focus:outline-none focus:bg-white focus:bg-opacity-20"
            aria-label="{{ __('sixteen::badges.dismiss') }}"
        >
            <x-filament::icon name="heroicon-o-x-mark" class="h-3 w-3" />
        </button>
    @endif
</span> 