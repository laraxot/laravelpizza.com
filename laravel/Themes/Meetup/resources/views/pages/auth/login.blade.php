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

           
        </div>
    </section>

</x-layouts.app>
