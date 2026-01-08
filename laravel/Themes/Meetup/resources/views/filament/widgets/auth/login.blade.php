{{-- Vista per il LoginWidget nel tema Sixteen --}}
{{-- Design ispirato a https://docs.italia.it/accounts/login/ --}}
{{-- Conforme AGID Bootstrap Italia + Filament 4.x --}}

<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-6">
            {{-- Header del form --}}
            <div class="text-center mb-6">
                <h2 class="text-2xl font-bold text-italia-gray-900 dark:text-white">
                    {{ __('user::auth.login.title') }}
                </h2>
                <p class="mt-2 text-sm text-italia-gray-600 dark:text-gray-400">
                    {{ __('user::auth.login.subtitle') }}
                </p>
            </div>
            {{-- Form renderizzato dal widget Filament 4 --}}
            <form wire:submit="login" class="space-y-6">
                {{ $this->form }}

                {{-- Submit Button AGID Style --}}
                <div class="mt-6">
                    <button 
                        type="submit" 
                        wire:loading.attr="disabled"
                        class="w-full flex justify-center items-center gap-2 py-3 px-4 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200"
                    >
                        <svg wire:loading class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span>{{ __('user::auth.login.submit') }}</span>
                    </button>
                </div>
            </form>

            {{-- Links AGID Style --}}
            <div class="mt-6 space-y-4 text-center text-sm">
                <p class="text-italia-gray-600 dark:text-gray-400">
                    {{ __('user::login.no_account') }}
                    <a 
                        href="{{ url('/' . app()->getLocale() . '/auth/register') }}" 
                        class="font-medium text-primary-600 hover:text-primary-500 underline"
                    >
                        {{ __('user::login.register_now') }}
                    </a>
                </p>
                
                <p class="text-italia-gray-600 dark:text-gray-400">
                    {{ __('user::login.forgot_password_text') }}
                    <a 
                        href="{{ url('/' . app()->getLocale() . '/auth/password/reset') }}" 
                        class="font-medium text-primary-600 hover:text-primary-500 underline"
                    >
                        {{ __('user::login.reset_it') }}
                    </a>
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
