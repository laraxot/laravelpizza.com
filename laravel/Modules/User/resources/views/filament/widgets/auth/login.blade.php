<?php

declare(strict_types=1);

?>
{{--
    View: user::filament.widgets.auth.login
    Scopo: Widget di login Filament conforme a Windsurf/Xot
    Modifica liberamente questa struttura per UX custom
--}}
<div class="filament-widget-login space-y-6">
    <form wire:submit.prevent="save" class="space-y-4">
        {{ $this->form }}
        
        <div class="flex items-center justify-between mt-3">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" wire:model="remember" class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700">
                    {{ __('Ricordami') }}
                </label>
            </div>
        </div>

        <button type="submit" class="w-full py-3 rounded-lg bg-blue-600 text-white font-bold hover:bg-blue-700 transition-colors duration-200 ease-in-out shadow-sm flex justify-center items-center gap-2">
            <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
            </svg>
            {{ __('Accedi') }}
        </button>
    </form>

    <div class="text-center text-sm text-gray-600 mt-2">
        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="text-blue-600 hover:text-blue-800 hover:underline transition-colors duration-200">{{ __('Password dimenticata?') }}</a>
        @endif
    </div>
</div>
