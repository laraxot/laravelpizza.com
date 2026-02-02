{{--
/**
 * Header Navigation Component - Laravel Pizza Theme
 *
 * Enhanced navigation bar matching laravelpizza.com design with:
 * - Authentic Italian pizza slice logo
 * - Professional language switcher with flags
 * - Smooth dark/light theme toggle
 * - Responsive mobile menu
 * - Italian typography styling
 * - Component-based architecture
 *
 * Enhanced version of https://laravelpizza.com/ design
 */
--}}
@php
    $locales = LaravelLocalization::getSupportedLocales();
    $currentLocale = LaravelLocalization::getCurrentLocale();
@endphp

<nav x-data="{ mobileMenuOpen: false }" 
     @mobile-menu-toggle.window="mobileMenuOpen = !mobileMenuOpen"
     class="fixed top-0 left-0 right-0 z-50 bg-slate-100/95 dark:bg-slate-900/95 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 shadow-sm dark:shadow-none transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo (single source of truth: meetup-logo.svg) --}}
            <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="flex items-center space-x-3 group">
                <x-filament::icon
                    icon="meetup-logo"
                    class="h-12 w-12 text-red-500 transition-opacity group-hover:opacity-90"
                />

                <div class="flex flex-col">
                    <span class="text-slate-900 dark:text-white font-bold text-lg md:text-xl leading-tight">
                        Laravel Pizza
                    </span>
                    <span class="text-slate-600 dark:text-slate-400 text-xs md:text-sm font-medium">
                        Meetups
                    </span>
                </div>
            </a>

            {{-- Navigation Links (hidden on mobile) --}}
            <div class="hidden lg:flex items-center space-x-8">
                <a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400 transition-all duration-200 flex items-center space-x-2 font-medium group">
                    <x-filament::icon icon="meetup-icon-calendar" class="h-5 w-5 group-hover:scale-110 transition-transform" />
                    <span>{{ __('Events') }}</span>
                </a>
                <a href="{{ LaravelLocalization::localizeUrl('/community') }}" class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400 transition-all duration-200 flex items-center space-x-2 font-medium group">
                    <x-filament::icon icon="meetup-icon-community" class="h-5 w-5 group-hover:scale-110 transition-transform" />
                    <span>{{ __('Community') }}</span>
                </a>
                <a href="{{ LaravelLocalization::localizeUrl('/sponsors') }}" class="text-slate-700 dark:text-slate-300 hover:text-red-600 dark:hover:text-red-400 transition-all duration-200 flex items-center space-x-2 font-medium group">
                    <x-filament::icon icon="meetup-icon-sponsors" class="h-5 w-5 group-hover:scale-110 transition-transform" />
                    <span>{{ __('Sponsors') }}</span>
                </a>
            </div>

            {{-- Right: Language + Theme toggle + Auth buttons --}}
            <div class="flex items-center space-x-2 sm:space-x-3">

                {{-- Language Switcher Component --}}
                @if(count($locales) > 1)
                    <x-ui.language-switcher :current-locale="$currentLocale" :locales="$locales" />
                @endif

                {{-- Theme Toggle Component --}}
                <x-ui.theme-toggle size="md" />

                {{-- Auth Buttons (Desktop only) --}}
                <div class="hidden sm:flex items-center gap-2">
                    <x-ui.auth-buttons show-labels="true" size="md" />
                </div>

                {{-- Mobile Menu Button Component --}}
                <x-ui.mobile-menu-button size="md" />

            </div>
        </div>
    </div>

    {{-- Enhanced Mobile Navigation Menu --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 transform -translate-y-2"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-2"
         class="md:hidden border-t border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900/95 backdrop-blur-sm">
        <div class="px-4 py-3 space-y-2">
            <a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-red-50 dark:hover:bg-red-950/20 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                <x-filament::icon icon="meetup-icon-calendar" class="h-5 w-5" />
                <span class="font-medium">{{ __('Events') }}</span>
            </a>
            <a href="{{ LaravelLocalization::localizeUrl('/community') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-red-50 dark:hover:bg-red-950/20 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                <x-filament::icon icon="meetup-icon-community" class="h-5 w-5" />
                <span class="font-medium">{{ __('Community') }}</span>
            </a>
            <a href="{{ LaravelLocalization::localizeUrl('/sponsors') }}" class="flex items-center space-x-3 px-3 py-2.5 rounded-lg text-slate-700 dark:text-slate-300 hover:bg-red-50 dark:hover:bg-red-950/20 hover:text-red-600 dark:hover:text-red-400 transition-colors">
                <x-filament::icon icon="meetup-icon-sponsors" class="h-5 w-5" />
                <span class="font-medium">{{ __('Sponsors') }}</span>
            </a>
            
            <!-- Mobile Auth buttons -->
            <div class="pt-2 border-t border-slate-200 dark:border-slate-700 space-y-2">
                <a href="{{ LaravelLocalization::localizeUrl('/login') }}" 
                   class="block w-full text-center px-4 py-2.5 rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 bg-gray-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    {{ __('Login') }}
                </a>
                <a href="{{ LaravelLocalization::localizeUrl('/register') }}" 
                   class="block w-full text-center px-4 py-2.5 rounded-xl bg-gradient-to-r from-red-600 to-red-700 text-white text-sm font-semibold transition-all duration-200">
                    {{ __('Sign Up') }}
                </a>
            </div>
        </div>
    </div>
</nav>

<!-- Enhanced Spacer to prevent content from hiding under fixed navbar -->
<div class="h-16"></div>
