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

    <section
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-950 via-slate-900 to-red-950 relative overflow-hidden py-12 px-4"
        aria-labelledby="register-heading"
    >
        @include('pub_theme::components.ui.particles')
        
        <div class="absolute inset-0 overflow-hidden pointer-events-none" aria-hidden="true">
            <div class="absolute -top-48 -right-32 w-80 h-80 bg-red-500/10 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-48 -left-36 w-80 h-80 bg-orange-500/10 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
            <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-[28rem] h-[28rem] bg-red-600/5 rounded-full blur-3xl"></div>
        </div>

        <div class="w-full max-w-6xl mx-auto relative z-10">
            <div class="space-y-10">
                <div class="text-center space-y-6">
                    <a href="{{ \LaravelLocalization::localizeUrl('/') }}" class="inline-block group" aria-label="{{ config('app.name') }}">
                        <x-filament::icon
                            icon="meetup-logo"
                            class="h-16 w-auto md:h-20 text-red-500 transition-transform duration-300 group-hover:scale-110"
                        />
                    </a>

                    <div class="space-y-3">
                        <h1
                            id="register-heading"
                            class="text-4xl sm:text-5xl font-extrabold tracking-tight text-white"
                        >
                            {{ __('gdpr::register.title') }}
                        </h1>
                        <p class="text-base sm:text-lg text-slate-200 max-w-3xl mx-auto">
                            {{ __('gdpr::register.subtitle') }}
                        </p>
                    </div>
                </div>

                <div class="bg-slate-900/80 backdrop-blur-xl shadow-2xl rounded-2xl p-6 sm:p-8 md:p-10 border border-slate-800/70 w-full mx-auto max-w-2xl">
                    <div class="text-center mb-6 space-y-1">
                        <h2 class="text-2xl font-bold text-white">{{ __('gdpr::register.form.cta_title') }}</h2>
                        <p class="text-sm text-slate-400">{{ __('gdpr::register.form.cta_subtitle') }}</p>
                    </div>
                    @livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
                    <p class="mt-4 text-center text-xs text-slate-500">{{ __('gdpr::register.form.terms_notice') }}</p>
                </div>

                <div class="grid md:grid-cols-3 gap-5">
                    <article class="flex gap-4 bg-white/5 border border-white/10 rounded-xl p-4 hover:border-red-400/50 transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-red-500/20 flex items-center justify-center mt-1 text-red-300">
                            <x-filament::icon icon="heroicon-o-users" class="w-6 h-6" />
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-semibold text-white">{{ __('gdpr::register.benefits.community.title') }}</h3>
                            <p class="text-sm text-slate-300">{{ __('gdpr::register.benefits.community.description') }}</p>
                        </div>
                    </article>

                    <article class="flex gap-4 bg-white/5 border border-white/10 rounded-xl p-4 hover:border-orange-400/50 transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-orange-500/20 flex items-center justify-center mt-1 text-orange-300">
                            <x-filament::icon icon="heroicon-o-academic-cap" class="w-6 h-6" />
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-semibold text-white">{{ __('gdpr::register.benefits.tutorials.title') }}</h3>
                            <p class="text-sm text-slate-300">{{ __('gdpr::register.benefits.tutorials.description') }}</p>
                        </div>
                    </article>

                    <article class="flex gap-4 bg-white/5 border border-white/10 rounded-xl p-4 hover:border-green-400/50 transition-colors">
                        <div class="w-10 h-10 rounded-xl bg-green-500/20 flex items-center justify-center mt-1 text-green-300">
                            <x-filament::icon icon="heroicon-o-briefcase" class="w-6 h-6" />
                        </div>
                        <div class="space-y-1">
                            <h3 class="font-semibold text-white">{{ __('gdpr::register.benefits.networking.title') }}</h3>
                            <p class="text-sm text-slate-300">{{ __('gdpr::register.benefits.networking.description') }}</p>
                        </div>
                    </article>
                </div>

                <div class="text-center pt-6 border-t border-slate-800/60">
                    <p class="text-sm text-slate-300">
                        {{ __('gdpr::register.already_registered') }}
                        <a href="{{ \LaravelLocalization::localizeUrl('/auth/login') }}"
                           class="font-bold text-red-400 hover:text-red-300 transition-colors ml-1">
                            {{ __('gdpr::register.login') }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
