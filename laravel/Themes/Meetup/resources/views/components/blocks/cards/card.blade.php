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
    $variants = [
        'default' => [
            'bg' => 'bg-white',
            'border' => 'border-gray-200',
            'shadow' => 'shadow-sm'
        ],
        'elevated' => [
            'bg' => 'bg-white',
            'border' => 'border-gray-200',
            'shadow' => 'shadow-lg'
        ],
        'bordered' => [
            'bg' => 'bg-white',
            'border' => 'border-2 border-gray-200',
            'shadow' => ''
        ]
    ];

    $variantClasses = $variants[$variant] ?? $variants['default'];
    
    if ($elevated) {
        $variantClasses['shadow'] = 'shadow-lg';
    }
    
    if (!$bordered) {
        $variantClasses['border'] = '';
    }
    
    $classes = "rounded-lg overflow-hidden {$variantClasses['bg']} {$variantClasses['border']} {$variantClasses['shadow']}";
@endphp

<div {{ $attributes->merge(['class' => $classes]) }}>
    @if($with-image && $image-src)
        <div class="relative">
            <img 
                src="{{ $image-src }}" 
                alt="{{ $image-alt ?? 'Card image' }}"
                class="w-full h-48 object-cover"
            >
        </div>
    @endif

    @if($with-header)
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            {{ $header ?? '' }}
        </div>
    @endif

    <div class="px-6 py-4">
        {{ $slot }}
    </div>

    @if($with-footer)
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50">
            {{ $footer ?? '' }}
        </div>
    @endif
</div> 