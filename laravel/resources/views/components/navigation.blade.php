<!-- Navigation Component -->
<nav class="bg-slate-800/50 backdrop-blur-sm border-b border-slate-700 sticky top-0 z-50" role="navigation" id="main-navigation">
    <div class="container mx-auto px-4">
        <div class="flex items-center justify-between h-16">
            <!-- Logo -->
            <a href="{{ route('home') }}" class="flex items-center space-x-3">
                <svg xmlns="http://www.w3.org/2000/svg"
                     viewBox="0 0 24 24"
                     fill="currentColor"
                     class="h-8 w-8 text-red-500"
                     aria-hidden="true">
                    <path d="M12 2L22 20H2L12 2z" fill="currentColor"/>
                    <circle cx="8" cy="14" r="1" fill="#fef2f2"/>
                    <circle cx="12" cy="12" r="1" fill="#fef2f2"/>
                    <circle cx="14" cy="16" r="1" fill="#fef2f2"/>
                    <circle cx="10" cy="17" r="1" fill="#fef2f2"/>
                </svg>
                <span class="text-xl font-bold text-white">Laravel Pizza Meetups</span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition-colors" data-nav-link>Home</a>
                <a href="#" class="text-gray-300 hover:text-white transition-colors flex items-center" data-nav-link>
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    Events
                </a>
                <a href="#" class="text-gray-300 hover:text-white transition-colors flex items-center" data-nav-link>
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                    </svg>
                    Community Chat
                </a>
                <!-- Language Dropdown -->
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="text-gray-300 hover:text-white transition-colors flex items-center">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5h12M9 3v2m1.048 9.5A18.022 18.022 0 016.412 9m6.088 9h7M11 21l5-10 5 10M12.751 5C11.783 10.77 8.07 15.61 3 18.129"/>
                        </svg>
                        <span>{{ strtoupper(app()->getLocale()) }}</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <div x-show="open"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-slate-800 border border-slate-700 rounded-lg shadow-lg z-50">
                        <div class="py-1">
                            <a href="{{ url('en') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">
                                <svg class="w-4 h-4 mr-2 text-red-500 {{ app()->getLocale() === 'en' ? '' : 'invisible' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                English
                            </a>
                            <a href="{{ url('it') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">
                                <svg class="w-4 h-4 mr-2 text-red-500 {{ app()->getLocale() === 'it' ? '' : 'invisible' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Italiano
                            </a>
                            <a href="{{ url('de') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">
                                <svg class="w-4 h-4 mr-2 text-red-500 {{ app()->getLocale() === 'de' ? '' : 'invisible' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Deutsch
                            </a>
                            <a href="{{ url('fr') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">
                                <svg class="w-4 h-4 mr-2 text-red-500 {{ app()->getLocale() === 'fr' ? '' : 'invisible' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Français
                            </a>
                            <a href="{{ url('es') }}" class="flex items-center px-4 py-2 text-sm text-gray-300 hover:bg-slate-700 hover:text-white">
                                <svg class="w-4 h-4 mr-2 text-red-500 {{ app()->getLocale() === 'es' ? '' : 'invisible' }}" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                </svg>
                                Español
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                @guest
                    <a href="#" class="text-gray-300 hover:text-white transition-colors">Login</a>
                    <a href="#" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition-colors">Sign Up</a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white transition-colors">Dashboard</a>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <button id="mobile-menu-button" class="md:hidden text-gray-300 hover:text-white" aria-expanded="false" aria-controls="mobile-menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>
        </div>

        <!-- Mobile menu -->
        <div id="mobile-menu" class="hidden md:hidden pb-4">
            <div class="flex flex-col space-y-3">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white" data-nav-link>Home</a>
                <a href="#" class="text-gray-300 hover:text-white" data-nav-link>Events</a>
                <a href="#" class="text-gray-300 hover:text-white" data-nav-link>Community Chat</a>
                @guest
                    <a href="#" class="text-gray-300 hover:text-white">Login</a>
                    <a href="#" class="bg-red-600 text-white px-4 py-2 rounded-lg text-center">Sign Up</a>
                @else
                    <a href="{{ route('dashboard') }}" class="text-gray-300 hover:text-white">Dashboard</a>
                @endguest
            </div>
        </div>
    </div>
</nav>
