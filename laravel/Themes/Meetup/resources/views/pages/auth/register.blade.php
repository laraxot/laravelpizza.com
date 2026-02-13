<?php

declare(strict_types=1);

use function Laravel\Folio\{middleware, name};
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

$segments = request()->segments();
$locale = $segments[0] ?? 'it';
if (in_array($locale, ['it', 'en', 'es', 'de', 'fr', 'ru'], true)) {
    LaravelLocalization::setLocale($locale);
    app()->setLocale($locale);
}

middleware(['guest']);
name('register');

?>

<x-layouts.app>
    <x-slot name="title">
        {{ __('gdpr::register.register.title') }} - LaravelPizza Community
    </x-slot>

    <x-slot name="description">
        {{ __('gdpr::register.register.subtitle') }}
    </x-slot>

    <x-slot name="keywords">
        Laravel meetup, Laravel community, PHP developer community, Laravel tutorials, Laravel workshops, Laravel networking, LaravelPizza
    </x-slot>

    {{-- Full-width mobile-first layout with animated background --}}
    <main 
        class="min-h-screen relative overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 dark:from-slate-950 dark:via-slate-900 dark:to-red-950"
        role="main"
        aria-labelledby="main-heading"
    >
        {{-- Animated Background Elements (performance optimized) --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-32 -right-32 w-64 h-64 md:w-96 md:h-96 bg-red-500/10 rounded-full blur-3xl animate-pulse-slow"></div>
            <div class="absolute -bottom-32 -left-32 w-64 h-64 md:w-96 md:h-96 bg-orange-500/10 rounded-full blur-3xl animate-pulse-slow" style="animation-delay: 2s;"></div>
            <div class="absolute top-1/3 left-1/4 w-48 h-48 bg-red-600/5 rounded-full blur-2xl animate-float"></div>
            <div class="absolute bottom-1/4 right-1/4 w-32 h-32 bg-orange-600/5 rounded-full blur-xl animate-float-reverse"></div>
        </div>

        <div class="relative z-10 px-4 py-8 md:py-12 lg:py-16">
            {{-- Mobile-first: stack vertically, desktop: side by side --}}
            <div class="max-w-7xl mx-auto space-y-8 md:space-y-12">
                
                {{-- Header Section (always visible, no scroll needed on mobile) --}}
                <header class="text-center md:text-left">
                    <a href="{{ \LaravelLocalization::localizeUrl('/') }}" class="inline-block mb-4 md:mb-6 group" aria-label="{{ config('app.name') }}">
                        <x-filament::icon
                            icon="meetup-logo"
                            class="h-16 w-auto md:h-20 text-red-500 transition-transform duration-300 group-hover:scale-105"
                        />
                    </a>
                    
                    <h1 id="main-heading" class="text-3xl md:text-4xl lg:text-5xl font-extrabold text-white tracking-tight mb-3 md:mb-4">
                        {{ __('gdpr::register.register.title') }}
                    </h1>
                    
                    <p class="text-base md:text-lg text-slate-300 max-w-2xl">
                        {{ __('gdpr::register.register.subtitle') }}
                    </p>
                </header>

                {{-- Stats Bar (compact on mobile) --}}
                <section aria-label="{{ __('Statistics') }}" class="bg-gradient-to-r from-red-600/20 to-orange-600/20 backdrop-blur-sm rounded-xl p-4 border border-red-500/20">
                    <div class="grid grid-cols-3 gap-2 md:gap-4 text-center">
                        <div>
                            <div class="text-2xl md:text-3xl font-bold text-white">5,000+</div>
                            <div class="text-xs text-slate-300">{{ __('gdpr::register.stats.active_developers') }}</div>
                        </div>
                        <div>
                            <div class="text-2xl md:text-3xl font-bold text-white">100+</div>
                            <div class="text-xs text-slate-300">{{ __('gdpr::register.stats.monthly_meetups') }}</div>
                        </div>
                        <div>
                            <div class="text-2xl md:text-3xl font-bold text-white">24/7</div>
                            <div class="text-xs text-slate-300">{{ __('gdpr::register.stats.community_support') }}</div>
                        </div>
                    </div>
                </section>

                {{-- Main Content Grid: Form on top (mobile), Benefits below --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-start">
                    
                    {{-- Registration Form (first on mobile for conversion) --}}
                    <section aria-labelledby="register-form-heading" class="order-1 lg:order-2">
                        <div class="bg-slate-800/90 backdrop-blur-xl shadow-2xl rounded-2xl p-6 md:p-8 border border-slate-700/50">
                            <h2 id="register-form-heading" class="sr-only">{{ __('Registration Form') }}</h2>
                            
                            <div class="text-center mb-6">
                                <p class="text-lg font-bold text-white mb-1">{{ __('gdpr::register.form.cta_title') }}</p>
                                <p class="text-sm text-slate-400">{{ __('gdpr::register.form.cta_subtitle') }}</p>
                            </div>
                            
                            @livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
                            
                            <p class="text-xs text-center text-slate-500 mt-4">
                                {{ __('gdpr::register.form.terms_notice') }}
                            </p>
                        </div>
                    </section>

                    {{-- Benefits Section (second on mobile) --}}
                    <section aria-labelledby="benefits-heading" class="order-2 lg:order-1">
                        <h2 id="benefits-heading" class="sr-only">{{ __('Benefits') }}</h2>
                        
                        <div class="space-y-4 md:space-y-6">
                            {{-- Benefit 1 --}}
                            <article class="flex items-start gap-4 p-4 rounded-xl bg-slate-800/50 border border-slate-700/30 hover:border-red-500/30 transition-all duration-300 group">
                                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-red-500/20 flex items-center justify-center group-hover:bg-red-500/30 transition-colors" aria-hidden="true">
                                    <svg class="w-6 h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-white text-lg">{{ __('gdpr::register.benefits.community.title') }}</h3>
                                    <p class="text-sm text-slate-400 mt-1">{{ __('gdpr::register.benefits.community.description') }}</p>
                                    <p class="text-xs text-red-400 font-semibold mt-2">{{ __('gdpr::register.benefits.community.cta') }}</p>
                                </div>
                            </article>

                            {{-- Benefit 2 --}}
                            <article class="flex items-start gap-4 p-4 rounded-xl bg-slate-800/50 border border-slate-700/30 hover:border-orange-500/30 transition-all duration-300 group">
                                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-orange-500/20 flex items-center justify-center group-hover:bg-orange-500/30 transition-colors" aria-hidden="true">
                                    <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-white text-lg">{{ __('gdpr::register.benefits.tutorials.title') }}</h3>
                                    <p class="text-sm text-slate-400 mt-1">{{ __('gdpr::register.benefits.tutorials.description') }}</p>
                                    <p class="text-xs text-orange-400 font-semibold mt-2">{{ __('gdpr::register.benefits.tutorials.cta') }}</p>
                                </div>
                            </article>

                            {{-- Benefit 3 --}}
                            <article class="flex items-start gap-4 p-4 rounded-xl bg-slate-800/50 border border-slate-700/30 hover:border-green-500/30 transition-all duration-300 group">
                                <div class="flex-shrink-0 w-12 h-12 rounded-xl bg-green-500/20 flex items-center justify-center group-hover:bg-green-500/30 transition-colors" aria-hidden="true">
                                    <svg class="w-6 h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <h3 class="font-bold text-white text-lg">{{ __('gdpr::register.benefits.networking.title') }}</h3>
                                    <p class="text-sm text-slate-400 mt-1">{{ __('gdpr::register.benefits.networking.description') }}</p>
                                    <p class="text-xs text-green-400 font-semibold mt-2">{{ __('gdpr::register.benefits.networking.cta') }}</p>
                                </div>
                            </article>

                            {{-- Social Proof --}}
                            <div class="pt-4 border-t border-slate-700/50">
                                <div class="flex items-center justify-center lg:justify-start gap-4">
                                    <div class="flex -space-x-3" aria-hidden="true">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-red-400 to-orange-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold">A</div>
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold">M</div>
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-green-400 to-teal-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold">R</div>
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 border-2 border-slate-800 flex items-center justify-center text-xs text-white font-bold">+</div>
                                    </div>
                                    <span class="text-sm text-slate-300">{{ __('gdpr::register.social_proof') }}</span>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </main>

    <style>
        @keyframes float {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(5deg); }
        }
        @keyframes float-reverse {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            50% { transform: translateY(20px) rotate(-5deg); }
        }
        .animate-float { animation: float 8s ease-in-out infinite; }
        .animate-float-reverse { animation: float-reverse 10s ease-in-out infinite; }
        .animate-pulse-slow { animation: pulse 4s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
    </style>
</x-layouts.app>
