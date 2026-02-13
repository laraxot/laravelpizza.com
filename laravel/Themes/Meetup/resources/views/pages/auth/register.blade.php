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

    {{-- Full-width layout with animated background optimized for mobile/tablet --}}
    <main 
        class="min-h-screen relative overflow-x-hidden bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 dark:from-slate-950 dark:via-slate-900 dark:to-red-950"
        role="main"
        aria-labelledby="main-heading"
    >
        {{-- Animated Background Elements (GPU accelerated, reduced motion support) --}}
        <div class="absolute inset-0 pointer-events-none overflow-hidden" aria-hidden="true">
            <div class="absolute -top-20 -right-20 w-40 h-40 md:w-64 md:h-64 lg:w-80 lg:h-80 bg-red-500/10 rounded-full blur-2xl md:blur-3xl animate-blob"></div>
            <div class="absolute -bottom-20 -left-20 w-40 h-40 md:w-64 md:h-64 lg:w-80 lg:h-80 bg-orange-500/10 rounded-full blur-2xl md:blur-3xl animate-blob animation-delay-2000"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-96 bg-red-600/5 rounded-full blur-3xl animate-pulse-slow"></div>
            
            {{-- Floating particles for depth --}}
            <div class="absolute top-1/4 right-1/3 w-2 h-2 bg-red-400/30 rounded-full animate-float-particle"></div>
            <div class="absolute bottom-1/3 left-1/4 w-3 h-3 bg-orange-400/20 rounded-full animate-float-particle-reverse"></div>
            <div class="absolute top-1/2 right-1/4 w-2 h-2 bg-red-500/20 rounded-full animate-float-particle animation-delay-1000"></div>
            
            {{-- Pizza slice shapes --}}
            <div class="absolute top-20 left-10 w-8 h-8 opacity-10 animate-spin-slow">
                <svg viewBox="0 0 24 24" fill="currentColor" class="text-orange-400">
                    <path d="M12 2C6.48 2 2 6.48 2 12c0 5.52 4.48 10 10 10 5.52 0 10-4.48 10-10 0-5.52-4.48-10-10-10zm0 18c-4.41 0-8-3.59-8-8 0-4.41 3.59-8 8-8 4.41 0 8 3.59 8 8 0 4.41-3.59 8-8 8z"/>
                </svg>
            </div>
            <div class="absolute bottom-32 right-16 w-6 h-6 opacity-10 animate-spin-slow-reverse">
                <svg viewBox="0 0 24 24" fill="currentColor" class="text-red-400">
                    <path d="M12 2C6.48 2 2 6.48 2 12c0 5.52 4.48 10 10 10 5.52 0 10-4.48 10-10 0-5.52-4.48-10-10-10zm0 18c-4.41 0-8-3.59-8-8 0-4.41 3.59-8 8-8 4.41 0 8 3.59 8 8 0 4.41-3.59 8-8 8z"/>
                </svg>
            </div>
        </div>

        <div class="relative z-10 px-3 py-6 md:px-4 md:py-8 lg:py-10">
            {{-- Centered single column layout --}}
            <div class="max-w-7xl mx-auto space-y-6 md:space-y-8">
                
                {{-- Header Section --}}
                <header class="text-center">
                    <a href="{{ \LaravelLocalization::localizeUrl('/') }}" class="inline-block mb-3 md:mb-4 group" aria-label="{{ config('app.name') }}">
                        <x-filament::icon
                            icon="meetup-logo"
                            class="h-14 w-auto md:h-16 lg:h-20 text-red-500 transition-transform duration-300 group-hover:scale-105"
                        />
                    </a>
                    
                    <h1 id="main-heading" class="text-2xl md:text-3xl lg:text-4xl font-extrabold text-white tracking-tight mb-2 md:mb-3 px-2">
                        {{ __('gdpr::register.title') }}
                    </h1>
                    
                    <p class="text-sm md:text-base text-slate-300 max-w-lg mx-auto px-4">
                        {{ __('gdpr::register.subtitle') }}
                    </p>
                </header>

                {{-- Trust Badges (key value propositions) --}}
                <section class="grid grid-cols-1 sm:grid-cols-3 gap-3 md:gap-4" aria-label="{{ __('gdpr::register.sections.trust_badges') }}">
                    <div class="flex items-center gap-3 bg-slate-800/60 border border-slate-700/40 rounded-xl p-3">
                        <div class="w-10 h-10 rounded-full bg-green-500/20 flex items-center justify-center text-green-300" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                        </div>
                        <p class="text-sm text-slate-200 leading-snug">{{ __('gdpr::register.stats.active_developers') }}</p>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-800/60 border border-slate-700/40 rounded-xl p-3">
                        <div class="w-10 h-10 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-300" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        </div>
                        <p class="text-sm text-slate-200 leading-snug">{{ __('gdpr::register.stats.monthly_meetups') }}</p>
                    </div>
                    <div class="flex items-center gap-3 bg-slate-800/60 border border-slate-700/40 rounded-xl p-3">
                        <div class="w-10 h-10 rounded-full bg-purple-500/20 flex items-center justify-center text-purple-300" aria-hidden="true">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z" /></svg>
                        </div>
                        <p class="text-sm text-slate-200 leading-snug">{{ __('gdpr::register.stats.community_support') }}</p>
                    </div>
                </section>

                {{-- Registration Form (full width) --}}
                <section aria-labelledby="register-form-heading" class="mx-2 md:mx-0">
                    <div class="bg-slate-800/90 backdrop-blur-xl shadow-2xl rounded-xl md:rounded-2xl p-4 md:p-6 lg:p-8 border border-slate-700/50">
                        <h2 id="register-form-heading" class="sr-only">{{ __('gdpr::register.sections.registration_form') }}</h2>
                        
                        <div class="text-center mb-4 md:mb-6">
                            <p class="text-lg md:text-xl font-bold text-white mb-1">{{ __('gdpr::register.form.cta_title') }}</p>
                            <p class="text-sm text-slate-400">{{ __('gdpr::register.form.cta_subtitle') }}</p>
                        </div>
                        
                        @livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
                        
                        <p class="text-xs text-center text-slate-500 mt-4">
                            {{ __('gdpr::register.form.terms_notice') }}
                        </p>
                    </div>
                </section>

                {{-- Benefits Section (collapsed on mobile, expandable or always visible below form) --}}
                <section aria-labelledby="benefits-heading" class="mx-2 md:mx-0">
                    <h2 id="benefits-heading" class="sr-only">{{ __('gdpr::register.sections.benefits') }}</h2>
                    
                    <div class="space-y-3 md:space-y-4">
                        {{-- Benefit 1 --}}
                        <article class="flex items-start gap-3 md:gap-4 p-3 md:p-4 rounded-lg md:rounded-xl bg-slate-800/50 border border-slate-700/30 hover:border-red-500/30 transition-all duration-300 group">
                            <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 rounded-lg md:rounded-xl bg-red-500/20 flex items-center justify-center group-hover:bg-red-500/30 transition-colors" aria-hidden="true">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-white text-sm md:text-base">{{ __('gdpr::register.benefits.community.title') }}</h3>
                                <p class="text-xs md:text-sm text-slate-400 mt-0.5 md:mt-1">{{ __('gdpr::register.benefits.community.description') }}</p>
                                <p class="text-xs text-red-400 font-semibold mt-1 md:mt-2">{{ __('gdpr::register.benefits.community.cta') }}</p>
                            </div>
                        </article>

                        {{-- Benefit 2 --}}
                        <article class="flex items-start gap-3 md:gap-4 p-3 md:p-4 rounded-lg md:rounded-xl bg-slate-800/50 border border-slate-700/30 hover:border-orange-500/30 transition-all duration-300 group">
                            <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 rounded-lg md:rounded-xl bg-orange-500/20 flex items-center justify-center group-hover:bg-orange-500/30 transition-colors" aria-hidden="true">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-white text-sm md:text-base">{{ __('gdpr::register.benefits.tutorials.title') }}</h3>
                                <p class="text-xs md:text-sm text-slate-400 mt-0.5 md:mt-1">{{ __('gdpr::register.benefits.tutorials.description') }}</p>
                                <p class="text-xs text-orange-400 font-semibold mt-1 md:mt-2">{{ __('gdpr::register.benefits.tutorials.cta') }}</p>
                            </div>
                        </article>

                        {{-- Benefit 3 --}}
                        <article class="flex items-start gap-3 md:gap-4 p-3 md:p-4 rounded-lg md:rounded-xl bg-slate-800/50 border border-slate-700/30 hover:border-green-500/30 transition-all duration-300 group">
                            <div class="flex-shrink-0 w-10 h-10 md:w-12 md:h-12 rounded-lg md:rounded-xl bg-green-500/20 flex items-center justify-center group-hover:bg-green-500/30 transition-colors" aria-hidden="true">
                                <svg class="w-5 h-5 md:w-6 md:h-6 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-bold text-white text-sm md:text-base">{{ __('gdpr::register.benefits.networking.title') }}</h3>
                                <p class="text-xs md:text-sm text-slate-400 mt-0.5 md:mt-1">{{ __('gdpr::register.benefits.networking.description') }}</p>
                                <p class="text-xs text-green-400 font-semibold mt-1 md:mt-2">{{ __('gdpr::register.benefits.networking.cta') }}</p>
                            </div>
                        </article>

                        {{-- Social Proof --}}
                        <div class="pt-3 md:pt-4 border-t border-slate-700/50">
                            <div class="flex items-center justify-center gap-3 md:gap-4">
                                <div class="flex -space-x-2" aria-hidden="true">
                                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gradient-to-br from-red-400 to-orange-500 border-2 border-slate-800 flex items-center justify-center text-[10px] md:text-xs text-white font-bold">A</div>
                                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gradient-to-br from-blue-400 to-indigo-500 border-2 border-slate-800 flex items-center justify-center text-[10px] md:text-xs text-white font-bold">M</div>
                                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gradient-to-br from-green-400 to-teal-500 border-2 border-slate-800 flex items-center justify-center text-[10px] md:text-xs text-white font-bold">R</div>
                                    <div class="w-8 h-8 md:w-10 md:h-10 rounded-full bg-gradient-to-br from-purple-400 to-pink-500 border-2 border-slate-800 flex items-center justify-center text-[10px] md:text-xs text-white font-bold">+</div>
                                </div>
                                <span class="text-xs md:text-sm text-slate-300">{{ __('gdpr::register.social_proof') }}</span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </main>

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
