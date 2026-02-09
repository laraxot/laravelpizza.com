{{--
/**
 * Enhanced Language Switcher Component
 * 
 * Professional language dropdown with:
 * - Country flags for visual identification
 * - Smooth animations
 * - Mobile responsive design
 * - Current language highlighting
 * - Clean, modern styling
 * 
 * @param array $locales - Supported locales
 * @param string $currentLocale - Current active locale
 * @param bool $mobile - Mobile version (compact)
 */
--}}
@php
    $locales = $locales ?? LaravelLocalization::getSupportedLocales();
    $isMobile = $mobile ?? false;

    // Detect locale from URL prefix (source of truth in Folio context)
    $segments = request()->segments();
    $urlLocale = $segments[0] ?? null;
    $supportedKeys = array_keys($locales);
    $currentLocale = (is_string($urlLocale) && in_array($urlLocale, $supportedKeys, true))
        ? $urlLocale
        : app()->getLocale();
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false" @keydown.escape.window="open = false">
    {{-- Trigger Button --}}
    <button type="button" 
            @click="open = !open" 
            aria-haspopup="true"
            :aria-expanded="open"
            aria-label="{{ __('Select Language') }}"
            class="{{ $isMobile ? 'p-2' : 'hidden sm:flex items-center gap-2 px-3 py-2' }} rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 bg-gray-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 hover:border-red-500/50 dark:hover:border-red-500/50 hover:bg-red-50 dark:hover:bg-red-950/20 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition-all duration-200 focus-visible:ring-offset-2 dark:focus-visible:ring-offset-slate-900">
        
        @if($isMobile)
            {{-- Mobile: Globe icon (Standard A11y) --}}
            <x-filament::icon icon="heroicon-o-globe-alt" class="h-5 w-5" />
        @else
            {{-- Desktop: Globe + Current Language Name (Autonym) --}}
            <x-filament::icon icon="heroicon-o-globe-alt" class="h-5 w-5 text-red-500/70" />
            <span class="hidden md:block">{{ $locales[$currentLocale]['native'] ?? strtoupper($currentLocale) }}</span>
            <x-filament::icon icon="meetup-icon-arrow-down" class="w-4 h-4 transition-transform duration-200" ::class="{ 'rotate-180': open }" />
        @endif
    </button>
    
    {{-- Dropdown Menu --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-y-0"
         x-transition:leave-end="opacity-0 translate-y-1"
         role="listbox"
         aria-label="{{ __('Available Languages') }}"
         class="{{ $isMobile ? 'left-0' : 'right-0' }} absolute mt-2 w-52 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-xl dark:shadow-black/20 z-50 lang-dropdown">
        @foreach($locales as $code => $locale)
            <a href="{{ LaravelLocalization::getLocalizedURL($code, null, [], true) }}" 
               role="option"
               aria-selected="{{ $code === $currentLocale ? 'true' : 'false' }}"
               class="flex items-center gap-3 px-4 py-2.5 text-sm {{ 
                   $code === $currentLocale 
                       ? 'bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 font-medium' 
                       : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' 
               }} transition-colors mx-1 rounded-lg outline-none focus-visible:bg-slate-50 dark:focus-visible:bg-slate-800">
                @php $flagCode = $code === 'en' ? 'gb' : $code; @endphp
                <x-filament::icon :icon="'ui-flags.' . $flagCode" class="h-5 w-5 shrink-0 opacity-80" />
                <span class="truncate">{{ $locale['native'] ?? $code }}</span>
                
                @if($code === $currentLocale)
                    <x-filament::icon icon="meetup-icon-check" class="w-4 h-4 ml-auto text-red-600 shrink-0" />
                @endif
            </a>
        @endforeach
    </div>
</div>