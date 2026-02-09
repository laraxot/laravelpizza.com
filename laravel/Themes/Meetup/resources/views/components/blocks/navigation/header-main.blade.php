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
     @keydown.escape.window="mobileMenuOpen = false"
     role="navigation"
     aria-label="{{ __('Main navigation') }}"
     class="fixed top-0 left-0 right-0 z-50 bg-slate-100/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-sm dark:shadow-none transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo --}}
            <a href="{{ LaravelLocalization::localizeUrl($home_url) }}" class="flex items-center space-x-3 group focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 rounded-lg p-1" aria-label="{{ $brand }} - {{ __('Home') }}">
                @if($logo)
                    <img src="{{ asset($logo) }}" alt="" class="h-12 w-12 transition-opacity group-hover:opacity-90" aria-hidden="true" />
                @else
                    <x-filament::icon
                        icon="meetup-logo"
                        class="h-12 w-12 text-red-500 transition-opacity group-hover:opacity-90"
                        aria-hidden="true"
                    />
                @endif

                <div class="flex flex-col" aria-hidden="true">
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
                               class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 rounded-md transition-all duration-200 flex items-center space-x-2 font-medium group px-1 py-0.5"
                               @if(request()->is(ltrim($item['url'], '/'))) aria-current="page" @endif>
                                <span>{{ __($item['label']) }}</span>
                            </a>
                        @endif
                    @endforeach
                </div>
            @endif

            {{-- Right Side --}}
            <div class="flex items-center space-x-2 sm:space-x-3">

                {{-- Language Switcher --}}
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
                               }} px-4 py-2 rounded-lg text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2">
                                {{ __($item['label']) }}
                            </a>
                        @endif
                    @endforeach
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button
                        type="button"
                        @click="mobileMenuOpen = !mobileMenuOpen"
                        :aria-expanded="mobileMenuOpen.toString()"
                        aria-controls="mobile-menu-panel"
                        aria-label="{{ __('Toggle mobile menu') }}"
                        class="text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white p-2 rounded-lg hover:bg-slate-200 dark:hover:bg-slate-700/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 transition-colors"
                    >
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            <path x-show="mobileMenuOpen" x-cloak stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Menu Panel --}}
    <div id="mobile-menu-panel"
         x-show="mobileMenuOpen"
         x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 -translate-y-2"
         class="md:hidden border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/95 backdrop-blur-sm">
        <div class="px-4 py-3 space-y-2">
            @foreach($items as $item)
                @if(($item['type'] ?? 'link') === 'link')
                    <a href="{{ LaravelLocalization::localizeUrl($item['url']) }}"
                       class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-red-50 dark:hover:bg-red-950/20 hover:text-red-600 dark:hover:text-red-400 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 transition-colors"
                       @if(request()->is(ltrim($item['url'], '/'))) aria-current="page" @endif>
                        <span class="font-medium">{{ __($item['label']) }}</span>
                    </a>
                @endif
            @endforeach

            <div class="pt-2 border-t border-slate-200 dark:border-slate-700 space-y-2">
                 @foreach($items as $item)
                    @if(($item['type'] ?? 'link') === 'button')
                        <a href="{{ LaravelLocalization::localizeUrl($item['url']) }}"
                           class="block w-full text-center px-4 py-2.5 rounded-xl text-sm font-medium transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 {{ ($item['style'] ?? 'outline') === 'solid' ? 'bg-red-600 text-white hover:bg-red-700' : 'bg-gray-50 dark:bg-slate-800/50 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-700' }}">
                            {{ __($item['label']) }}
                        </a>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
</nav>

{{-- Spacer --}}
<div class="h-16" aria-hidden="true"></div>
