<?php

declare(strict_types=1);

?>
@props(['user' => auth()->user()])

<div class="relative">
    <x-filament::dropdown>
        <x-slot name="trigger">
            <button class="flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 hover:border-gray-300 focus:outline-none focus:text-gray-700 focus:border-gray-300 transition duration-150 ease-in-out">
                @if ($user && $user->profile_photo_url)
                    <img class="h-8 w-8 rounded-full object-cover" src="{{ $user->profile_photo_url }}" alt="{{ $user->name }}" />
                @else
                    <div class="h-8 w-8 rounded-full bg-gray-200 flex items-center justify-center">
                        <x-filament::icon name="heroicon-o-user" class="h-5 w-5 text-gray-400" />
                    </div>
                @endif
                <div class="ml-2">
                    {{ $user?->name ?? __('Guest') }}
                </div>
                <div class="ml-1">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </div>
            </button>
        </x-slot>

        @auth
            <x-filament::dropdown.list.item tag="a" :href="route('profile')" icon="heroicon-o-user">
                {{ __('ui::navigation.profile') }}
            </x-filament::dropdown.list.item>

            <div class="border-t border-gray-200 dark:border-gray-700 my-1"></div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <x-filament::dropdown.list.item
                    tag="a"
                    :href="route('logout')"
                    icon="heroicon-o-logout"
                    x-on:click.prevent="document.getElementById('logout-form').submit()"
                >
                    {{ __('ui::navigation.logout') }}
                </x-filament::dropdown.list.item>
            </form>
        @else
            <x-filament::dropdown.list.item tag="a" :href="route('login')" >
                {{-- icon="heroicon-o-login" --}}
            <x-filament::dropdown.list.item tag="a" :href="route('login')" icon="ui-login">
                {{ __('ui::navigation.login') }}
            </x-filament::dropdown.list.item>

            @if (Route::has('register'))
                <x-filament::dropdown.list.item tag="a" :href="route('register')" icon="heroicon-o-user-add">
                    {{ __('ui::navigation.register') }}
                </x-filament::dropdown.list.item>
            @endif
        @endauth
    </x-filament::dropdown>
</div>
