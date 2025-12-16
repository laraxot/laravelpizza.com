<?php

declare(strict_types=1);

?>
@php
    $form = $getForm();
@endphp

<div class="space-y-6">
    <div class="text-center">
        <h2 class="text-2xl font-bold tracking-tight">
            {{ __('user::auth.forgot-password.title') }}
        </h2>
        <p class="mt-2 text-sm text-gray-600">
            {{ __('user::auth.forgot-password.subtitle') }}
        </p>
    </div>

    <form wire:submit="sendResetLink" class="space-y-6">
        {{ $form }}

        <div class="flex items-center justify-between">
            <div class="text-sm">
                <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:text-primary-500">
                    {{ __('user::auth.forgot-password.back_to_login') }}
                </a>
            </div>
        </div>

        <div>
            <x-filament::button
                type="submit"
                class="w-full"
            >
                {{ __('user::auth.forgot-password.submit') }}
            </x-filament::button>
        </div>
    </form>
</div>
