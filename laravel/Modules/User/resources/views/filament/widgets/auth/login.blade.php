<?php

declare(strict_types=1);

?>
{{--
    View: user::filament.widgets.auth.login
    Enhanced UX/UI with modern 2026 design trends
    Features: Social login, micro-interactions, accessibility, mobile-first
--}}
<div class="filament-widget-login space-y-8">
    <!-- Header with Logo and Welcome Message -->
    <div class="text-center space-y-4">
        <div class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-br from-primary-600 to-primary-700 rounded-2xl shadow-lg mb-2">
            <x-filament::icon icon="meetup-logo" class="h-10 w-10 text-white" />
        </div>
        <div>
            <h2 class="text-2xl font-bold text-gray-900 dark:text-white tracking-tight">
                {{ __('user::auth.login.welcome_back') }}
            </h2>
            <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 leading-relaxed">
                {{ __('user::auth.login.welcome_message') }}
            </p>
        </div>
    </div>

    <!-- Social Login Buttons (Primary) -->
    <div class="space-y-3">
        <button
            type="button"
            class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-gray-300 dark:hover:border-gray-600 hover:shadow-md transition-all duration-200 group"
        >
            <svg class="w-5 h-5" viewBox="0 0 24 24">
                <path fill="currentColor" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25-.56l-.45-.24c-.59-.3-.98-.89-1.03-2.2-.08-2.1-.16-4.23-.17-6.34 0-.03.06-.09.15-.22.25-.22.23-.37-.61-.64-.97-1.04-1.92-.45-.89-.71-1.51-1.61-1.96-2.56-.48-1.03-.56-2.09-.38-2.92.2-.85.62-1.38 1.51-1.38 2.83v6.5c0 1.32.56 2.2 1.38 2.83.89.48 1.51 1.38 2.08 1.96 2.56.83.18 1.89.15 3.92.38 2.92.13 1.11.27 2.21.3 3.34.45l.44.24c.72.36 1.47.56 2.28.56 3.47 0 .78-.07 1.53-.2 2.25-.56.72-.36 1.47-.56 2.28-.56.83 0 1.64-.15 2.33-.44l.45-.24c.59-.3.98-.89 1.03-2.2.08-2.1.16-4.23.17-6.34 0-.03.06-.09.15-.22-.25-.22-.23-.37-.61-.64-.97-1.04-1.92-.45-.89-.71-1.51-1.61-1.96-2.56-.48-1.03-.56-2.09-.38-2.92.2-.85.62-1.38 1.51-1.38 2.83v6.5c0 1.32.56 2.2 1.38 2.83.89.48 1.51 1.38 2.08 1.96 2.56.83.18 1.89.15 3.92.38 2.92.13 1.11.27 2.21.3 3.34.45l.44.24c.72.36 1.47.56 2.28.56 3.47 0 .78-.07 1.53-.2 2.25-.56z" />
            </svg>
            <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
                {{ __('user::auth.login.with_google') }}
            </span>
        </button>
        
        <button
            type="button"
            class="w-full flex items-center justify-center gap-3 py-3 px-4 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-xl hover:border-gray-300 dark:hover:border-gray-600 hover:shadow-md transition-all duration-200 group"
        >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                <path d="M12 0c-6.626 0-12 5.373-12 12 0 5.302 3.438 9.8 8.207 11.387.599.111.793-.261.793-.577v-2.234c-3.338.726-4.033-1.416-4.033-1.416-.546-1.387-1.333-1.756-1.333-1.756-1.089-.746-1.333-1.756-1.333-1.756C4.537 8.827 5.232 8.11 5.232 8.11c-.546 1.089-.555 1.416-.555 1.416 0 .662 0 1.532.27 1.532.27v2.234c0 .316-.194.466-.194.577.793-.577 1.387 0 5.874-2.886 7.726-6.626C20.8 6.4 17.795 2.25 12 2.25z" />
            </svg>
            <span class="font-medium text-gray-700 dark:text-gray-300 group-hover:text-gray-900 dark:group-hover:text-white transition-colors">
                {{ __('user::auth.login.with_github') }}
            </span>
        </button>
    </div>

    <!-- Divider -->
    <div class="relative">
        <div class="absolute inset-0 flex items-center">
            <div class="w-full border-t border-gray-300 dark:border-gray-600"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-4 bg-transparent text-gray-500 dark:text-gray-400">
                {{ __('user::auth.login.or_continue_with') }}
            </span>
        </div>
    </div>

    <!-- Login Form -->
    <form wire:submit.prevent="save" class="space-y-5">
        {{ $this->form }}
        
        <!-- Remember Me & Forgot Password -->
        <div class="flex items-center justify-between mt-3">
            <div class="flex items-center">
                <input id="remember" name="remember" type="checkbox" wire:model="remember" class="h-4 w-4 text-primary-600 focus:ring-2 focus:ring-primary-500 border-gray-300 dark:border-gray-600 rounded">
                <label for="remember" class="ml-2 block text-sm text-gray-700 dark:text-gray-300 select-none cursor-pointer">
                    {{ __('user::auth.login.remember_me') }}
                </label>
            </div>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 font-medium transition-colors duration-200 select-none">
                    {{ __('user::auth.login.forgot_password') }}
                </a>
            @endif
        </div>

        <!-- Submit Button -->
        <button 
            type="submit" 
            wire:loading.attr="disabled"
            class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-primary-600 via-primary-700 to-primary-800 text-white font-semibold hover:from-primary-700 hover:via-primary-800 hover:to-primary-900 focus:outline-none focus:ring-4 focus:ring-primary-500/50 disabled:opacity-50 disabled:cursor-not-allowed transition-all duration-200 ease-in-out shadow-lg hover:shadow-xl transform hover:scale-[1.01] active:scale-[0.99] flex justify-center items-center gap-2 group"
        >
            <svg wire:loading wire:target="save" class="animate-spin h-5 w-5" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span wire:loading.remove wire:target="save" class="flex items-center gap-2">
                {{ __('user::auth.login.submit') }}
                <svg class="w-5 h-5 transition-transform duration-200 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                </svg>
            </span>
            <span wire:loading wire:target="save">{{ __('user::auth.login.logging_in') }}</span>
        </button>
    </form>

    <!-- Register CTA -->
    @if (Route::has('register'))
        <div class="text-center pt-6 border-t border-gray-200 dark:border-gray-700">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                {{ __('user::auth.login.no_account') }}
                <a href="{{ route('register') }}" class="font-semibold text-primary-600 dark:text-primary-400 hover:text-primary-700 dark:hover:text-primary-300 transition-colors duration-200">
                    {{ __('user::auth.login.create_account') }}
                </a>
            </p>
        </div>
    @endif
</div>
