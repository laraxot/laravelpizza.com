<x-layouts.app>
    <x-slot name="title">
        {{ __('Login') }}
    </x-slot>

    <!-- AGID Login Section -->
    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-primary-50 to-primary-100 dark:from-gray-900 dark:to-gray-800 py-12 px-4 sm:px-6 lg:px-8">
        <div class="w-full max-w-md">
            {{-- Logo/Brand Header --}}

            {{-- Login Widget Filament 4 --}}
            <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg overflow-hidden">
                @livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
            </div>

            <!-- Beautiful Registration CTA -->
            @if (Route::has('register'))
                <div class="registration-cta mt-8 fade-in-up">
                    <p class="text-gray-700 mb-4 font-medium">
                        {{ __('Non hai ancora un account?') }}
                    </p>
                    <a href="{{ route('register') }}" class="registration-button">
                        {{ __('Crea il tuo account') }}
                        <svg class="ml-2 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>
            @endif

            {{-- Alternative Access Methods (Currently Commented Out)
            <div class="mt-8 space-y-4 fade-in-up">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full border-t border-white/30"></div>
                    </div>
                    <div class="relative flex justify-center text-sm">
                        <span class="px-4 bg-white/90 text-gray-700 font-semibold rounded-full backdrop-blur">{{ __('Oppure accedi con') }}</span>
                    </div>
                </div>

                <!-- SPID Button -->
                <button type="button" class="alt-login-button spid-button" disabled>
                    <img src="https://www.spid.gov.it/assets/img/spid-ico-circle-bb.svg" alt="SPID" class="h-5 w-5 mr-2">
                    {{ __('Entra con SPID') }}
                    <span class="ml-2 text-xs opacity-60">({{ __('Prossimamente') }})</span>
                </button>

                <!-- CIE Button -->
                <button type="button" class="alt-login-button cie-button" disabled>
                    <svg class="h-5 w-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                    {{ __('Entra con CIE 3.0') }}
                    <span class="ml-2 text-xs opacity-60">({{ __('Prossimamente') }})</span>
                </button>
            </div>

            <!-- Beautiful Accessibility Footer -->
            <div class="text-center text-xs text-white/80 mt-8 p-4 bg-white/10 rounded-xl border border-white/20 backdrop-blur-sm fade-in-up">
                <p class="mb-2">
                    <strong>{{ __('Accessibilità') }}:</strong> {{ __('Conforme a WCAG 2.1 AA') }} •
                    <a href="{{ route('pages.view', ['slug' => 'accessibility']) }}"
                       class="text-white underline hover:text-blue-100 transition-colors">
                        {{ __('Dichiarazione di accessibilità') }}
                    </a>
                </p>
                <p>
                    <strong>{{ __('Navigazione') }}:</strong> {{ __('Tab per spostarsi • Invio per confermare') }}
                </p>
            </div>
            --}}
        </div>
    </section>

</x-layouts.app>
