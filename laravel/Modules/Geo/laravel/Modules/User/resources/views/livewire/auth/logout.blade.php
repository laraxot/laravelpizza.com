<?php

declare(strict_types=1);

?>
<x-layouts.app>
    <div class="min-h-screen flex items-center justify-center">
        <div class="max-w-md w-full space-y-8 p-8 bg-white rounded-lg shadow">
            <h2 class="text-2xl font-bold text-gray-900">{{ __('user::auth.logout_success') }}</h2>
            <a href="{{ route('home') }}" class="mt-6 block text-blue-500 underline">{{ __('user::auth.back_to_home') }}</a>
            <div>
                <form wire:submit="logout">
                    <button type="submit" class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium">
                        {{ __('user::auth.logout') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</x-layouts.app>
