{{--
/**
 * Header Main Block - Laravel Pizza Meetups
 * Main navigation header with dark theme and red accents
 * 
 * @props string $variant - Header variant (default, primary, secondary)
 * @props string $logoSrc - Logo image source
 * @props string $logoAlt - Logo alt text
 * @props string $brand - Brand name
 * @props string $tagline - Service tagline
 * @props string $homeUrl - Home page URL
 * @props bool $showNavigation - Show main navigation
 * @props array $items - Navigation items
 * @props string $position - Position (static, sticky)
 */
--}}

@props([
    'variant' => 'default',
    'logoSrc' => '/images/pizza-icon.png',
    'logoAlt' => 'Laravel Pizza Meetups Logo',
    'brand' => 'Laravel Pizza Meetups',
    'tagline' => 'Laravel Developers. Pizza. Community.',
    'homeUrl' => '/',
    'showNavigation' => false,
    'items' => [],
    'position' => 'sticky'
])

@php
$baseClasses = 'bg-slate-900/80 backdrop-blur-md border-b border-slate-700 py-4';

$positionClasses = [
    'static' => '',
    'sticky' => 'sticky top-0 z-50'
];

$headerClasses = collect([
    $baseClasses,
    $positionClasses[$position] ?? ''
])->filter()->implode(' ');
@endphp

<div class="{{ $headerClasses }}">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ $homeUrl }}" class="flex items-center space-x-4 group">
                    @if($logoSrc)
                        <img src="{{ $logoSrc }}" 
                             alt="{{ $logoAlt }}" 
                             class="h-10 w-10 transition-transform group-hover:scale-110">
                    @endif
                    
                    <div>
                        <h1 class="text-xl font-bold text-white group-hover:text-red-500 transition-colors">
                            {{ $brand }}
                        </h1>
                        @if($tagline)
                            <p class="text-slate-400 text-xs hidden md:block">{{ $tagline }}</p>
                        @endif
                    </div>
                </a>
            </div>
            
            @if($showNavigation || !empty($items))
                <nav role="navigation" aria-label="Main navigation" class="hidden md:flex items-center space-x-6">
                    @foreach($items as $item)
                        @if($item['type'] === 'button')
                            <a 
                                href="{{ $item['url'] }}" 
                                class="{{ $item['style'] === 'outline' ? 'border border-red-600 text-red-500 hover:bg-red-600 hover:text-white' : 'bg-red-600 text-white hover:bg-red-700' }} px-4 py-2 rounded-md text-sm font-medium transition-colors duration-300"
                            >
                                {{ $item['label'] }}
                            </a>
                        @else
                            <a 
                                href="{{ $item['url'] }}" 
                                class="text-slate-300 hover:text-white hover:text-red-400 transition-colors duration-300 text-sm font-medium"
                            >
                                {{ $item['label'] }}
                            </a>
                        @endif
                    @endforeach
                </nav>
            @endif
            
            <!-- Mobile menu button -->
            <div class="md:hidden">
                <button 
                    x-data="{ mobileMenuOpen: false }"
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    class="text-slate-300 hover:text-white focus:outline-none"
                >
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
        
        <!-- Mobile menu -->
        <div x-data="{ mobileMenuOpen: false }" x-show="mobileMenuOpen" class="md:hidden mt-4 pb-4">
            <div class="flex flex-col space-y-3">
                @foreach($items as $item)
                    @if($item['type'] === 'button')
                        <a 
                            href="{{ $item['url'] }}" 
                            class="{{ $item['style'] === 'outline' ? 'border border-red-600 text-red-500 hover:bg-red-600 hover:text-white' : 'bg-red-600 text-white hover:bg-red-700' }} px-4 py-2 rounded-md text-sm font-medium text-center transition-colors duration-300"
                        >
                            {{ $item['label'] }}
                        </a>
                    @else
                        <a 
                            href="{{ $item['url'] }}" 
                            class="text-slate-300 hover:text-white hover:text-red-400 transition-colors duration-300 text-sm font-medium py-2"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</div>
