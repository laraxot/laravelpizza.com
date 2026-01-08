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
            'bg' => 'bg-blue-600',
            'text' => 'text-white',
            'icon' => 'heroicon-o-information-circle',
            'icon-color' => 'text-blue-200'
        ],
        'success' => [
            'bg' => 'bg-green-600',
            'text' => 'text-white',
            'icon' => 'heroicon-o-check-circle',
            'icon-color' => 'text-green-200'
        ],
        'warning' => [
            'bg' => 'bg-yellow-600',
            'text' => 'text-white',
            'icon' => 'heroicon-o-exclamation-triangle',
            'icon-color' => 'text-yellow-200'
        ],
        'error' => [
            'bg' => 'bg-red-600',
            'text' => 'text-white',
            'icon' => 'heroicon-o-x-circle',
            'icon-color' => 'text-red-200'
        ]
    ];

    $positions = [
        'top-right' => 'top-4 right-4',
        'top-left' => 'top-4 left-4',
        'bottom-right' => 'bottom-4 right-4',
        'bottom-left' => 'bottom-4 left-4',
        'top-center' => 'top-4 left-1/2 transform -translate-x-1/2',
        'bottom-center' => 'bottom-4 left-1/2 transform -translate-x-1/2'
    ];

    $variantClasses = $variants[$variant] ?? $variants['info'];
    $positionClasses = $positions[$position] ?? $positions['top-right'];
    $iconName = $icon ?? $variantClasses['icon'];
@endphp

<div 
    {{ $attributes->merge([
        'class' => "fixed z-50 {$positionClasses} max-w-sm w-full {$variantClasses['bg']} {$variantClasses['text']} rounded-lg shadow-lg",
        'role' => $role,
        'aria-live' => 'assertive',
        'aria-atomic' => 'true'
    ]) }}
    x-data="{ 
        show: true,
        init() {
            if ({{ $duration }} > 0) {
                setTimeout(() => this.show = false, {{ $duration }});
            }
        }
    }"
    x-show="show"
    x-transition:enter="transition ease-out duration-300"
    x-transition:enter-start="opacity-0 transform scale-95"
    x-transition:enter-end="opacity-100 transform scale-100"
    x-transition:leave="transition ease-in duration-200"
    x-transition:leave-start="opacity-100 transform scale-100"
    x-transition:leave-end="opacity-0 transform scale-95"
>
    <div class="p-4">
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
                        class="inline-flex {$variantClasses['text']} hover:opacity-75 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-white"
                        @click="show = false"
                        aria-label="{{ __('sixteen::alerts.dismiss') }}"
                    >
                        <x-filament::icon name="heroicon-o-x-mark" class="h-4 w-4" />
                    </button>
                </div>
            @endif
        </div>
    </div>
</div> 