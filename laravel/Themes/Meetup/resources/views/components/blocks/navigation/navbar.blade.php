@props([
    'brand' => null,
    'brand-href' => '/',
    'variant' => 'light',
    'sticky' => false,
    'expand' => 'lg',
    'container' => true,
    'items' => [],
    'separator' => '/',
    'aria-label' => 'Breadcrumb',
    'current-page' => 1,
    'total-pages' => 1,
    'base-url' => null,
    'size' => 'md',
    'show-first-last' => true,
    'show-prev-next' => true,
    'max-visible' => 5,
])

@php
    $variants = [
        'light' => [
            'bg' => 'bg-white',
            'text' => 'text-gray-900',
            'border' => 'border-gray-200',
            'hover' => 'hover:text-blue-600'
        ],
        'dark' => [
            'bg' => 'bg-gray-900',
            'text' => 'text-white',
            'border' => 'border-gray-700',
            'hover' => 'hover:text-blue-400'
        ]
    ];

    $variantClasses = $variants[$variant] ?? $variants['light'];
    $stickyClasses = $sticky ? 'sticky top-0 z-50' : '';
    $containerClasses = $container ? 'container mx-auto px-4' : '';
@endphp

<nav 
    {{ $attributes->merge([
        'class' => "{$variantClasses['bg']} {$variantClasses['border']} border-b shadow-sm {$stickyClasses}",
        'role' => 'navigation',
        'aria-label' => 'Navigazione principale'
    ]) }}
>
    <div class="{{ $containerClasses }}">
        <div class="flex items-center justify-between h-16">
            <!-- Brand -->
            @if($brand)
                <div class="flex-shrink-0">
                    <a 
                        href="{{ $brand-href }}" 
                        class="text-xl font-bold {$variantClasses['text']} {$variantClasses['hover']} transition-colors"
                    >
                        {{ $brand }}
                    </a>
                </div>
            @endif

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex lg:items-center lg:space-x-8">
                {{ $slot }}
            </div>

            <!-- Mobile menu button -->
            <div class="lg:hidden">
                <button
                    type="button"
                    class="inline-flex items-center justify-center p-2 rounded-md {$variantClasses['text']} {$variantClasses['hover']} focus:outline-none focus:ring-2 focus:ring-inset focus:ring-blue-500"
                    aria-controls="mobile-menu"
                    aria-expanded="false"
                    x-data="{ open: false }"
                    @click="open = !open"
                >
                    <span class="sr-only">Apri menu principale</span>
                    <x-heroicon-o-bars-3 class="h-6 w-6" />
                </button>
            </div>
        </div>

        <!-- Mobile Navigation -->
        <div 
            class="lg:hidden"
            x-data="{ open: false }"
            x-show="open"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0 -translate-y-1"
            x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100 translate-y-0"
            x-transition:leave-end="opacity-0 -translate-y-1"
            id="mobile-menu"
            role="menu"
        >
            <div class="px-2 pt-2 pb-3 space-y-1 border-t {{ $variantClasses['border'] }}">
                {{ $mobile ?? $slot }}
            </div>
        </div>
    </div>
</nav> 