{{--
/**
 * Enhanced Navigation Auth Buttons
 * 
 * Professional Login/Sign Up buttons with:
 * - Gradient effects
 * - Hover animations
 * - Mobile responsive design
 * - Consistent styling
 * 
 * @param bool $showLabels - Show text labels (true) or icons only (false)
 * @param string $size - Button size: 'sm', 'md', 'lg'
 */
--}}
@php
    $showLabels = $showLabels ?? true;
    $size = $size ?? 'md';
    $loginLabel = __('pub_theme::navigation.auth.login');
    $registerLabel = __('pub_theme::navigation.auth.register');
    
    $padding = match($size) {
        'sm' => 'px-3 py-2',
        'md' => 'px-4 py-2.5',
        'lg' => 'px-5 py-3',
        default => 'px-4 py-2.5'
    };
    
    $fontSize = match($size) {
        'sm' => 'text-xs',
        'md' => 'text-sm',
        'lg' => 'text-base',
        default => 'text-sm'
    };
    
    $roundedSize = match($size) {
        'sm' => 'rounded-lg',
        'md' => 'rounded-xl', 
        'lg' => 'rounded-2xl',
        default => 'rounded-xl'
    };
@endphp

<div class="flex items-center gap-2">
    {{-- Login Button --}}
    <a href="{{ LaravelLocalization::localizeUrl('/auth/login') }}" 
       class="hidden sm:inline-flex items-center justify-center gap-2 {{ $padding }} {{ $roundedSize }} {{ $fontSize }} font-semibold text-slate-100 bg-slate-800/70 border border-slate-600/80 hover:bg-slate-700/80 hover:border-slate-400 focus:outline-none focus:ring-2 focus:ring-red-500/20 transition-all duration-200 btn-hover-lift">
        @if(!$showLabels)
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
            </svg>
        @endif
        {{ $showLabels ? $loginLabel : '' }}
    </a>

    {{-- Register Button --}}
    <a href="{{ LaravelLocalization::localizeUrl('/auth/register') }}" 
       class="relative inline-flex items-center justify-center gap-2 overflow-hidden {{ $padding }} {{ $roundedSize }} {{ $fontSize }} font-black tracking-[0.02em] text-white bg-gradient-to-r from-red-500 via-red-600 to-orange-500 hover:from-red-400 hover:via-red-500 hover:to-orange-400 shadow-[0_18px_45px_-22px_rgba(239,68,68,0.75)] hover:shadow-[0_22px_55px_-22px_rgba(249,115,22,0.8)] focus:outline-none focus:ring-2 focus:ring-red-500/20 transition-all duration-200 transform hover:-translate-y-0.5 btn-hover-lift">
        @if(!$showLabels)
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
            </svg>
        @endif
        {{ $showLabels ? $registerLabel : '' }}
        
        <!-- Animated shine effect -->
        <div class="absolute inset-0 {{ $roundedSize }} bg-gradient-to-r from-transparent via-white/20 to-transparent opacity-0 hover:opacity-100 transform -skew-x-12 transition-opacity duration-500"></div>
    </a>
</div>
