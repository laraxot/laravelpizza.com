@props(['data'])

@php
    $navItems = collect($data['items'] ?? [])->map(function ($item) {
        $item['url'] = LaravelLocalization::localizeURL($item['url']);
        return $item;
    });

    $ctaButton = $data['cta_button'] ?? null;
    if ($ctaButton) {
        $ctaButton['url'] = LaravelLocalization::localizeURL($ctaButton['url']);
    }
@endphp

<header class="bg-[#0f2b46] text-white p-4 sticky top-0 z-50 shadow-lg backdrop-blur-md" x-data="{ mobileOpen: false }">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Left: Brand with Logo -->
        <a href="{{ LaravelLocalization::localizeURL($data['home_url']) }}" class="flex items-center space-x-2">
            @if(isset($data['logo']) && $data['logo'])
                <img src="{{ $data['logo'] }}" alt="{{ $data['brand'] }}" class="h-8 w-auto">
            @endif
            <span class="text-xl font-bold">{{ $data['brand'] }}</span>
            @if(isset($data['tagline']) && $data['tagline'])
                <span class="hidden md:inline text-sm text-gray-300 ml-2">{{ $data['tagline'] }}</span>
            @endif
        </a>

        <!-- Center: Navigation Links -->
        <nav class="hidden md:flex space-x-6">
            @foreach($navItems as $item)
                <a href="{{ $item['url'] }}" class="hover:text-red-500 transition-colors duration-200">{{ $item['label'] }}</a>
            @endforeach
        </nav>

        <!-- Right: CTA / Auth -->
        <div class="hidden md:flex items-center space-x-4">
            @guest
                @if($ctaButton)
                    <a href="{{ $ctaButton['url'] }}"
                       class="bg-[#ef4444] hover:bg-red-600 text-white font-bold py-2 px-4 rounded-lg transition-colors duration-200">
                        {{ $ctaButton['label'] }}
                    </a>
                @endif
                <a href="{{ LaravelLocalization::localizeURL('/login') }}" class="text-gray-200 hover:text-white transition-colors">{{ __('pub_theme::navigation.auth.login') }}</a>
                <a href="{{ LaravelLocalization::localizeURL('/register') }}" class="text-gray-200 hover:text-white transition-colors">{{ __('pub_theme::navigation.auth.register') }}</a>
            @else
                @php
                    $user = Auth::user();
                    $initials = collect(explode(' ', $user?->name ?? ''))
                        ->filter()
                        ->map(fn ($part) => mb_substr($part, 0, 1))
                        ->join('');
                @endphp

                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center gap-2 text-gray-200 hover:text-white focus:outline-none">
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-full bg-red-600 text-white text-sm font-semibold">
                            {{ $initials ?: 'U' }}
                        </span>
                        <span class="text-sm font-medium">{{ $user?->name }}</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-transition class="absolute right-0 mt-2 w-60 bg-slate-900 border border-slate-700 rounded-lg shadow-xl z-50">
                        <div class="py-2 text-sm text-gray-200">
                            @can('access-dashboard')
                                <a href="{{ LaravelLocalization::localizeUrl('/dashboard') }}" class="flex items-center px-4 py-2 hover:bg-slate-800">
                                    <x-filament::icon icon="heroicon-o-home" class="w-4 h-4 mr-2" />
                                    <span>{{ __('pub_theme::navigation.user_menu.dashboard') }}</span>
                                </a>
                            @endcan

                            <a href="{{ LaravelLocalization::localizeUrl('/events/mine') }}" class="flex items-center px-4 py-2 hover:bg-slate-800">
                                <x-filament::icon icon="heroicon-o-calendar-days" class="w-4 h-4 mr-2" />
                                <span>{{ __('pub_theme::navigation.user_menu.my_events') }}</span>
                            </a>

                            <a href="{{ LaravelLocalization::localizeUrl('/events/nearby') }}" class="flex items-center px-4 py-2 hover:bg-slate-800">
                                <x-filament::icon icon="heroicon-o-map-pin" class="w-4 h-4 mr-2" />
                                <span>{{ __('pub_theme::navigation.user_menu.nearby_events') }}</span>
                            </a>

                            <a href="{{ LaravelLocalization::localizeUrl('/profile') }}" class="flex items-center px-4 py-2 hover:bg-slate-800">
                                <x-filament::icon icon="heroicon-o-user" class="w-4 h-4 mr-2" />
                                <span>{{ __('pub_theme::navigation.user_menu.my_profile') }}</span>
                            </a>

                            <a href="{{ LaravelLocalization::localizeUrl('/settings') }}" class="flex items-center px-4 py-2 hover:bg-slate-800">
                                <x-filament::icon icon="heroicon-o-cog-6-tooth" class="w-4 h-4 mr-2" />
                                <span>{{ __('pub_theme::navigation.user_menu.settings') }}</span>
                            </a>
                        </div>

                        <div class="border-t border-slate-800"></div>

                        <form method="POST" action="{{ route('logout') }}" class="py-1">
                            @csrf
                            <button type="submit" class="w-full text-left flex items-center px-4 py-2 text-sm text-red-300 hover:text-red-200 hover:bg-slate-800">
                                <x-filament::icon icon="heroicon-o-arrow-left-on-rectangle" class="w-4 h-4 mr-2" />
                                <span>{{ __('pub_theme::navigation.user_menu.logout') }}</span>
                            </button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>

        <!-- Mobile Navigation Toggle -->
        <div class="md:hidden">
            <button class="text-white focus:outline-none" aria-expanded="false" aria-controls="mobile-menu" @click="mobileOpen = !mobileOpen">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-4 6h4"></path>
                </svg>
            </button>
        </div>
    </div>
