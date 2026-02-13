<?php

declare(strict_types=1);

?>
<x-layouts.main>
    <div class="min-h-screen flex text-slate-800 dark:text-gray-200 font-sans">
        <!-- Left Side: Branding / Content (Enhanced) -->
        <div class="hidden lg:flex w-5/12 bg-gradient-to-br from-indigo-600 via-purple-600 to-blue-600 flex-col justify-between p-12 relative overflow-hidden text-white">
            <!-- Dynamic Background Shapes -->
            <div class="absolute top-0 left-0 w-full h-full overflow-hidden opacity-20 pointer-events-none">
                <div class="absolute -top-20 -left-20 w-96 h-96 bg-purple-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob"></div>
                <div class="absolute top-0 -right-20 w-96 h-96 bg-blue-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-2000"></div>
                <div class="absolute -bottom-20 left-20 w-96 h-96 bg-indigo-400 rounded-full mix-blend-multiply filter blur-3xl animate-blob animation-delay-4000"></div>
            </div>

            <div class="relative z-10 flex flex-col h-full justify-center">
                <a href="/" class="block mb-12 transform hover:scale-105 transition duration-300 origin-left">
                     <!-- White Logo for Contrast -->
                    <x-ui.logo class="h-12 w-auto text-white fill-current" />
                </a>

                <h1 class="text-5xl font-extrabold tracking-tight mb-6 leading-tight drop-shadow-md">
                    {{ __('user::login.page.title') }}
                </h1>
                <p class="text-xl text-indigo-50 leading-relaxed font-light max-w-lg drop-shadow-sm">
                    {{ __('user::login.page.subtitle') }}
                </p>
                
                @if(isset($branding))
                    <div class="mt-12 p-6 bg-white/10 backdrop-blur-md rounded-2xl border border-white/20 shadow-lg">
                         {{ $branding }}
                    </div>
                @endif
            </div>

            <div class="relative z-10 text-sm text-indigo-200 font-medium tracking-wide">
                &copy; {{ date('Y') }} LaravelPizza. Made with ❤️ and 🍕.
            </div>
        </div>

        <!-- Right Side: Form (Spacious & Modern) -->
        <div class="w-full lg:w-7/12 flex flex-col justify-center items-center p-8 lg:p-16 bg-white dark:bg-gray-950 relative">
             <!-- Mobile Background Gradient (Subtle) -->
            <div class="lg:hidden absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-indigo-500 to-purple-500"></div>

            <div class="w-full max-w-2xl space-y-8">
                 <div class="lg:hidden text-center mb-10">
                    <x-ui.logo class="h-12 w-auto mx-auto mb-4" />
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $title ?? '' }}</h2>
                 </div>

                 <!-- Content Container -->
                 <div class="bg-transparent">
                    {{ $slot }}
                 </div>

                 @if(isset($footer))
                    <div class="text-center text-sm text-slate-500 dark:text-gray-400 mt-8 pt-6 border-t border-gray-100 dark:border-gray-800">
                        {{ $footer }}
                    </div>
                 @endif
            </div>
        </div>
    </div>
    
    <style>
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob {
        animation: blob 7s infinite;
    }
    .animation-delay-2000 {
        animation-delay: 2s;
    }
    .animation-delay-4000 {
        animation-delay: 4s;
    }
    </style>
</x-layouts.main>
