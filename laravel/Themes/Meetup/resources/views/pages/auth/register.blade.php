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
        {{ __('gdpr::register.title') }} - LaravelPizza Community
    </x-slot>

    <x-slot name="description">
        {{ __('gdpr::register.subtitle') }}
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
        {{-- Animated Background Elements (GPU accelerated, optimized for mobile) --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            {{-- Animated gradient blobs --}}
            <div class="absolute top-0 left-0 w-full h-full animate-gradient-blob-1 opacity-30"></div>
            <div class="absolute top-0 right-0 w-full h-full animate-gradient-blob-2 opacity-20"></div>
            
            {{-- Floating pizza emojis for depth (mobile-optimized) --}}
            <div class="absolute top-10 left-5 text-4xl animate-float-pizza opacity-20" aria-hidden="true">🍕</div>
            <div class="absolute top-20 right-10 text-3xl animate-float-pizza-delayed opacity-15" aria-hidden="true">🍕</div>
            <div class="absolute bottom-20 left-10 text-4xl animate-float-pizza-reverse opacity-20" aria-hidden="true">🍕</div>
            <div class="absolute bottom-10 right-5 text-3xl animate-float-pizza-delayed-2 opacity-15" aria-hidden="true">🍕</div>
            
            {{-- Floating geometric shapes --}}
            <div class="absolute top-1/4 left-1/4 w-16 h-16 bg-red-500/10 rounded-full animate-blob-1 opacity-20"></div>
            <div class="absolute top-1/3 right-1/4 w-12 h-12 bg-orange-500/10 rounded-full animate-blob-2 opacity-15"></div>
            <div class="absolute bottom-1/4 left-1/3 w-20 h-20 bg-red-600/5 rounded-full animate-blob-3 opacity-10"></div>
        </div>

        <div class="relative z-10 px-3 py-4 md:px-4 md:py-6 lg:py-8">
            <!-- Centered mobile-first layout -->
            <div class="max-w-3xl md:max-w-4xl lg:max-w-5xl mx-auto space-y-4 md:space-y-6">
                
                <!-- Header Section (compact for mobile) -->
                <header class="text-center py-2 md:py-4">
                    <a href="{{ \LaravelLocalization::localizeUrl('/') }}" class="inline-block mb-2 md:mb-3 group" aria-label="{{ config('app.name') }}">
                        <x-filament::icon
                            icon="meetup-logo"
                            class="h-12 w-auto md:h-14 lg:h-16 text-red-500 transition-transform duration-300 group-hover:scale-105"
                        />
                    </a>
                    
                    <h1 id="main-heading" class="text-xl md:text-2xl lg:text-3xl font-extrabold text-white tracking-tight mb-1 md:mb-2 px-2 leading-tight">
                        {{ __('gdpr::register.title') }}
                    </h1>
                    
                    <p class="text-sm md:text-base text-slate-300 max-w-md mx-auto px-4 leading-relaxed">
                        {{ __('gdpr::register.subtitle') }}
                    </p>
                </header>

                <!-- Registration Form (full width, mobile-optimized) -->
                <section aria-labelledby="register-form-heading" class="mx-0 md:mx-0">
                    <div class="bg-slate-800/95 backdrop-blur-xl shadow-2xl rounded-xl md:rounded-2xl p-4 md:p-6 lg:p-8 border border-slate-700/50">
                        <h2 id="register-form-heading" class="sr-only">{{ __('gdpr::register.sections.registration_form') }}</h2>
                        
                        <div class="text-center mb-3 md:mb-4">
                            <p class="text-lg md:text-xl font-bold text-white mb-1">{{ __('gdpr::register.form.cta_title') }}</p>
                            <p class="text-sm text-slate-400">{{ __('gdpr::register.form.cta_subtitle') }}</p>
                        </div>
                        
                        @livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
                        
                        <p class="text-xs text-center text-slate-500 mt-3 md:mt-4">
                            {{ __('gdpr::register.form.terms_notice') }}
                        </p>
                    </div>
                </section>

                <!-- Benefits Section (compact for mobile) -->
                <section aria-labelledby="benefits-heading" class="mx-0 md:mx-0">
                    <h2 id="benefits-heading" class="sr-only">{{ __('gdpr::register.sections.benefits') }}</h2>
                    
                    <div class="space-y-2 md:space-y-3">
                        <!-- Benefit 1 (compact) -->
                        <article class="flex items-center gap-2 md:gap-3 p-2 md:p-3 rounded-lg bg-slate-800/50 border border-slate-700/30 hover:border-red-500/30 transition-all duration-300 group">
                            <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 rounded-lg bg-red-500/20 flex items-center justify-center group-hover:bg-red-500/30 transition-colors" aria-hidden="true">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-white text-xs md:text-sm">{{ __('gdpr::register.benefits.community.title') }}</h3>
                                <p class="text-xs text-slate-400 mt-0.5">{{ __('gdpr::register.benefits.community.cta') }}</p>
                            </div>
                        </article>

                        <!-- Benefit 2 (compact) -->
                        <article class="flex items-center gap-2 md:gap-3 p-2 md:p-3 rounded-lg bg-slate-800/50 border border-slate-700/30 hover:border-orange-500/30 transition-all duration-300 group">
                            <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 rounded-lg bg-orange-500/20 flex items-center justify-center group-hover:bg-orange-500/30 transition-colors" aria-hidden="true">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-white text-xs md:text-sm">{{ __('gdpr::register.benefits.tutorials.title') }}</h3>
                                <p class="text-xs text-slate-400 mt-0.5">{{ __('gdpr::register.benefits.tutorials.cta') }}</p>
                            </div>
                        </article>

                        <!-- Benefit 3 (compact) -->
                        <article class="flex items-center gap-2 md:gap-3 p-2 md:p-3 rounded-lg bg-slate-800/50 border border-slate-700/30 hover:border-green-500/30 transition-all duration-300 group">
                            <div class="flex-shrink-0 w-8 h-8 md:w-10 md:h-10 rounded-lg bg-green-500/20 flex items-center justify-center group-hover:bg-green-500/30 transition-colors" aria-hidden="true">
                                <svg class="w-4 h-4 md:w-5 md:h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-white text-xs md:text-sm">{{ __('gdpr::register.benefits.networking.title') }}</h3>
                                <p class="text-xs text-slate-400 mt-0.5">{{ __('gdpr::register.benefits.networking.cta') }}</p>
                            </div>
                        </article>
                    </div>
                </section>
            </div>
        </div>
    </main>

    <style>
        @keyframes gradient-blob-1 {
            0%, 100% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
        }
        @keyframes gradient-blob-2 {
            0%, 100% { background-position: 50% 0%; }
            50% { background-position: 50% 100%; }
        }
        @keyframes blob-1 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(10px, -10px) scale(1.1); }
        }
        @keyframes blob-2 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-10px, 10px) scale(0.9); }
        }
        @keyframes blob-3 {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(5px, -5px) scale(1.05); }
        }
        @keyframes float-pizza {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.2; }
            50% { transform: translateY(-10px) rotate(5deg); opacity: 0.3; }
        }
        @keyframes float-pizza-delayed {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.15; }
            50% { transform: translateY(-8px) rotate(-5deg); opacity: 0.25; }
        }
        @keyframes float-pizza-delayed-2 {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.1; }
            50% { transform: translateY(12px) rotate(3deg); opacity: 0.2; }
        }
        @keyframes float-pizza-reverse {
            0%, 100% { transform: translateY(0) rotate(0deg); opacity: 0.15; }
            50% { transform: translateY(8px) rotate(-3deg); opacity: 0.25; }
        }
        .animate-gradient-blob-1 {
            background: radial-gradient(circle at center, rgba(239, 68, 68, 0.15), transparent);
            background-size: 200% 200%;
            animation: gradient-blob-1 15s ease-in-out infinite;
        }
        .animate-gradient-blob-2 {
            background: radial-gradient(circle at center, rgba(249, 115, 22, 0.15), transparent);
            background-size: 200% 200%;
            animation: gradient-blob-2 12s ease-in-out infinite;
        }
        .animate-blob-1 {
            animation: blob-1 8s ease-in-out infinite;
        }
        .animate-blob-2 {
            animation: blob-2 10s ease-in-out infinite;
        }
        .animate-blob-3 {
            animation: blob-3 12s ease-in-out infinite;
        }
        .animate-float-pizza {
            animation: float-pizza 4s ease-in-out infinite;
        }
        .animate-float-pizza-delayed {
            animation: float-pizza-delayed 5s ease-in-out infinite;
        }
        .animate-float-pizza-delayed-2 {
            animation: float-pizza-delayed-2 6s ease-in-out infinite;
        }
        .animate-float-pizza-reverse {
            animation: float-pizza-reverse 5s ease-in-out infinite;
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-gradient-blob-1,
            .animate-gradient-blob-2,
            .animate-blob-1,
            .animate-blob-2,
            .animate-blob-3,
            .animate-float-pizza,
            .animate-float-pizza-delayed,
            .animate-float-pizza-delayed-2,
            .animate-float-pizza-reverse {
                animation: none;
            }
        }
    </style>

    <style>
        @keyframes blob {
            0%, 100% { transform: translate(0, 0) scale(1); }
            33% { transform: translate(10px, -10px) scale(1.05); }
            66% { transform: translate(-5px, 10px) scale(0.95); }
        }
        @keyframes float-particle {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.3; }
            50% { transform: translateY(-15px) translateX(5px); opacity: 0.6; }
        }
        @keyframes float-particle-reverse {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0.2; }
            50% { transform: translateY(10px) translateX(-5px); opacity: 0.5; }
        }
        @keyframes pulse-slow {
            0%, 100% { opacity: 0.5; transform: translate(-50%, -50%) scale(1); }
            50% { opacity: 0.7; transform: translate(-50%, -50%) scale(1.1); }
        }
        @keyframes spin-slow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .animate-blob {
            animation: blob 12s ease-in-out infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
        .animation-delay-1000 {
            animation-delay: 1s;
        }
        .animate-float-particle {
            animation: float-particle 6s ease-in-out infinite;
        }
        .animate-float-particle-reverse {
            animation: float-particle-reverse 8s ease-in-out infinite;
        }
        .animate-pulse-slow {
            animation: pulse-slow 6s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        .animate-spin-slow {
            animation: spin-slow 20s linear infinite;
        }
        .animate-spin-slow-reverse {
            animation: spin-slow 25s linear infinite reverse;
        }
        
        @media (prefers-reduced-motion: reduce) {
            .animate-blob,
            .animate-float-particle,
            .animate-float-particle-reverse,
            .animate-pulse-slow,
            .animate-spin-slow,
            .animate-spin-slow-reverse {
                animation: none;
            }
        }
    </style>
</x-layouts.app>
