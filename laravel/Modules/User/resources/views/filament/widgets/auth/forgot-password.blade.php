<?php

declare(strict_types=1);
?>
@push('head')
    {{-- Widget Filament in FO: @filamentStyles non copre le pagine pubbliche
         (nessun panel attivo), quindi il CSS Filament va linkato qui.
         Il widget si auto-provisiona: dove viene montato, gli asset ci sono. --}}
    <link rel="stylesheet" href="{{ asset('css/filament/filament/app.css') }}">
@endpush

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
        {{ $this->form }}

        <div class="flex items-center justify-between">
            <div class="text-sm">
                <a href="{{ route('login') }}" class="font-medium text-primary-700 hover:text-primary-800">
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
