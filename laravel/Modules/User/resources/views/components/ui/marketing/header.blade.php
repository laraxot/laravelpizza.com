<?php

declare(strict_types=1);

?>
<header class="w-full bg-gradient-to-r from-blue-900 to-blue-800 shadow-md">
    <div class="relative z-20 flex items-center justify-between w-full h-20 max-w-7xl px-4 sm:px-6 lg:px-8 mx-auto">
        <!-- Logo e Menu Mobile -->
        <div x-data="{ mobileMenuOpen: false }" class="relative flex items-center md:space-x-4 text-white">
            <!-- Logo -->
            <div class="relative z-50 flex items-center w-auto h-full">
                <a href="{{ route('home') }}" class="flex items-center mr-0 md:mr-5 shrink-0 transition-transform duration-300 hover:scale-105">
                    <x-ui.logo class="block w-auto fill-current h-8 text-white" />
                    <span class="ml-2 font-semibold text-lg hidden sm:block">il progetto</span>
                </a>
                
                <!-- Hamburger Menu Mobile -->
                <div @click="mobileMenuOpen=!mobileMenuOpen" class="relative flex items-center justify-center w-10 h-10 ml-4 overflow-hidden text-white bg-blue-700 rounded-full cursor-pointer md:hidden hover:bg-blue-600 transition-colors duration-200">
                    <div :class="{ 'rotate-0' : mobileMenuOpen }" class="flex flex-col items-center justify-center w-5 h-5 duration-300 ease-in-out">
                        <span :class="{ '-rotate-[135deg] translate-y-[5px]' : mobileMenuOpen }" class="block ease-in-out duration-300 w-full h-0.5 bg-white rounded-full"></span>
                        <span :class="{ 'opacity-0' : mobileMenuOpen, 'opacity-100' : !mobileMenuOpen }" class="block ease-in-out duration-300 w-full h-0.5 my-[3px] bg-white rounded-full"></span>
                        <span :class="{ '-rotate-45 -translate-y-[5px]' : mobileMenuOpen }" class="block ease-in-out duration-300 w-full h-0.5 bg-white rounded-full"></span>
                    </div>
                </div>
            </div>
            
            <!-- Menu Desktop e Mobile -->
            <div :class="{ 'translate-x-0 opacity-100' : mobileMenuOpen, 'translate-x-full md:translate-x-0 opacity-0 md:opacity-100 hidden md:flex' : !mobileMenuOpen }" 
                 class="fixed top-0 right-0 z-40 flex-col items-start justify-start w-3/4 sm:w-1/2 h-full min-h-screen pt-20 space-y-1 text-base font-medium duration-300 ease-out transform bg-blue-800 md:bg-transparent md:pt-0 text-white md:h-auto md:min-h-0 md:w-auto md:static md:items-center md:flex-row md:space-y-0 md:space-x-1 shadow-xl md:shadow-none">
                
                <nav class="flex flex-col w-full p-6 space-y-4 md:p-0 md:flex-row md:space-x-6 md:space-y-0 md:w-auto md:flex">
                    <x-ui.nav-link href="/" class="text-white hover:text-blue-200 px-3 py-2 rounded-lg hover:bg-blue-700/50 transition-all duration-200">Home</x-ui.nav-link>
                    <x-ui.nav-link href="/servizi" class="text-white hover:text-blue-200 px-3 py-2 rounded-lg hover:bg-blue-700/50 transition-all duration-200">Servizi</x-ui.nav-link>
                    <x-ui.nav-link href="/medici" class="text-white hover:text-blue-200 px-3 py-2 rounded-lg hover:bg-blue-700/50 transition-all duration-200">Medici</x-ui.nav-link>
                    <x-ui.nav-link href="/studi" class="text-white hover:text-blue-200 px-3 py-2 rounded-lg hover:bg-blue-700/50 transition-all duration-200">Studi</x-ui.nav-link>
                    <x-ui.nav-link href="/contatti" class="text-white hover:text-blue-200 px-3 py-2 rounded-lg hover:bg-blue-700/50 transition-all duration-200">Contatti</x-ui.nav-link>
                </nav>
                
                <!-- Pulsanti Mobile (visibili solo su mobile) -->
                <div class="flex flex-col w-full p-6 space-y-3 md:hidden">
                    @auth
                        <a href="{{ route('dashboard') }}" class="w-full px-4 py-2 text-center font-medium bg-white text-blue-800 rounded-lg hover:bg-blue-50 transition-colors duration-200">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full px-4 py-2 text-center font-medium bg-blue-700 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">Accedi</a>
                        <a href="{{ route('register') }}" class="w-full px-4 py-2 text-center font-medium bg-white text-blue-800 rounded-lg hover:bg-blue-50 transition-colors duration-200">Registrati</a>
                    @endauth
                </div>
            </div>
        </div>
        
        <!-- Pulsanti Desktop -->
        <div class="relative z-50 hidden md:flex items-center space-x-4 text-white">
            <div x-data class="flex-shrink-0 w-10 h-10 overflow-hidden rounded-full bg-blue-700 flex items-center justify-center hover:bg-blue-600 transition-colors duration-200" x-cloak>
                <x-ui.light-dark-switch class="text-white"></x-ui.light-dark-switch>
            </div>
            
            @auth
                <div class="flex items-center space-x-3">
                    <a href="{{ route('dashboard') }}" class="px-5 py-2 text-sm font-medium bg-white text-blue-800 rounded-lg hover:bg-blue-50 transition-colors duration-200 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                        </svg>
                        Dashboard
                    </a>
                </div>
            @else
                <div class="flex items-center space-x-3">
                    <a href="{{ route('login') }}" class="px-5 py-2 text-sm font-medium bg-blue-700 text-white rounded-lg hover:bg-blue-600 transition-colors duration-200">Accedi</a>
                    <a href="{{ route('register') }}" class="px-5 py-2 text-sm font-medium bg-white text-blue-800 rounded-lg hover:bg-blue-50 transition-colors duration-200">Registrati</a>
                </div>
            @endauth

        </div>
    </div>
</header>
