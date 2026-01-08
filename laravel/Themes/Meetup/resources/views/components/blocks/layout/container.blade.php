@props([
    'fluid' => false,
    'max-width' => null,
    'padding' => true,
    'cols' => 1,
    'gap' => 'md',
    'responsive' => true,
])

@php
    $maxWidths = [
        'sm' => 'max-w-screen-sm',
        'md' => 'max-w-screen-md',
        'lg' => 'max-w-screen-lg',
        'xl' => 'max-w-screen-xl',
        '2xl' => 'max-w-screen-2xl',
        'full' => 'max-w-full'
    ];

    $maxWidthClass = $maxWidth ? ($maxWidths[$max-width] ?? 'max-w-7xl') : 'max-w-7xl';
    $fluidClass = $fluid ? 'w-full' : "mx-auto {$maxWidthClass}";
    $paddingClass = $padding ? 'px-4 sm:px-6 lg:px-8' : '';
@endphp

<div {{ $attributes->merge(['class' => "{$fluidClass} {$paddingClass}"]) }}>
    {{ $slot }}
</div> 