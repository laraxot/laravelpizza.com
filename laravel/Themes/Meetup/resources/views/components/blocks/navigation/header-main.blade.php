@props([
    'brand' => 'Laravel Pizza',
    'logo' => null,
    'tagline' => '',
    'home_url' => '/',
    'show_navigation' => true,
    'items' => [],
])

@php
    $locales = LaravelLocalization::getSupportedLocales();
    $currentLocale = LaravelLocalization::getCurrentLocale();
@endphp

<nav x-data="{ mobileMenuOpen: false }"
     @mobile-menu-toggle.window="mobileMenuOpen = !mobileMenuOpen"
     class="fixed top-0 left-0 right-0 z-50 bg-slate-100/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-sm dark:shadow-none transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <a href="{{ LaravelLocalization::localizeUrl($home_url) }}" class="flex items-center space-x-3 group focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded-lg p-1">
                @if($logo)
                    <img src="{{ asset($logo) }}" alt="{{ $brand }}" class="h-12 w-12 transition-opacity group-hover:opacity-90" />
                @else
                    <x-filament::icon
                        icon="meetup-logo"
                        class="h-12 w-12 text-red-500 transition-opacity group-hover:opacity-90"
                    />
                @endif

                <div class="flex flex-col">
                    <span class="text-slate-900 dark:text-white font-bold text-lg md:text-xl leading-tight">
                        {{ $brand }}
                    </span>
                    @if($tagline)
                        <span class="text-slate-600 dark:text-slate-400 text-xs md:text-sm font-medium">
                            {{ $tagline }}
                        </span>
                    @endif
                </div>
            </a>

            {{-- Navigation Links (Desktop) --}}
            @if($show_navigation)
                <div class="hidden lg:flex items-center space-x-8">
                    @foreach($items as $item)
                        @if(($item['type'] ?? 'link') === 'link')
                            <a href="{{ LaravelLocalization::localizeUrl($item['url']) }}"
                               class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400 focus:text-red-600 dark:focus:text-red-400 focus:outline-none focus:ring-2 focus:ring-red-500/0 focus-visible:ring-red-500 rounded-md transition-all duration-200 flex items-center space-x-2 font-medium group">
                                <span>{{ __($item['label']) }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif

            {{-- Right Side --}}
            <div class="flex items-center space-x-2 sm:space-x-3">

                {{-- Language Switcher (from items or default) --}}
                @if(count($locales) > 1)
                    <x-ui.language-switcher :current-locale="$currentLocale" :locales="$locales" />
                @endif

                {{-- Theme Toggle --}}
                <x-ui.theme-toggle size="md" />

                {{-- Auth Buttons / CTA (Desktop) --}}
                <div class="hidden sm:flex items-center gap-2">
                    @foreach($items as $item)
                        @if(($item['type'] ?? 'link') === 'button')
                            <a href="{{ LaravelLocalization::localizeUrl($item['url']) }}"
                               class="{{ ($item['style'] ?? 'outline') === 'solid' 
                                   ? 'bg-red-600 hover:bg-red-700 text-white' 
                                   : 'bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 border border-slate-300 dark:border-slate-700 hover:bg-slate-50 dark:hover:bg-slate-700' 
                               }} px-4 py-2 rounded-lg text-sm font-medium transition-colors">
                                {{ __($item['label']) }}
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button 
                        id="mobile-menu-button"
                        type="button"
                        aria-controls="mobile-menu"
                        aria-expanded="false"
                        class="text-slate-300 hover:text-white focus:outline-none"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>

                {{-- Mobile Menu --}}
                <div id="mobile-menu" class="hidden md:hidden mt-4 pb-4" role="menu" aria-label="Mobile navigation" x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 transform -translate-y-2" x-transition:enter-end="opacity-100 transform translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 transform translate-y-0" x-transition:leave-end="opacity-0 transform -translate-y-2">
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
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/95 backdrop-blur-sm"
         style="display: none;">
        <div class="px-4 py-3 space-y-2">
            @foreach($items as $item)
                @if(($item['type'] ?? 'link') === 'link')
                    <a href="{{ LaravelLocalization::localizeUrl($item['url']) }}"
                       class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-red-50 dark:hover:bg-red-950/20 hover:text-red-600 dark:hover:text-red-400 focus:bg-red-50 dark:focus:bg-red-950/20 focus:text-red-600 dark:focus:text-red-400 focus:outline-none client-focus-ring transition-colors">
                        <span class="font-medium">{{ __($item['label']) }}</span>
                    </a>
                @endif
            @endforeach

            <div class="pt-2 border-t border-slate-200 dark:border-slate-700 space-y-2">
                 @foreach($items as $item)
                    @if(($item['type'] ?? 'link') === 'button')
                        <a href="{{ LaravelLocalization::localizeUrl($item['url']) }}"
                           class="block w-full text-center px-4 py-2.5 rounded-xl text-sm font-medium transition-colors {{ ($item['style'] ?? 'outline') === 'solid' ? 'bg-red-600 text-white' : 'bg-gray-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700' }}">
                            {{ __($item['label']) }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</nav>

{{-- Spacer --}}
<div class="h-16"></div>
