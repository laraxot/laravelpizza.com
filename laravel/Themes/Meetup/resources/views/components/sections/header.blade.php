{{--
/**
 * Header Navigation Component - Laravel Pizza Theme
 *
 * Full navigation bar for the Laravel Pizza Meetups site.
 * Fixed top navbar with logo, menu items, and auth buttons.
 *
 * Based on production design from https://laravelpizza.com/
 */
--}}

<nav class="fixed top-0 left-0 right-0 z-50 bg-slate-900/95 backdrop-blur-sm border-b border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">

            {{-- Logo with Pizza Slice Icon --}}
            <div class="flex items-center space-x-3">
                {{-- Pizza Slice SVG Icon --}}
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                    {{-- Pizza slice triangular shape --}}
                    <path d="M12 2L2 22h20L12 2z" opacity="0.9"/>
                    {{-- Pizza toppings (dots) --}}
                    <circle cx="9" cy="16" r="1.2" fill="currentColor"/>
                    <circle cx="12" cy="11" r="1.2" fill="currentColor"/>
                    <circle cx="15" cy="16" r="1.2" fill="currentColor"/>
                    <circle cx="10.5" cy="13" r="0.9" fill="currentColor"/>
                    <circle cx="13.5" cy="13.5" r="0.9" fill="currentColor"/>
                </svg>

                {{-- Logo Text --}}
                <span class="text-white font-bold text-lg md:text-xl">
                    Laravel Pizza Meetups
                </span>
            </div>

            {{-- Navigation Links (hidden on mobile) --}}
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{ url('/events') }}" class="text-white hover:text-red-400 transition-colors duration-200 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span>Events</span>
                </a>

                <a href="{{ url('/chat') }}" class="text-white hover:text-red-400 transition-colors duration-200 flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <span>Community Chat</span>
                </a>
            </div>

            {{-- Right Side: Language Selector + Auth Buttons --}}
            <div class="flex items-center space-x-4">

                {{-- Language Selector --}}
                <div class="hidden sm:block">
                    <select class="bg-transparent text-white text-sm border border-slate-700 rounded px-3 py-1.5 focus:outline-none focus:border-red-500 transition-colors">
                        <option value="en" class="bg-slate-900">🌐 English</option>
                        <option value="it" class="bg-slate-900">🇮🇹 Italiano</option>
                    </select>
                </div>

                {{-- Login Button --}}
                <a href="{{ url('/login') }}" class="hidden sm:inline-block text-white border border-white px-4 py-2 rounded hover:bg-white hover:text-slate-900 transition-all duration-200">
                    Login
                </a>

                {{-- Sign Up Button --}}
                <a href="{{ url('/register') }}" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded font-semibold transition-all duration-200 shadow-lg hover:shadow-xl">
                    Sign Up
                </a>

                {{-- Mobile Menu Button --}}
                <button type="button" class="md:hidden text-white p-2" aria-label="Open menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>

{{-- Spacer to prevent content from hiding under fixed navbar --}}
<div class="h-16"></div>
