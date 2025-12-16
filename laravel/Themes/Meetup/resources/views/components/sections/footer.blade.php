{{-- Footer Section --}}
<footer class="bg-slate-950 border-t border-slate-800">
    <div class="container mx-auto px-4 py-12">
        <div class="grid md:grid-cols-4 gap-8">
            <div>
                <div class="flex items-center space-x-2 mb-4">
                    <svg class="w-8 h-8 text-red-500" viewBox="0 0 24 24" fill="currentColor">
                        <path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5" opacity="0.5"/>
                        <circle cx="12" cy="12" r="1.5"/>
                        <circle cx="9" cy="10" r="1"/>
                        <circle cx="15" cy="10" r="1"/>
                        <circle cx="9" cy="14" r="1"/>
                        <circle cx="15" cy="14" r="1"/>
                    </svg>
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
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors" aria-label="Twitter">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                    </a>
                    <a href="#" class="text-gray-400 hover:text-white transition-colors" aria-label="GitHub">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd" d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z" clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t border-slate-800 text-center text-gray-400 text-sm">
            <p>&copy; {{ date('Y') }} Laravel Pizza Meetups. All rights reserved.</p>
        </div>
    </div>
</footer>
