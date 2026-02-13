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

    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 relative overflow-hidden py-12 px-4">
        {{-- Background Elements --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="w-full max-w-2xl mx-auto relative z-10">
            <div class="bg-slate-800/80 backdrop-blur-xl shadow-2xl rounded-2xl p-8 sm:p-12 border border-slate-700/50">
                {{-- Header --}}
                <div class="text-center mb-10">
                    <a href="{{ \LaravelLocalization::localizeUrl('/') }}" class="inline-block mb-6">
                        <x-filament::icon
                            icon="meetup-logo"
                            class="h-16 w-auto text-red-500"
                        />
                    </a>
                    
                    <h1 class="text-3xl sm:text-4xl font-extrabold text-white mb-3">
                        {{ __('gdpr::register.register.title') }}
                    </h1>
                    
                    <p class="text-base text-slate-300">
                        {{ __('gdpr::register.register.subtitle') }}
                    </p>
                </div>

                {{-- Form --}}
                @livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)

                {{-- Login Link --}}
                <div class="text-center mt-8 pt-6 border-t border-slate-700">
                    <p class="text-sm text-slate-400">
                        {{ __('gdpr::register.already_registered') }}
                        <a href="{{ \LaravelLocalization::localizeUrl('/auth/login') }}" 
                           class="font-semibold text-red-400 hover:text-red-300 transition-colors ml-1">
                            {{ __('gdpr::register.login') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>