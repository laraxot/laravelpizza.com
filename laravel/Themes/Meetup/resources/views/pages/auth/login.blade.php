<x-layouts.app>
    <x-slot name="title">
        {{ __('user::login.fields.email.label') }}
    </x-slot>

    <section class="min-h-screen flex items-center justify-center bg-gradient-to-br from-slate-900 via-slate-800 to-red-900 dark:from-slate-950 dark:via-slate-900 dark:to-red-950 relative overflow-hidden">
        {{-- Animated Background --}}
        <div class="absolute inset-0 overflow-hidden pointer-events-none">
            <div class="absolute -top-40 -right-40 w-80 h-80 bg-red-500/20 rounded-full blur-3xl animate-pulse"></div>
            <div class="absolute -bottom-40 -left-40 w-80 h-80 bg-orange-500/20 rounded-full blur-3xl animate-pulse" style="animation-delay: 1s;"></div>
        </div>

        <div class="w-full max-w-md space-y-8 relative z-10 px-4 sm:px-6 lg:px-8">
            {{-- Logo & Header --}}
            <div class="text-center">
                <a href="{{ \LaravelLocalization::localizeUrl('/') }}" class="inline-block mb-6 group">
                    <x-filament::icon
                        icon="meetup-logo"
                        class="h-20 w-auto mx-auto text-red-500 transition-transform duration-300 group-hover:scale-110 drop-shadow-lg"
                    />
                </a>
                
                <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-white drop-shadow-lg">
                    {{ __('Benvenuto!') }}
                </h1>
                <p class="mt-3 text-base text-slate-300">
                    {{ __('Accedi al tuo account') }}
                </p>
            </div>

            {{-- Login Form Card --}}
            <div class="bg-slate-800/80 backdrop-blur-xl shadow-2xl rounded-2xl p-8 border border-slate-700/50">
                @livewire(\Modules\User\Filament\Widgets\Auth\LoginWidget::class)
            </div>

            {{-- Register CTA --}}
            @if (Route::has('register'))
                <div class="text-center">
                    <p class="text-sm text-slate-400">
                        {{ __('Non hai ancora un account?') }}
                        <a href="{{ \LaravelLocalization::localizeUrl('/auth/register') }}" 
                           class="font-semibold text-red-400 hover:text-red-300 transition-colors ml-1 inline-flex items-center gap-1">
                            {{ __('Registrati ora') }}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </p>
                </div>
            @endif
        </div>
    </section>

</x-layouts.app>
