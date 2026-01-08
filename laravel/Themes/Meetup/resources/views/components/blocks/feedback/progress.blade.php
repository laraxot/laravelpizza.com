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
        'primary' => 'bg-blue-600',
        'secondary' => 'bg-gray-600',
        'success' => 'bg-green-600',
        'danger' => 'bg-red-600',
        'warning' => 'bg-yellow-600',
        'info' => 'bg-blue-400'
    ];

    $sizes = [
        'xs' => 'h-1',
        'sm' => 'h-2',
        'md' => 'h-4',
        'lg' => 'h-6',
        'xl' => 'h-8'
    ];

    $variantClass = $variants[$variant] ?? $variants['primary'];
    $sizeClass = $sizes[$size] ?? $sizes['md'];
    $percentage = min(100, max(0, ($value / $max) * 100));
    
    $progressClasses = "{$variantClass} {$sizeClass} rounded-full transition-all duration-300";
    
    if ($animated) {
        $progressClasses .= ' animate-pulse';
    }
    
    if ($striped) {
        $progressClasses .= ' bg-gradient-to-r from-transparent via-white to-transparent bg-[length:20px_100%] animate-pulse';
    }
@endphp

<div class="space-y-2">
    @if($label || $show-percentage)
        <div class="flex justify-between items-center">
            @if($label)
                <span class="text-sm font-medium text-gray-700">{{ $label }}</span>
            @endif
            
            @if($show-percentage)
                <span class="text-sm text-gray-500">{{ round($percentage) }}%</span>
            @endif
        </div>
    @endif

    <div class="w-full bg-gray-200 rounded-full overflow-hidden">
        <div 
            class="{{ $progressClasses }}"
            style="width: {{ $percentage }}%"
            role="progressbar"
            aria-valuenow="{{ $value }}"
            aria-valuemin="0"
            aria-valuemax="{{ $max }}"
            aria-label="{{ $label ?? 'Progresso' }}"
        ></div>
    </div>
</div> 