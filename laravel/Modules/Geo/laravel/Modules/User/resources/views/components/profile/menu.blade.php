<?php

declare(strict_types=1);

?>
@auth
    <x-filament::dropdown>
        <x-slot name="trigger">
            <button class="flex items-center space-x-2">
                <img class="h-8 w-8 rounded-full" src="{{ auth()->user()->profile_photo_url }}" alt="{{ auth()->user()->name }}" />
                <span class="text-sm font-medium text-gray-700">{{ auth()->user()->name }}</span>
            </button>
        </x-slot>

        <x-filament::dropdown.list>
            <x-filament::dropdown.list.item
                icon="heroicon-m-user"
                :href="route('profile.show')"
            >
                {{ __('Profile') }}
            </x-filament::dropdown.list.item>

            <x-filament::dropdown.list.item
                icon="heroicon-m-cog-6-tooth"
                :href="route('profile.settings')"
            >
                {{ __('Settings') }}
            </x-filament::dropdown.list.item>

            <x-filament::dropdown.list.item
                tag="a"
                :href="route('profile.edit')"
                :active="request()->routeIs('profile.edit')"
            >
                {{ __('ui::navigation.profile') }}
            </x-filament::dropdown.list.item>

            <x-filament::dropdown.list.item
                tag="a"
                :href="route('profile.password')"
                :active="request()->routeIs('profile.password')"
            >
                {{ __('ui::navigation.password') }}
            </x-filament::dropdown.list.item>

            <x-filament::dropdown.list.item
                tag="a"
                :href="route('profile.two-factor')"
                :active="request()->routeIs('profile.two-factor')"
            >
                {{ __('ui::navigation.two_factor') }}
            </x-filament::dropdown.list.item>

            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

            <x-filament::dropdown.list.item
                icon="heroicon-m-arrow-right-on-rectangle"
                :href="route('logout')"
                x-on:click.prevent="$el.closest('form').submit()"
            >
                {{ __('Log Out') }}
            </x-filament::dropdown.list.item>
        </x-filament::dropdown.list>
    </x-filament::dropdown>
@else
    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">{{ __('Log in') }}</a>
    <a href="{{ route('register') }}" class="text-sm font-medium text-gray-700 hover:text-gray-900">{{ __('Register') }}</a>
@endauth
