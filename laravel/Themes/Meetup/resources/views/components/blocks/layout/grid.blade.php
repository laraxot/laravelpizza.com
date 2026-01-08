@props([
    'fluid' => false,
    'max-width' => null,
    'padding' => true,
    'cols' => 1,
    'gap' => 'md',
    'responsive' => true,
])

@php
    $gaps = [
        'xs' => 'gap-1',
        'sm' => 'gap-2',
        'md' => 'gap-4',
        'lg' => 'gap-6',
        'xl' => 'gap-8'
    ];

    $gapClass = $gaps[$gap] ?? $gaps['md'];
    
    $gridCols = [
        1 => 'grid-cols-1',
        2 => 'grid-cols-2',
        3 => 'grid-cols-3',
        4 => 'grid-cols-4',
        5 => 'grid-cols-5',
        6 => 'grid-cols-6',
        12 => 'grid-cols-12'
    ];
    
    $gridClass = $gridCols[$cols] ?? 'grid-cols-1';
    
    if ($responsive) {
        $gridClass .= ' sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4';
    }
@endphp

<div {{ $attributes->merge(['class' => "grid {$gridClass} {$gapClass}"]) }}>
    {{ $slot }}
</div> 