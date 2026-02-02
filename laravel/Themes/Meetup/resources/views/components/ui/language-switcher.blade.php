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
    $currentLocale = $currentLocale ?? LaravelLocalization::getCurrentLocale();
    $isMobile = $mobile ?? false;
@endphp

<div class="relative" x-data="{ open: false }" @click.outside="open = false">
    {{-- Trigger Button --}}
    <button type="button" 
            @click="open = !open" 
            class="{{ $isMobile ? 'p-2' : 'hidden sm:flex items-center gap-2 px-3 py-2' }} rounded-xl text-sm font-medium text-slate-700 dark:text-slate-300 bg-gray-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 hover:border-red-500/50 dark:hover:border-red-500/50 hover:bg-red-50 dark:hover:bg-red-950/20 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition-all duration-200">
        
        @if($isMobile)
            {{-- Mobile: Just flag --}}
            @php $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale; @endphp
            <x-filament::icon :icon="'ui-flags.' . $flagCode" class="h-5 w-5" />
@else
            {{-- Desktop: Flag + Language name --}}
            @php $flagCode = $currentLocale === 'en' ? 'gb' : $currentLocale; @endphp
            <x-filament::icon :icon="'ui-flags.' . $flagCode" class="h-5 w-5" />
            <span class="hidden md:block">{{ $locales[$currentLocale]['native'] ?? strtoupper($currentLocale) }}</span>
            <x-filament::icon icon="meetup-icon-arrow-down" class="w-4 h-4 transition-transform duration-200" :class="{ 'rotate-180': open }" />
        @endif
    </button>
    
    {{-- Dropdown Menu --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="{{ $isMobile ? 'left-0' : 'right-0' }} absolute mt-2 w-48 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 shadow-xl dark:shadow-black/20 z-50 lang-dropdown">
        @foreach($locales as $code => $locale)
            <a href="{{ LaravelLocalization::getLocalizedURL($code, null, [], true) }}" 
               class="flex items-center gap-3 px-4 py-2.5 text-sm {{ 
                   $code === $currentLocale 
                       ? 'bg-red-50 dark:bg-red-950/20 text-red-700 dark:text-red-400 font-medium' 
                       : 'text-slate-700 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800' 
               }} transition-colors">
                @php $flagCode = $code === 'en' ? 'gb' : $code; @endphp
                <x-filament::icon :icon="'ui-flags.' . $flagCode" class="h-5 w-5" />
                <span>{{ $locale['native'] ?? $code }}</span>
                
                @if($code === $currentLocale)
                    <x-filament::icon icon="meetup-icon-check" class="w-4 h-4 ml-auto text-red-600" />
                @endif
            </a>
        @endforeach
    </div>
</div>