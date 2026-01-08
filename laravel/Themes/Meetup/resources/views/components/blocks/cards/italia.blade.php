{{-- Bootstrap Italia Card Component --}}
@props([
    'title' => null,
    'subtitle' => null,
    'header' => null,
    'footer' => null,
    'image' => null,
    'imageAlt' => '',
    'imagePosition' => 'top', // top, bottom
    'shadow' => 'md', // none, sm, md, lg
    'hover' => false,
    'clickable' => false,
    'href' => null
])

@php
$cardClasses = 'card-italia';

$shadowClasses = match($shadow) {
    'none' => 'shadow-none',
    'sm' => 'shadow-sm',
    'lg' => 'shadow-lg',
    default => 'shadow-md',
};

if ($hover) {
    $shadowClasses .= ' hover:shadow-lg transition-shadow duration-200';
}

$cardClasses .= ' ' . $shadowClasses;

$wrapperTag = ($clickable && $href) ? 'a' : 'div';
@endphp

<{{ $wrapperTag }} 
    @if($clickable && $href) 
        href="{{ $href }}" 
        class="block no-underline hover:no-underline" 
    @endif
    {{ $attributes->merge(['class' => $cardClasses]) }}>
    
    {{-- Image Top --}}
    @if($image && $imagePosition === 'top')
    <div class="overflow-hidden rounded-t-lg">
        <img src="{{ $image }}" 
             alt="{{ $imageAlt }}" 
             class="w-full h-48 object-cover {{ $hover ? 'hover:scale-105 transition-transform duration-200' : '' }}">
    </div>
    @endif
    
    {{-- Custom Header --}}
    @if($header)
    <div class="card-header-italia">
        {{ $header }}
    </div>
    @endif
    
    {{-- Card Body --}}
    <div class="card-body-italia">
        @if($title || $subtitle)
        <div class="mb-4">
            @if($title)
            <h3 class="text-lg font-semibold text-italia-gray-900 mb-2">
                {{ $title }}
            </h3>
            @endif
            
            @if($subtitle)
            <p class="text-sm text-italia-gray-600 mb-0">
                {{ $subtitle }}
            </p>
            @endif
        </div>
        @endif
        
        <div class="text-italia-gray-700">
            {{ $slot }}
        </div>
    </div>
    
    {{-- Image Bottom --}}
    @if($image && $imagePosition === 'bottom')
    <div class="overflow-hidden rounded-b-lg">
        <img src="{{ $image }}" 
             alt="{{ $imageAlt }}" 
             class="w-full h-48 object-cover {{ $hover ? 'hover:scale-105 transition-transform duration-200' : '' }}">
    </div>
    @endif
    
    {{-- Custom Footer --}}
    @if($footer)
    <div class="card-footer-italia">
        {{ $footer }}
    </div>
    @endif
</{{ $wrapperTag }}>