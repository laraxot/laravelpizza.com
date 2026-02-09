<?php

use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('register');

?>

<x-layouts.app>
    <x-slot name="title">
        {{ __('Registrazione') }}
    </x-slot>

    <!-- Refactored Register Section matching Login style -->
    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            
            {{-- GDPR-Compliant Register Widget --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                @livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
            </div>

            <!-- Login CTA -->
            <div class="mt-8 text-center fade-in-up">
                <p class="text-gray-700 dark:text-gray-300 mb-4 font-medium">
                    {{ __('Hai già un account?') }}
                </p>
                <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-primary-600 bg-white hover:bg-gray-50 dark:bg-gray-800 dark:text-primary-400 dark:hover:bg-gray-700 shadow-sm transition duration-150 ease-in-out">
                    {{ __('Accedi al tuo account') }}
                    <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"></path>
                    </svg>
                </a>
            </div>

        </div>
    </section>

</x-layouts.app>
