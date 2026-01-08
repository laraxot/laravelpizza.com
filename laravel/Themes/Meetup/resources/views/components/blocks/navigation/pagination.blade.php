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
    $sizes = [
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-6 py-3 text-base'
    ];

    $sizeClasses = $sizes[$size] ?? $sizes['md'];
    
    // Calculate visible pages
    $start = max(1, $current-page - floor($max-visible / 2));
    $end = min($total-pages, $start + $max-visible - 1);
    
    if ($end - $start + 1 < $max-visible) {
        $start = max(1, $end - $max-visible + 1);
    }
@endphp

<nav 
    {{ $attributes->merge([
        'class' => 'flex items-center justify-center',
        'role' => 'navigation',
        'aria-label' => 'Paginazione'
    ]) }}
>
    <ul class="flex items-center space-x-1">
        @if($show-first-last && $current-page > 1)
            <li>
                <a 
                    href="{{ $base-url }}?page=1" 
                    class="{$sizeClasses} text-gray-500 bg-white border border-gray-300 rounded-l-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    aria-label="Prima pagina"
                >
                    <x-heroicon-o-chevron-double-left class="h-4 w-4" />
                </a>
            </li>
        @endif

        @if($show-prev-next && $current-page > 1)
            <li>
                <a 
                    href="{{ $base-url }}?page={{ $current-page - 1 }}" 
                    class="{$sizeClasses} text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    aria-label="Pagina precedente"
                >
                    <x-heroicon-o-chevron-left class="h-4 w-4" />
                </a>
            </li>
        @endif

        @for($i = $start; $i <= $end; $i++)
            <li>
                @if($i == $current-page)
                    <span 
                        class="{$sizeClasses} text-blue-600 bg-blue-50 border border-blue-300 font-medium"
                        aria-current="page"
                    >
                        {{ $i }}
                    </span>
                @else
                    <a 
                        href="{{ $base-url }}?page={{ $i }}" 
                        class="{$sizeClasses} text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    >
                        {{ $i }}
                    </a>
                @endif
            </li>
        @endfor

        @if($show-prev-next && $current-page < $total-pages)
            <li>
                <a 
                    href="{{ $base-url }}?page={{ $current-page + 1 }}" 
                    class="{$sizeClasses} text-gray-500 bg-white border border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    aria-label="Pagina successiva"
                >
                    <x-heroicon-o-chevron-right class="h-4 w-4" />
                </a>
            </li>
        @endif

        @if($show-first-last && $current-page < $total-pages)
            <li>
                <a 
                    href="{{ $base-url }}?page={{ $total-pages }}" 
                    class="{$sizeClasses} text-gray-500 bg-white border border-gray-300 rounded-r-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2"
                    aria-label="Ultima pagina"
                >
                    <x-heroicon-o-chevron-double-right class="h-4 w-4" />
                </a>
            </li>
        @endif
    </ul>
</nav> 