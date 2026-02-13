<div x-data="{ open: false }" class="relative inline-block text-left" @click.away="open = false">
    <div>
        <button @click="open = !open" type="button" class="flex items-center space-x-3 focus:outline-none group" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
            <div class="relative h-10 w-10 overflow-hidden rounded-full border-2 border-slate-700 transition-colors group-hover:border-red-500">
                <img src="{{ $avatarUrl }}" alt="{{ $name }}" class="h-full w-full object-cover">
            </div>
            <span class="hidden lg:block text-slate-100 group-hover:text-white font-medium transition-colors">{{ $name }}</span>
            <x-heroicon-m-chevron-down class="h-4 w-4 text-slate-400 group-hover:text-red-500 transition-colors" />
        </button>
    </div>

    <div x-show="open" 
         x-transition:enter="transition ease-out duration-100" 
         x-transition:enter-start="transform opacity-0 scale-95" 
         x-transition:enter-end="transform opacity-100 scale-100" 
         x-transition:leave="transition ease-in duration-75" 
         x-transition:leave-start="transform opacity-100 scale-100" 
         x-transition:leave-end="transform opacity-0 scale-95" 
         class="absolute right-0 z-50 mt-2 w-56 origin-top-right rounded-xl bg-slate-800 border border-slate-700 shadow-2xl ring-1 ring-black ring-opacity-5 focus:outline-none" 
         role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1">
        
        @if($user)
        <div class="px-4 py-3 border-b border-slate-700/50">
            <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">{{ __('Account') }}</p>
            <p class="text-sm font-medium text-white truncate">{{ $user->email }}</p>
        </div>
        @endif

        <div class="py-1" role="none">
            <a href="{{ LaravelLocalization::localizeUrl('/dashboard') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors group" role="menuitem">
                <x-heroicon-o-squares-2x2 class="h-5 w-5 text-slate-500 group-hover:text-red-500" />
                <span>{{ __('Dashboard') }}</span>
            </a>
            <a href="{{ LaravelLocalization::localizeUrl('/events-my') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors group" role="menuitem">
                <x-heroicon-o-calendar class="h-5 w-5 text-slate-500 group-hover:text-red-500" />
                <span>{{ __('I miei eventi') }}</span>
            </a>
            <a href="{{ LaravelLocalization::localizeUrl('/events-near-me') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors group" role="menuitem">
                <x-heroicon-o-map-pin class="h-5 w-5 text-slate-500 group-hover:text-red-500" />
                <span>{{ __('Eventi vicini') }}</span>
            </a>
            <a href="{{ LaravelLocalization::localizeUrl('/profile') }}" class="flex items-center space-x-3 px-4 py-2 text-sm text-slate-300 hover:bg-slate-700/50 hover:text-white transition-colors group" role="menuitem">
                <x-heroicon-o-user class="h-5 w-5 text-slate-500 group-hover:text-red-500" />
                <span>{{ __('Profilo') }}</span>
            </a>
        </div>

        <div class="py-1 border-t border-slate-700/50" role="none">
            <button wire:click="logout" class="flex w-full items-center space-x-3 px-4 py-2 text-sm text-red-400 hover:bg-red-500/10 hover:text-red-300 transition-colors group" role="menuitem">
                <x-heroicon-o-arrow-right-start-on-rectangle class="h-5 w-5 text-red-500/70 group-hover:text-red-400" />
                <span>{{ __('Esci') }}</span>
            </button>
        </div>
    </div>
</div>
