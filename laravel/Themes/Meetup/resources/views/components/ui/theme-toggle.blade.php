{{--
/**
 * Enhanced Theme Toggle Component
 * 
 * Smooth dark/light mode switcher with:
 * - Animated icon transitions
 * - Persistent theme preference
 * - Accessibility features
 * - Hover effects
 * - Mobile responsive sizing
 * 
 * @param string $size - Button size: 'sm', 'md', 'lg'
 * @param bool $showLabel - Show "Dark/Light" text label
 */
--}}
@php
    $sizeClass = match($size ?? 'md') {
        'sm' => 'p-2',
        'md' => 'p-2.5', 
        'lg' => 'p-3',
        default => 'p-2.5'
    };
    
    $iconSize = match($size ?? 'md') {
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6', 
        default => 'w-5 h-5'
    };
@endphp

<div x-data="{
    dark: $persist(true).as('theme_dark'),
    init() {
        if (this.dark) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    },
    toggle() {
        this.dark = !this.dark;
        document.documentElement.classList.toggle('dark', this.dark);
        
        // Dispatch custom event for other components
        this.$dispatch('theme-changed', { isDark: this.dark });
    }
}" x-init="init()" class="flex items-center">
    <button type="button"
            @click="toggle()"
            role="switch"
            :aria-checked="dark.toString()"
            :aria-label="dark ? '{{ __('Switch to light mode') }}' : '{{ __('Switch to dark mode') }}'"
            class="relative {{ $sizeClass }} rounded-xl text-slate-600 dark:text-slate-300 bg-gray-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 hover:border-red-500/50 focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 transition-all duration-200 group theme-toggle">
        
        <!-- Sun icon (light mode) -->
        <svg x-show="!dark" 
             x-cloak 
             class="{{ $iconSize }} rotate-0 transition-all duration-300" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24" 
             aria-hidden="true">
            <path stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"/>
        </svg>
        
        <!-- Moon icon (dark mode) -->
        <svg x-show="dark" 
             x-cloak 
             class="{{ $iconSize }} rotate-0 transition-all duration-300" 
             fill="none" 
             stroke="currentColor" 
             viewBox="0 0 24 24" 
             aria-hidden="true">
            <path stroke-linecap="round" 
                  stroke-linejoin="round" 
                  stroke-width="2" 
                  d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"/>
        </svg>
        
        <!-- Animated background gradient on hover -->
        <div class="absolute inset-0 rounded-xl bg-gradient-to-r from-yellow-400/20 to-orange-400/20 opacity-0 group-hover:opacity-100 transition-opacity duration-200"></div>
        
        <!-- Subtle pulse animation -->
        <div x-show="dark" 
             x-cloak 
             class="absolute inset-0 rounded-xl bg-blue-500/10 animate-pulse"></div>
    </button>
    
    @if($showLabel ?? false)
        <span class="ml-2 text-sm font-medium text-slate-600 dark:text-slate-300" x-text="dark ? 'Dark' : 'Light'"></span>
    @endif
</div>