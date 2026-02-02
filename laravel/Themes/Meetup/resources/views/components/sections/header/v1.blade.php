{{--
/**
 * Header section v1 - Nav bar (dark variant).
 * NO SVG inline: tutte le icone usano file .svg in Modules/Meetup/resources/svg/
 * e <x-filament::icon icon="meetup-{nome}" />. Vedi Modules/Meetup/docs/svg-icons-no-hardcoded-blade.md
 */
--}}
<nav class="bg-slate-800/50 backdrop-blur-sm border-b border-slate-700 sticky top-0 z-50" role="navigation" id="main-navigation">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="flex items-center space-x-3 group">
                <x-filament::icon
                    icon="meetup-logo"
                    class="h-12 w-12 text-red-500 transition-opacity group-hover:opacity-90"
                />
                <span class="text-xl font-bold text-white group-hover:text-red-400 transition-colors">Laravel Pizza Meetups</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="text-gray-300 hover:text-white transition-colors flex items-center gap-2 group" data-nav-link>
                    <span>{{ __('Home') }}</span>
                </a>
                <a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="text-gray-300 hover:text-white transition-colors flex items-center gap-2 group" data-nav-link>
                    <x-filament::icon icon="meetup-icon-calendar" class="w-4 h-4 text-red-500 group-hover:scale-110 transition-transform" />
                    <span>{{ __('Events') }}</span>
                </a>
                <a href="#" class="text-gray-300 hover:text-white transition-colors flex items-center gap-2 group" data-nav-link>
                    <x-filament::icon icon="meetup-icon-chat" class="w-4 h-4 text-red-500 group-hover:scale-110 transition-transform" />
                    <span>{{ __('Community Chat') }}</span>
                </a>
                
                {{-- Language Switcher Component --}}
                <x-ui.language-switcher />
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="{{ LaravelLocalization::localizeUrl('/login') }}" class="text-gray-300 hover:text-white transition-colors">{{ __('Login') }}</a>
                    <a href="{{ LaravelLocalization::localizeUrl('/register') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">{{ __('Sign Up') }}</a>
                @else
                    <a href="{{ LaravelLocalization::localizeUrl('/dashboard') }}" class="text-gray-300 hover:text-white transition-colors">{{ __('Dashboard') }}</a>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <button id="mobile-menu-button" class="md:hidden text-gray-300 hover:text-white p-2 rounded-lg hover:bg-slate-700/50 transition-colors" aria-expanded="false" aria-controls="mobile-menu">
                <x-filament::icon icon="meetup-icon-menu" class="w-6 h-6" />
            </button>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col space-y-3 pt-4 border-t border-slate-700/50">
                <a href="{{ LaravelLocalization::localizeUrl('/') }}" class="text-gray-300 hover:text-white px-4 py-2 hover:bg-slate-700/50 rounded-lg transition-colors" data-nav-link>{{ __('Home') }}</a>
                <a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="text-gray-300 hover:text-white px-4 py-2 hover:bg-slate-700/50 rounded-lg transition-colors flex items-center gap-3" data-nav-link>
                    <x-filament::icon icon="meetup-icon-calendar" class="w-5 h-5 text-red-500" />
                    <span>{{ __('Events') }}</span>
                </a>
                <a href="#" class="text-gray-300 hover:text-white px-4 py-2 hover:bg-slate-700/50 rounded-lg transition-colors flex items-center gap-3" data-nav-link>
                    <x-filament::icon icon="meetup-icon-chat" class="w-5 h-5 text-red-500" />
                    <span>{{ __('Community Chat') }}</span>
                </a>
                <div class="px-4 py-2 border-t border-slate-700/50 mt-2">
                    <x-ui.language-switcher mobile />
                </div>
                @guest
                    <div class="grid grid-cols-2 gap-4 px-4 pt-4 border-t border-slate-700/50">
                        <a href="{{ LaravelLocalization::localizeUrl('/login') }}" class="text-gray-300 hover:text-white py-2 text-center rounded-lg border border-slate-700">{{ __('Login') }}</a>
                        <a href="{{ LaravelLocalization::localizeUrl('/register') }}" class="bg-red-600 text-white py-2 rounded-lg text-center">{{ __('Sign Up') }}</a>
                    </div>
                @else
                    <a href="{{ LaravelLocalization::localizeUrl('/dashboard') }}" class="text-gray-300 hover:text-white px-4 py-2 hover:bg-slate-700/50 rounded-lg transition-colors block">{{ __('Dashboard') }}</a>
                @endguest
            </div>
        </div>
    </div>
</nav>
