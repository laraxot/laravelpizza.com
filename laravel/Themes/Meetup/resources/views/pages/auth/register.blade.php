<?php

declare(strict_types=1);

use function Laravel\Folio\{middleware, name};

middleware(['guest']);
name('register');

?>

<x-layouts.app>
    <x-slot name="title">
        {{ __('Crea il tuo account') }}
    </x-slot>

    <!-- WCAG Compliant Register Section with improved UX -->
    <section 
        class="min-h-screen bg-gradient-to-br from-primary-50 to-primary-100 dark:from-gray-900 dark:to-gray-800 py-8 px-4 sm:px-6 lg:px-8"
        aria-labelledby="register-heading"
    >
        <div class="w-full max-w-4xl mx-auto">
            
            <!-- Header with clear visual hierarchy -->
            <div class="text-center mb-8">
                <h1 
                    id="register-heading" 
                    class="text-3xl sm:text-4xl font-bold text-gray-900 dark:text-white mb-3"
                >
                    {{ __('Crea il tuo account') }}
                </h1>
                <p class="text-lg text-gray-600 dark:text-gray-400 max-w-2xl mx-auto">
                    {{ __('Registrati per accedere a tutte le funzionalità della piattaforma') }}
                </p>
            </div>

            <!-- Main Form Container - Wider and Better Structured -->
            <div 
                class="bg-white dark:bg-gray-800 shadow-2xl rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700"
                role="form"
                aria-label="{{ __('Form di registrazione') }}"
            >
                <!-- Progress Indicator (WCAG: Status Feedback) -->
                <div 
                    class="bg-primary-50 dark:bg-primary-900/30 px-6 py-4 border-b border-primary-100 dark:border-primary-800"
                    aria-label="{{ __('Progresso registrazione') }}"
                >
                    <div class="flex items-center space-x-4">
                        <div class="flex items-center">
                            <span 
                                class="w-8 h-8 rounded-full bg-primary-600 text-white flex items-center justify-center text-sm font-semibold"
                                aria-current="step"
                            >
                                1
                            </span>
                            <span class="ml-2 text-sm font-medium text-primary-700 dark:text-primary-300">
                                {{ __('Dati personali') }}
                            </span>
                        </div>
                        <div class="flex-1 h-1 bg-primary-200 dark:bg-primary-800 rounded">
                            <div class="h-full w-full bg-primary-600 rounded"></div>
                        </div>
                        <div class="flex items-center opacity-60">
                            <span class="w-8 h-8 rounded-full bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-300 flex items-center justify-center text-sm font-semibold">
                                2
                            </span>
                            <span class="ml-2 text-sm font-medium text-gray-500 dark:text-gray-400">
                                {{ __('Conferma') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- GDPR-Compliant Register Widget -->
                <div class="p-6 sm:p-8">
                    @livewire(\Modules\Gdpr\Filament\Widgets\Auth\RegisterWidget::class)
                </div>
            </div>

            <!-- Login CTA - Better spacing and contrast -->
            <div 
                class="mt-8 text-center bg-white/50 dark:bg-gray-800/50 rounded-lg p-6 backdrop-blur-sm"
                role="complementary"
                aria-label="{{ __('Accesso alternativo') }}"
            >
                <p class="text-gray-700 dark:text-gray-300 mb-4 font-medium text-lg">
                    {{ __('Hai già un account?') }}
                </p>
                <a 
                    href="{{ route('login') }}" 
                    class="inline-flex items-center justify-center px-8 py-3 border-2 border-primary-600 text-base font-semibold rounded-lg text-primary-600 bg-white hover:bg-primary-50 dark:bg-gray-800 dark:text-primary-400 dark:hover:bg-gray-700 dark:border-primary-500 transition duration-200 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 min-h-[48px]"
                    aria-label="{{ __('Vai alla pagina di accesso') }}"
                >
                    {{ __('Accedi al tuo account') }}
                    <svg 
                        class="ml-2 h-5 w-5" 
                        fill="none" 
                        stroke="currentColor" 
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14"></path>
                    </svg>
                </a>
            </div>

            <!-- Trust Indicators (UX: Social Proof) -->
            <div class="mt-8 text-center">
                <div class="flex items-center justify-center space-x-6 text-sm text-gray-500 dark:text-gray-400">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('Dati protetti con crittografia SSL') }}
                    </div>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-1 text-green-500" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                            <path fill-rule="evenodd" d="M2.166 4.999A11.954 11.954 0 0010 1.944 11.954 11.954 0 0017.834 5c.11.65.166 1.32.166 2.001 0 5.225-3.34 9.67-8 11.317C5.34 16.67 2 12.225 2 7c0-.682.057-1.35.166-2.001zm11.541 3.708a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                        </svg>
                        {{ __('GDPR Compliant') }}
                    </div>
                </div>
            </div>

        </div>
    </section>

</x-layouts.app>
