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
    $overlayPositions = [
        'bottom' => 'bottom-0 left-0 right-0',
        'center' => 'inset-0 flex items-center justify-center',
        'top' => 'top-0 left-0 right-0'
    ];

    $overlayVariants = [
        'dark' => [
            'bg' => 'bg-black bg-opacity-75',
            'text' => 'text-white'
        ],
        'light' => [
            'bg' => 'bg-white bg-opacity-90',
            'text' => 'text-gray-900'
        ]
    ];

    $positionClasses = $overlayPositions[$overlay-position] ?? $overlayPositions['bottom'];
    $variantClasses = $overlayVariants[$overlay-variant] ?? $overlayVariants['dark'];
@endphp

<div {{ $attributes->merge(['class' => 'relative rounded-lg overflow-hidden']) }}>
    <img 
        src="{{ $image-src }}" 
        alt="{{ $image-alt ?? 'Card image' }}"
        class="w-full h-64 object-cover"
    >
    
    <div class="absolute {{ $positionClasses }} p-6 {{ $variantClasses['bg'] }}">
        @if($overlay-title)
            <h3 class="text-xl font-semibold mb-2 {{ $variantClasses['text'] }}">
                {{ $overlay-title }}
            </h3>
        @endif
        
        @if($overlay-subtitle)
            <p class="text-sm {{ $variantClasses['text'] }} opacity-90 mb-4">
                {{ $overlay-subtitle }}
            </p>
        @endif
        
        <div class="{{ $variantClasses['text'] }}">
            {{ $slot }}
        </div>
    </div>
</div> 