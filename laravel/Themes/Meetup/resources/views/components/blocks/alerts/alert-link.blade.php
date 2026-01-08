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
    $variants = [
        'info' => [
            'bg' => 'bg-blue-50',
            'border' => 'border-blue-200',
            'text' => 'text-blue-800',
            'link' => 'text-blue-600 hover:text-blue-800',
            'icon' => 'heroicon-o-information-circle',
            'icon-color' => 'text-blue-400'
        ],
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-200',
            'text' => 'text-green-800',
            'link' => 'text-green-600 hover:text-green-800',
            'icon' => 'heroicon-o-check-circle',
            'icon-color' => 'text-green-400'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-200',
            'text' => 'text-yellow-800',
            'link' => 'text-yellow-600 hover:text-yellow-800',
            'icon' => 'heroicon-o-exclamation-triangle',
            'icon-color' => 'text-yellow-400'
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'text' => 'text-red-800',
            'link' => 'text-red-600 hover:text-red-800',
            'icon' => 'heroicon-o-x-circle',
            'icon-color' => 'text-red-400'
        ]
    ];

    $variantClasses = $variants[$variant] ?? $variants['info'];
    $iconName = $icon ?? $variantClasses['icon'];
@endphp

<div 
    {{ $attributes->merge([
        'class' => "relative p-4 border-l-4 {$variantClasses['bg']} {$variantClasses['border']} {$variantClasses['text']}",
        'role' => $role
    ]) }}
>
    <div class="flex items-start">
        @if($iconName)
            <div class="flex-shrink-0">
                <x-dynamic-component 
                    :component="$iconName" 
                    class="h-5 w-5 {$variantClasses['icon-color']}"
                    aria-hidden="true"
                />
            </div>
        @endif

        <div class="flex-1 ml-3">
            @if($title)
                <h3 class="text-sm font-medium mb-1">
                    {{ $title }}
                </h3>
            @endif
            
            <div class="text-sm">
                {{ $slot }}
                
                @if($link-text)
                    <a 
                        href="{{ $href }}" 
                        class="inline-flex items-center ml-1 font-medium {$variantClasses['link']} underline focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    >
                        {{ $link-text }}
                        <x-heroicon-o-arrow-right class="ml-1 h-3 w-3" />
                    </a>
                @endif
            </div>
        </div>
    </div>
</div> 