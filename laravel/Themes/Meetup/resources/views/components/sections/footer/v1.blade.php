{{-- Footer Section --}}
<footer class="bg-slate-950 border-t border-slate-800" role="contentinfo">
    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <x-filament::icon
                        icon="meetup-logo"
                        class="h-12 w-12 text-red-500 shrink-0"
                        aria-hidden="true"
                    />
                    <span class="text-xl font-bold text-white">Laravel Pizza Meetups</span>
                </div>
                <p class="text-gray-400 text-sm">
                    {{ __('Community of Laravel developers passionate about code and pizza.') }}
                </p>
            </div>

            <nav aria-label="{{ __('Community links') }}">
                <h4 class="font-bold text-white mb-4">{{ __('Community') }}</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded">{{ __('Events') }}</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl('/chat') }}" class="hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded">{{ __('Community Chat') }}</a></li>
                    <li><a href="#" class="hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded">{{ __('Code of Conduct') }}</a></li>
                    @guest
                        <li><a href="{{ LaravelLocalization::localizeUrl('/auth/register') }}" class="hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded">{{ __('Registrati') }}</a></li>
                    @else
                        <li><a href="{{ LaravelLocalization::localizeUrl('/profile') }}" class="hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded">{{ __('Profilo') }}</a></li>
                    @endguest
                </ul>
            </nav>

            <nav aria-label="{{ __('Resources links') }}">
                <h4 class="font-bold text-white mb-4">{{ __('Resources') }}</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded">Laravel Docs<span class="sr-only"> ({{ __('opens in new tab') }})</span></a></li>
                    <li><a href="https://filamentphp.com/docs" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded">Filament Docs<span class="sr-only"> ({{ __('opens in new tab') }})</span></a></li>
                    <li><a href="https://livewire.laravel.com/docs" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded">Livewire Docs<span class="sr-only"> ({{ __('opens in new tab') }})</span></a></li>
                    <li><a href="#" class="hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded">{{ __('Blog') }}</a></li>
                </ul>
            </nav>

            <div>
                <h4 class="font-bold text-white mb-4">{{ __('Follow Us') }}</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded-lg p-1" aria-label="Facebook">
                        <x-filament::icon icon="meetup-facebook" class="w-6 h-6" aria-hidden="true" />
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded-lg p-1" aria-label="Twitter">
                        <x-filament::icon icon="meetup-twitter" class="w-6 h-6" aria-hidden="true" />
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors focus-visible:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-red-500 rounded-lg p-1" aria-label="GitHub">
                        <x-filament::icon icon="meetup-github" class="w-6 h-6" aria-hidden="true" />
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-slate-800 text-center text-gray-400 text-sm space-y-1">
            <p>&copy; {{ date('Y') }} Laravel Pizza Meetups. {{ __('All rights reserved.') }}</p>
        </div>
    </div>
</footer>
