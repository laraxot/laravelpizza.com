<?php

declare(strict_types=1);

use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('register');

?>

<x-layouts.app>
    <x-slot name="title">
        {{ __('gdpr::register.register.title') }}
    </x-slot>

    <section
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 dark:from-slate-950 dark:via-slate-900 dark:to-red-950 relative overflow-hidden"
        aria-labelledby="register-heading"
    >
        {{-- Animated Background Elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full max-w-lg space-y-8 relative z-10 px-4 sm:px-6 lg:px-8">
            {{-- Logo & Header --}}
            <div class="text-center">
                <a href="{{ \LaravelLocalization::localizeUrl('/') }}" class="inline-block mb-6 group" aria-label="{{ config('app.name') }}">
                    <x-filament::icon
                        icon="meetup-logo"
                        class="h-20 w-auto mx-auto text-red-500 transition-transform duration-300 group-hover:scale-110 drop-shadow-lg"
                    />
                </a>
                
                <h1
                    id="register-heading"
                    class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white drop-shadow-lg"
                >
                    {{ __('gdpr::register.register.title') }}
                </h1>
                
                <p class="mt-4 text-base text-slate-300 max-w-lg mx-auto leading-relaxed">
                    {{ __('gdpr::register.register.subtitle') }}
                </p>

                {{-- Social Proof --}}
                <div class="mt-6 flex items-center justify-center gap-2 text-sm font-medium text-slate-400">
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-400 to-orange-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold">A</div>
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold">M</div>
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-teal-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold">R</div>
                        <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold">+</div>
                    </div>
                    <span>{{ __('Join 5,000+ developers worldwide') }}</span>
                </div>
            </div>

            {{-- Registration Form Card --}}
            <div class="bg-slate-800/80 backdrop-blur-xl shadow-2xl rounded-2xl p-8 border border-slate-700/50">
                @livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
            </div>

            {{-- Login Link --}}
            <div class="text-center">
                <p class="text-sm text-slate-400">
                    {{ __('gdpr::register.already_registered') }}
                    <a href="{{ \LaravelLocalization::localizeUrl('/auth/login') }}" 
                       class="font-semibold text-red-400 hover:text-red-300 transition-colors ml-1">
                        {{ __('gdpr::register.login') }}
                    </a>
                </p>
            </div>
        </div>
    </section>

</x-layouts.app>
