<?php

declare(strict_types=1);

use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('login');

?>

<x-layouts.app>
    <x-slot name="title">
        {{ __('user::login.fields.email.label') }}
    </x-slot>

    <section
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 dark:from-slate-950 dark:via-slate-900 dark:to-red-950 relative overflow-hidden py-12"
        aria-labelledby="login-heading"
    >
        {{-- Animated Background --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-red-600/10 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                {{-- Left Side: Branding & Benefits --}}
                <div class="text-center lg:text-left space-y-8">
                    <a href="{{ \LaravelLocalization::localizeUrl('/') }}" class="inline-block mb-6 group" aria-label="{{ config('app.name') }}">
                        <x-filament::icon
                            icon="meetup-logo"
                            class="h-16 w-auto lg:h-20 lg:w-auto text-red-500 transition-transform duration-300 group-hover:scale-110 drop-shadow-lg"
                        />
                    </a>
                    
                    <h1
                        id="login-heading"
                        class="text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-white drop-shadow-lg"
                    >
                        {{ __('user::login.page.title') }}
                    </h1>
                    
                    <p class="text-lg text-slate-300 leading-relaxed">
                        {{ __('user::login.page.subtitle') }}
                    </p>

                    {{-- Benefits List --}}
                    <div class="space-y-4 text-left">
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-red-500/20 flex items-center justify-center mt-1">
                                <svg class="w-5 h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white">Accesso Completo</h3>
                                <p class="text-sm text-slate-400">Tutti i meetup, tutorial e risorse a tua disposizione</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center mt-1">
                                <svg class="w-5 h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white">Sicurezza Avanzata</h3>
                                <p class="text-sm text-slate-400">GDPR compliant con protezione completa dei dati</p>
                            </div>
                        </div>
                        
                        <div class="flex items-start gap-3">
                            <div class="flex-shrink-0 w-8 h-8 rounded-lg bg-green-500/20 flex items-center justify-center mt-1">
                                <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="font-semibold text-white">Community Attiva</h3>
                                <p class="text-sm text-slate-400">Partecipa a discussioni e condividi esperienze</p>
                            </div>
                        </div>
                    </div>

                    {{-- Social Proof --}}
                    <div class="pt-6 border-t border-slate-700/50">
                        <div class="flex items-center justify-center lg:justify-start gap-3 text-sm text-slate-400">
                            <div class="flex -space-x-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-orange-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold shadow-lg">A</div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold shadow-lg">M</div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-teal-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold shadow-lg">R</div>
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold shadow-lg">+</div>
                            </div>
                            <span>{{ __('5,000+ membri attivi') }}</span>
                        </div>
                    </div>
                </div>

                {{-- Right Side: Login Form --}}
                <div class="bg-slate-800/80 backdrop-blur-xl shadow-2xl rounded-2xl p-6 sm:p-8 lg:p-10 border border-slate-700/50">
                    @livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
                </div>
            </div>

            {{-- Register CTA --}}
            @if (Route::has('register'))
                <div class="text-center mt-8 pt-6 border-t border-slate-700/50">
                    <p class="text-sm text-slate-400">
                        {{ __('user::login.already_registered') }}
                        <a href="{{ \LaravelLocalization::localizeUrl('/auth/register') }}" 
                           class="font-semibold text-red-400 hover:text-red-300 transition-colors ml-1 inline-flex items-center gap-1">
                            {{ __('user::login.register') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </p>
                </div>
            @endif
        </div>
    </section>

</x-layouts.app>