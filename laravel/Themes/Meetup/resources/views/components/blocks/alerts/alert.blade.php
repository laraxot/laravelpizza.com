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
            'icon' => 'heroicon-o-information-circle',
            'icon-color' => 'text-blue-400'
        ],
        'success' => [
            'bg' => 'bg-green-50',
            'border' => 'border-green-200',
            'text' => 'text-green-800',
            'icon' => 'heroicon-o-check-circle',
            'icon-color' => 'text-green-400'
        ],
        'warning' => [
            'bg' => 'bg-yellow-50',
            'border' => 'border-yellow-200',
            'text' => 'text-yellow-800',
            'icon' => 'heroicon-o-exclamation-triangle',
            'icon-color' => 'text-yellow-400'
        ],
        'error' => [
            'bg' => 'bg-red-50',
            'border' => 'border-red-200',
            'text' => 'text-red-800',
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
        'role' => $role,
        'aria-live' => 'polite'
    ]) }}
    x-data="{ show: true }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
>
    <div class="flex items-start">
        @if($iconName)
            <div class="flex-shrink-0">
                <x-filament::icon 
                    :name="$iconName" 
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
            </div>
        </div>

        @if($dismissible)
            <div class="flex-shrink-0 ml-3">
                <button
                    type="button"
                    class="inline-flex {$variantClasses['text']} hover:{$variantClasses['bg']} focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500"
                    @click="show = false"
                    aria-label="{{ __('sixteen::alerts.dismiss') }}"
                >
                    <x-filament::icon name="heroicon-o-x-mark" class="h-4 w-4" />
                </button>
            </div>
        @endif
    </div>
</div> 