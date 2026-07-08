<?php

declare(strict_types=1);

?>
<div>
    <form wire:submit="login" class="space-y-6">
        <!-- Email -->
        <div>
            <label for="email" class="block text-sm font-medium text-gray-700">
                {{ __('user::auth.login.email') }}
            </label>
            <div class="mt-1">
                <input wire:model="email" id="email" type="email" autocomplete="email" required
                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-primary-500 sm:text-sm"
                    placeholder="{{ __('user::auth.login.email_placeholder') }}">
            </div>
            @error('email')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-sm font-medium text-gray-700">
                {{ __('user::auth.login.password') }}
            </label>
            <div class="mt-1">
                <input wire:model="password" id="password" type="password" autocomplete="current-password" required
                    class="block w-full appearance-none rounded-md border border-gray-300 px-3 py-2 placeholder-gray-400 shadow-sm focus:border-primary-500 focus:outline-none focus:ring-primary-500 sm:text-sm"
                    placeholder="{{ __('user::auth.login.password_placeholder') }}">
            </div>
            @error('password')
                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <input wire:model="remember" id="remember" type="checkbox"
                    class="h-4 w-4 rounded border-gray-300 text-primary-600 focus:ring-primary-500">
                <label for="remember" class="ml-2 block text-sm text-gray-900">
                    {{ __('user::auth.login.remember') }}
                </label>
            </div>

            <div class="text-sm">
                <a href="{{ route('password.request') }}" class="font-medium text-primary-600 hover:text-primary-500">
                    {{ __('user::auth.login.forgot_password') }}
                </a>
            </div>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit"
                class="flex w-full justify-center rounded-md border border-transparent bg-primary-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-offset-2">
                {{ __('user::auth.login.submit') }}
            </button>
        </div>

        <!-- Register Link -->
        <div class="text-center">
            <p class="text-sm text-gray-600">
                {{ __('user::auth.login.no_account') }}
                <a href="{{ route('register') }}" class="font-medium text-primary-600 hover:text-primary-500">
                    {{ __('user::auth.login.register') }}
                </a>
            </p>
        </div>
    </form>
</div>