</header>

<!-- Mobile Menu -->
<div class="md:hidden bg-[#0f2b46] text-white px-4 pb-4 space-y-3" x-show="mobileOpen" x-transition>
    <div class="flex flex-col space-y-2">
        @foreach($navItems as $item)
            <a href="{{ $item['url'] }}" class="hover:text-red-400 transition-colors duration-200">{{ $item['label'] }}</a>
        @endforeach
    </div>

    <div class="border-t border-slate-700 pt-3 space-y-2">
        @guest
            <a href="{{ LaravelLocalization::localizeURL('/login') }}" class="text-gray-200 hover:text-white">{{ __('pub_theme::navigation.auth.login') }}</a>
            <a href="{{ LaravelLocalization::localizeURL('/register') }}" class="bg-[#ef4444] text-white px-3 py-2 rounded-lg inline-block">{{ __('pub_theme::navigation.auth.register') }}</a>
        @else
            @can('access-dashboard')
                <a href="{{ LaravelLocalization::localizeUrl('/dashboard') }}" class="flex items-center gap-2 hover:text-red-400">
                    <x-heroicon-o-home class="w-4 h-4" /> Dashboard
                </a>
            @endcan
            <a href="{{ LaravelLocalization::localizeUrl('/events/mine') }}" class="flex items-center gap-2 hover:text-red-400">
                <x-heroicon-o-calendar-days class="w-4 h-4" /> I miei eventi
            </a>
            <a href="{{ LaravelLocalization::localizeUrl('/events/nearby') }}" class="flex items-center gap-2 hover:text-red-400">
                <x-heroicon-o-map-pin class="w-4 h-4" /> Eventi vicini
            </a>
            <a href="{{ LaravelLocalization::localizeUrl('/profile') }}" class="flex items-center gap-2 hover:text-red-400">
                <x-heroicon-o-user class="w-4 h-4" /> Profilo
            </a>

            <form method="POST" action="{{ route('logout') }}" class="pt-2">
                @csrf
                <button type="submit" class="flex items-center gap-2 text-red-200 hover:text-red-100">
                    <x-heroicon-o-arrow-left-on-rectangle class="w-4 h-4" /> Logout
                </button>
            </form>
        @endguest
    </div>
</div>
