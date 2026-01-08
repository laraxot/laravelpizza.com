@props([
    'variant' => 'primary',
    'size' => 'md',
    'pill' => false,
    'dismissible' => false,
    'content' => null,
    'position' => 'top',
    'trigger' => 'hover',
    'delay' => 0,
])

@php
    $positions = [
        'top' => 'bottom-full left-1/2 transform -translate-x-1/2 mb-2',
        'bottom' => 'top-full left-1/2 transform -translate-x-1/2 mt-2',
        'left' => 'right-full top-1/2 transform -translate-y-1/2 mr-2',
        'right' => 'left-full top-1/2 transform -translate-y-1/2 ml-2'
    ];

    $variants = [
        'dark' => 'bg-gray-900 text-white',
        'light' => 'bg-white text-gray-900 border border-gray-200'
    ];

    $positionClass = $positions[$position] ?? $positions['top'];
    $variantClass = $variants[$variant] ?? $variants['dark'];
@endphp

<div 
    class="relative inline-block"
    x-data="{ 
        show: false,
        init() {
            if ('{{ $trigger }}' === 'hover') {
                this.$el.addEventListener('mouseenter', () => {
                    setTimeout(() => this.show = true, {{ $delay }});
                });
                this.$el.addEventListener('mouseleave', () => {
                    this.show = false;
                });
            } else if ('{{ $trigger }}' === 'click') {
                this.$el.addEventListener('click', () => {
                    this.show = !this.show;
                });
            }
        }
    }"
>
    {{ $slot }}
    
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute z-50 px-3 py-2 text-sm font-medium rounded-lg shadow-lg {{ $positionClass }} {{ $variantClass }} whitespace-nowrap"
        role="tooltip"
        aria-hidden="true"
    >
        {{ $content }}
        
        <!-- Arrow -->
        @if($position === 'top')
            <div class="absolute top-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-t-4 border-transparent border-t-gray-900"></div>
        @elseif($position === 'bottom')
            <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 w-0 h-0 border-l-4 border-r-4 border-b-4 border-transparent border-b-gray-900"></div>
        @elseif($position === 'left')
            <div class="absolute left-full top-1/2 transform -translate-y-1/2 w-0 h-0 border-t-4 border-b-4 border-l-4 border-transparent border-l-gray-900"></div>
        @elseif($position === 'right')
            <div class="absolute right-full top-1/2 transform -translate-y-1/2 w-0 h-0 border-t-4 border-b-4 border-r-4 border-transparent border-r-gray-900"></div>
        @endif
    </div>
</div> 