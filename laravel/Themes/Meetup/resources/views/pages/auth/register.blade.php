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
        class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-50 via-blue-50 to-indigo-50 dark:from-slate-900 dark:via-slate-800 dark:to-indigo-900 py-12 px-4 sm:px-6 lg:px-8"
        aria-labelledby="register-heading"
    >
        <div class="w-full max-w-3xl space-y-8">

            <div class="text-center">
                <a href="{{ \LaravelLocalization::localizeUrl('/') }}" class="inline-block mb-6 group" aria-label="{{ config('app.name') }}">
                    <x-filament::icon
                        icon="meetup-logo"
                        class="h-16 w-auto mx-auto text-primary-600 dark:text-primary-400 transition-transform duration-300 group-hover:scale-110"
                    />
                </a>
                <h1
                    id="register-heading"
                    class="text-3xl sm:text-4xl font-bold tracking-tight text-gray-900 dark:text-white"
                >
                    {{ __('gdpr::register.register.title') }}
                </h1>
                <p class="mt-3 text-base text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
                    {{ __('gdpr::register.register.subtitle') }}
                </p>
                <div class="mt-5 text-center">
                    <p class="text-sm font-semibold text-primary-600 dark:text-primary-400">
                        Trusted by thousands of developers and pizza enthusiasts worldwide!
                    </p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-2xl rounded-3xl p-8 sm:p-12 border border-gray-200 dark:border-gray-700 backdrop-blur-sm bg-opacity-95">
                @livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
            </div>

        </div>
    </section>

</x-layouts.app>
