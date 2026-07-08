{{-- Vista per il LoginWidget nel tema Zero --}}
{{-- Questa vista è minimalista e focalizzata solo sul layout/styling --}}

<x-filament-widgets::widget>
    <div class="space-y-6">
        {{-- Header del form --}}
        <div class="text-center">
            <h2 class="text-xl font-semibold text-gray-900">
                {{ __('Accedi al tuo account') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Inserisci le tue credenziali per accedere') }}!
            </p>
        </div>

        {{-- Form renderizzato dal widget --}}
        <form wire:submit="login" class="space-y-4">
            {{ $this->form }}

            {{-- Remember Me & Forgot Password --}}
            <div class="flex items-center justify-between">
                <div class="text-sm">
                    <a 
                        href="{{ route('password.request') }}" 
                        class="font-medium text-blue-600 hover:text-blue-500 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded"
                    >
                        {{ __('Password dimenticata?') }}
                    </a>
                </div>
            </div>

            {{-- Submit Button --}}
            <div>
                <button 
                    type="submit" 
                    wire:loading.attr="disabled"
                    class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 shadow-sm hover:shadow-md"
                >
                    {{-- Loading Spinner --}}
                    <svg wire:loading class="animate-spin -ml-1 mr-3 h-5 w-5 text-white" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    
                    {{-- Login Icon --}}
                    <svg wire:loading.remove class="absolute left-0 inset-y-0 flex items-center pl-3 h-5 w-5 text-blue-500 group-hover:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    
                    <span wire:loading.remove>{{ __('Accedi') }}</span>
                    <span wire:loading>{{ __('Accesso in corso...') }}</span>
                </button>
            </div>
        </form>

        {{-- Divider --}}
        <div class="mt-6">
            <div class="relative">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-300"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-500">{{ __('oppure') }}</span>
                </div>
            </div>
        </div>

        {{-- Social Login (se implementato) --}}
        <div class="grid grid-cols-2 gap-3">
            <button 
                type="button"
                class="w-full inline-flex justify-center items-center gap-2 py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
            >
                <x-filament::icon icon="ui-google" class="w-5 h-5 flex-shrink-0" />
                <span>{{ __('Google') }}</span>
            </button>

            <button 
                type="button"
                class="w-full inline-flex justify-center items-center gap-2 py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors"
            >
                <x-filament::icon icon="ui-brands.github" class="w-5 h-5 flex-shrink-0" />
                <span>{{ __('GitHub') }}</span>
            </button>
        </div>
    </div>
</x-filament-widgets::widget> 