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
    $sizes = [
        'xs' => 'text-xs',
        'sm' => 'text-sm',
        'md' => 'text-sm',
        'lg' => 'text-base',
        'xl' => 'text-lg'
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    $orientationClasses = $vertical ? 'flex-col' : 'flex-row';
@endphp

<div 
    {{ $attributes->merge([
        'class' => "inline-flex {$orientationClasses} rounded-lg shadow-sm {$sizeClasses}",
        'role' => 'group'
    ]) }}
>
    {{ $slot }}
</div> 