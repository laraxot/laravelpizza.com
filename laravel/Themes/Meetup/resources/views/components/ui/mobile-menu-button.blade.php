{{--
/**
 * Enhanced Mobile Menu Button
 * 
 * Animated hamburger menu button with:
 * - Smooth transitions to X icon
 * - Multiple size options
 * - Accessibility features
 * - Hover states
 * 
 * @param string $size - Button size: 'sm', 'md', 'lg'
 * @param bool $isOpen - Current menu state (managed by parent)
 */
--}}
@php
    $size = $size ?? 'md';
    
    $padding = match($size) {
        'sm' => 'p-2',
        'md' => 'p-2.5',
        'lg' => 'p-3',
        default => 'p-2.5'
    };
    
    $iconSize = match($size) {
        'sm' => 'w-4 h-4',
        'md' => 'w-5 h-5',
        'lg' => 'w-6 h-6',
        default => 'w-5 h-5'
    };
@endphp

<button type="button" 
        @click="$dispatch('mobile-menu-toggle')"
        class="{{ $padding }} rounded-xl text-slate-600 dark:text-slate-300 bg-gray-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition-all duration-200"
        :class="{ 'bg-red-50 dark:bg-red-950/20 border-red-500/50': isMenuOpen }"
        aria-label="Toggle mobile menu"
        x-data="{ isMenuOpen: false }"
        @mobile-menu-toggle.window="isMenuOpen = !isMenuOpen">
    
    <!-- Hamburger icon (closed state) -->
    <svg x-show="!isMenuOpen" 
         x-cloak 
         xmlns="http://www.w3.org/2000/svg" 
         class="{{ $iconSize }} transition-all duration-300" 
         fill="none" 
         viewBox="0 0 24 24" 
         stroke="currentColor">
        <path stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M4 6h16M4 12h16M4 18h16"/>
    </svg>
    
    <!-- X icon (open state) -->
    <svg x-show="isMenuOpen" 
         x-cloak 
         xmlns="http://www.w3.org/2000/svg" 
         class="{{ $iconSize }} transition-all duration-300" 
         fill="none" 
         viewBox="0 0 24 24" 
         stroke="currentColor">
        <path stroke-linecap="round" 
              stroke-linejoin="round" 
              stroke-width="2" 
              d="M6 18L18 6M6 6l12 12"/>
    </svg>
</button>