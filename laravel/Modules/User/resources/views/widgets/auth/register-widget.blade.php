<?php

declare(strict_types=1);

?>
@php
    $form = $getForm();
@endphp

<div class="space-y-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold tracking-tight">
            {{ __('user::auth.register.title') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('user::auth.register.subtitle') }}
        </p>
    </div>

    <form wire:submit="register" class="space-y-6">
        {{ $form }}

        <div class="flex items-center justify-between">
            <div class="text-sm">
                <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                    {{ __('user::auth.register.already_registered') }}
                </a>
            </div>
        </div>

        <div>
            <x-filament::button
                type="submit"
                class="w-full"
            >
                {{ __('user::auth.register.submit') }}
            </x-filament::button>
        </div>
    </form>
</div>
