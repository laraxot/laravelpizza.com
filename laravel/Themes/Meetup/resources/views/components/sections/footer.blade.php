{{-- Footer Section --}}
<footer class="bg-slate-950 border-t border-slate-800">
    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <x-filament::icon
                        icon="meetup-logo"
                        class="h-12 w-12 text-red-500 shrink-0"
                    />
                    <span class="text-xl font-bold text-white">Laravel Pizza Meetups</span>
                </div>
                <p class="text-gray-400 text-sm">
                    Community of Laravel developers passionate about code and pizza.
                </p>
            </div>

            <div>
                <h4 class="font-bold text-white mb-4">Community</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="{{ LaravelLocalization::localizeUrl('/events') }}" class="hover:text-white transition-colors">Events</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl('/chat') }}" class="hover:text-white transition-colors">Community Chat</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Code of Conduct</a></li>
                    <li><a href="{{ LaravelLocalization::localizeUrl('/register') }}" class="hover:text-white transition-colors">Join Us</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white mb-4">Resources</h4>
                <ul class="space-y-2 text-gray-400 text-sm">
                    <li><a href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">Laravel Docs</a></li>
                    <li><a href="https://filamentphp.com/docs" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">Filament Docs</a></li>
                    <li><a href="https://livewire.laravel.com/docs" target="_blank" rel="noopener noreferrer" class="hover:text-white transition-colors">Livewire Docs</a></li>
                    <li><a href="#" class="hover:text-white transition-colors">Blog</a></li>
                </ul>
            </div>

            <div>
                <h4 class="font-bold text-white mb-4">Follow Us</h4>
                <div class="flex space-x-4">
                    <a href="#" class="text-gray-400 hover:text-white transition-colors" aria-label="Facebook">
                        <x-filament::icon icon="meetup-facebook" class="w-6 h-6" />
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors" aria-label="Twitter">
                        <x-filament::icon icon="meetup-twitter" class="w-6 h-6" />
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors" aria-label="GitHub">
                        <x-filament::icon icon="meetup-github" class="w-6 h-6" />
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-slate-800 text-center text-gray-400 text-sm space-y-1">
            <p>&copy; {{ date('Y') }} Laravel Pizza Meetups. All rights reserved.</p>
            <p>Made with ❤️ for the Laravel community.</p>
        </div>
    </div>
</footer>
