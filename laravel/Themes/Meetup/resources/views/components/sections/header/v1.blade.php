{{--
/**
 * Header section v1 - Nav bar (dark variant).
 * NO SVG inline: tutte le icone usano file .svg in Modules/Meetup/resources/svg/
 * e <x-filament::icon icon="meetup-{nome}" />. Vedi Modules/Meetup/docs/svg-icons-no-hardcoded-blade.md
 */
--}}
<nav class="bg-slate-900/95 backdrop-blur-md border-b border-slate-700 sticky top-0 z-50" role="navigation" aria-label="{{ __('pub_theme::navigation.main') }}" id="main-navigation">
    @php
        $loginLabel = __('pub_theme::navigation.auth.login');
        $registerLabel = __('pub_theme::navigation.auth.register');
    @endphp
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="flex items-center space-x-3 group focus:outline-none focus-visible:ring-2 focus-visible:ring-red-500 focus-visible:ring-offset-2 focus-visible:ring-offset-slate-900 rounded-lg" aria-label="{{ __('pub_theme::navigation.site_title') }}">
                <x-filament::icon
                    icon="meetup-logo"
                    class="h-12 w-12 text-red-500 transition-opacity group-hover:opacity-90"
                    aria-hidden="true"
                />
                <span class="text-xl font-bold text-white group-hover:text-red-400 transition-colors" aria-hidden="true">Laravel Pizza Meetups</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <!-- WCAG 2.1 AA: text-slate-100 on slate-800 = 9:1 contrast (4.5:1 required) -->
                <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="text-slate-100 hover:text-white transition-colors flex items-center gap-2 group focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900" data-nav-link>
                    <span>{{ __('pub_theme::navigation.home') }}</span>
                </a>
                <a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="text-slate-100 hover:text-white transition-colors flex items-center gap-2 group focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900" data-nav-link>
                    <x-filament::icon icon="meetup-icon-calendar" class="w-4 h-4 text-red-500 group-hover:scale-110 transition-transform" />
                    <span>{{ __('pub_theme::navigation.events') }}</span>
                </a>
                <a href="#" class="text-slate-100 hover:text-white transition-colors flex items-center gap-2 group focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900" data-nav-link>
                    <x-filament::icon icon="meetup-icon-chat" class="w-4 h-4 text-red-500 group-hover:scale-110 transition-transform" />
                    <span>{{ __('pub_theme::navigation.community_chat') }}</span>
                </a>
                
                {{-- Language Switcher Component --}}
                <x-ui.language-switcher />
            </div>

            <!-- Auth Toggle -->
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ LaravelLocalization::localizeUrl('/auth/login') }}" class="inline-flex items-center justify-center rounded-full border border-white/15 bg-white/5 px-4 py-2.5 text-sm font-semibold tracking-tight text-slate-100 shadow-sm transition-all duration-200 hover:-translate-y-0.5 hover:border-white/30 hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900">
                        {{ $loginLabel }}
                    </a>
                    <a href="{{ LaravelLocalization::localizeUrl('/auth/register') }}" class="group relative inline-flex items-center justify-center overflow-hidden rounded-full bg-gradient-to-r from-red-500 via-red-600 to-orange-500 px-5 py-2.5 text-sm font-black tracking-[0.02em] text-white shadow-[0_18px_45px_-22px_rgba(239,68,68,0.75)] ring-1 ring-white/10 transition-all duration-200 hover:-translate-y-0.5 hover:shadow-[0_22px_55px_-22px_rgba(249,115,22,0.8)] focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-slate-900">
                        <span class="relative z-10">{{ $registerLabel }}</span>
                        <span class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/15 to-white/0 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></span>
                    </a>
                @else
                    @livewire(\Modules\User\Filament\Widgets\UserDropdown::class)
                @endguest
            </div>

            <!-- Mobile menu button -->
            <button id="mobile-menu-button" 
                    @click="mobileMenuOpen = !mobileMenuOpen"
                    x-data="{ mobileMenuOpen: false }"
                    class="md:hidden text-slate-100 hover:text-white p-2 rounded-lg hover:bg-slate-700/50 transition-colors focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900" 
                    aria-expanded="false" aria-controls="mobile-menu" aria-label="{{ __('Toggle mobile menu') }}">
                <x-filament::icon icon="meetup-icon-menu" class="w-6 h-6" aria-hidden="true" />
            </button>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-6">
            <div class="flex flex-col space-y-2 pt-4 border-t border-slate-700/50">
                <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="text-slate-300 hover:text-white px-4 py-3 hover:bg-slate-700/50 rounded-xl transition-colors font-medium" data-nav-link>{{ __('pub_theme::navigation.home') }}</a>
                <a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="text-slate-300 hover:text-white px-4 py-3 hover:bg-slate-700/50 rounded-xl transition-colors flex items-center gap-3 font-medium" data-nav-link>
                    <x-filament::icon icon="meetup-icon-calendar" class="w-5 h-5 text-red-500" />
                    <span>{{ __('pub_theme::navigation.events') }}</span>
                </a>
                
                <div class="px-4 py-4 border-t border-slate-700/30 mt-2">
                    <x-ui.language-switcher mobile />
                </div>

                @guest
                    <div class="grid grid-cols-1 gap-3 px-4 pt-4 border-t border-slate-700/30">
                        <a href="{{ LaravelLocalization::localizeUrl('/auth/login') }}" class="inline-flex items-center justify-center rounded-2xl border border-white/15 bg-white/5 px-4 py-3 text-center text-sm font-semibold tracking-tight text-slate-100 shadow-sm transition-all duration-200 hover:border-white/30 hover:bg-white/10 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 focus:ring-offset-slate-900">{{ $loginLabel }}</a>
                        <a href="{{ LaravelLocalization::localizeUrl('/auth/register') }}" class="inline-flex items-center justify-center rounded-2xl bg-gradient-to-r from-red-500 via-red-600 to-orange-500 px-4 py-3 text-center text-sm font-black tracking-[0.02em] text-white shadow-[0_18px_45px_-22px_rgba(239,68,68,0.75)] ring-1 ring-white/10 transition-all duration-200 hover:from-red-400 hover:via-red-500 hover:to-orange-400 focus:outline-none focus:ring-2 focus:ring-red-400 focus:ring-offset-2 focus:ring-offset-slate-900">{{ $registerLabel }}</a>
                    </div>
                @else
                    <div class="px-4 py-2 space-y-1">
                        <div class="flex items-center space-x-3 px-2 py-4 border-b border-slate-700/30 mb-4">
                            @php
                                $profile = Auth::user()->profile;
                                $avatarUrl = $profile?->getAvatarUrl() ?? 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y';
                            @endphp
                            <img src="{{ $avatarUrl }}" class="h-12 w-12 rounded-full border-2 border-slate-700" alt="{{ Auth::user()->name }}">
                            <div>
                                <p class="text-white font-bold">{{ Auth::user()->name }}</p>
                                <p class="text-xs text-slate-400 font-medium">{{ Auth::user()->email }}</p>
                            </div>
                        </div>
                        <a href="{{ LaravelLocalization::localizeUrl('/dashboard') }}" class="flex items-center space-x-3 text-slate-300 hover:text-white px-4 py-3 hover:bg-slate-700/50 rounded-xl transition-colors font-medium block">
                            <x-heroicon-o-squares-2x2 class="h-5 w-5 text-slate-500" />
                            <span>{{ __('pub_theme::navigation.user_menu.dashboard') }}</span>
                        </a>
                        <a href="{{ LaravelLocalization::localizeUrl('/events-my') }}" class="flex items-center space-x-3 text-slate-300 hover:text-white px-4 py-3 hover:bg-slate-700/50 rounded-xl transition-colors font-medium block">
                            <x-heroicon-o-calendar class="h-5 w-5 text-slate-500" />
                            <span>{{ __('pub_theme::navigation.user_menu.my_events') }}</span>
                        </a>
                        <a href="{{ LaravelLocalization::localizeUrl('/events-near-me') }}" class="flex items-center space-x-3 text-slate-300 hover:text-white px-4 py-3 hover:bg-slate-700/50 rounded-xl transition-colors font-medium block">
                            <x-heroicon-o-map-pin class="h-5 w-5 text-slate-500" />
                            <span>{{ __('pub_theme::navigation.user_menu.nearby_events') }}</span>
                        </a>
                        <a href="{{ LaravelLocalization::localizeUrl('/profile') }}" class="flex items-center space-x-3 text-slate-300 hover:text-white px-4 py-3 hover:bg-slate-700/50 rounded-xl transition-colors font-medium block">
                            <x-heroicon-o-user class="h-5 w-5 text-slate-500" />
                            <span>{{ __('pub_theme::navigation.user_menu.my_profile') }}</span>
                        </a>
                        
                        {{-- In Folio projects, we redirect to localized paths, not named routes --}}
                        <form method="POST" action="/{{ app()->getLocale() }}" class="pt-4 mt-4 border-t border-slate-700/30">
                            @csrf
                            <input type="hidden" name="_method" value="POST"> {{-- logout often needs a form --}}
                            <button type="submit" class="flex w-full items-center space-x-3 text-red-400 hover:text-red-300 px-4 py-3 hover:bg-red-500/10 rounded-xl transition-colors font-bold block">
                                <x-heroicon-o-arrow-right-start-on-rectangle class="h-5 w-5" />
                                <span>{{ __('pub_theme::navigation.user_menu.logout') }}</span>
                            </button>
                        </form>
                    </div>
                @endguest
            </div>
        </div>
    </div>
</nav>
